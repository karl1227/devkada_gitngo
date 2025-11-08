<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

// Check authentication
if (!isLoggedIn() || getCurrentUserRole() !== 'parent') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$parent_id = getCurrentUserId();
$session_id = intval($data['session_id'] ?? 0);
$reason = sanitize($data['reason'] ?? '');

// Validation
if (empty($session_id)) {
    echo json_encode(['success' => false, 'message' => 'Session ID is required']);
    exit;
}

$db = getDB();

// Verify session belongs to parent
$stmt = $db->prepare("SELECT * FROM sessions WHERE id = ? AND parent_id = ? AND status IN ('pending', 'confirmed')");
$stmt->bind_param("ii", $session_id, $parent_id);
$stmt->execute();
$result = $stmt->get_result();
$session = $result->fetch_assoc();
$stmt->close();

if (!$session) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Session not found or cannot be cancelled']);
    exit;
}

// Cancel session
$stmt = $db->prepare("UPDATE sessions SET status = 'cancelled', notes = CONCAT(COALESCE(notes, ''), '\nCancelled: ', ?), updated_at = NOW() WHERE id = ?");
$notes = !empty($reason) ? "Reason: {$reason}" : "Cancelled by parent";
$stmt->bind_param("si", $notes, $session_id);

if ($stmt->execute()) {
    $stmt->close();
    
    logActivity('session_cancelled', "Session cancelled: Session ID {$session_id}", $parent_id);
    
    // Notify teacher
    $teacher_id = $session['teacher_id'];
    $teacher = getTeacherData($teacher_id);
    if ($teacher) {
        $teacher_user_id = $db->query("SELECT user_id FROM teachers WHERE id = {$teacher_id}")->fetch_assoc()['user_id'];
        createNotification($teacher_user_id, 'session_cancelled', 'Session Cancelled', 
            "A session scheduled for " . date('M d, Y h:i A', strtotime($session['session_date'] . ' ' . $session['session_time'])) . " has been cancelled.",
            'teacher/schedule.php');
    }
    
    // Refund if paid
    if ($session['payment_status'] === 'paid') {
        $stmt = $db->prepare("UPDATE sessions SET payment_status = 'refunded' WHERE id = ?");
        $stmt->bind_param("i", $session_id);
        $stmt->execute();
        $stmt->close();
    }
    
    echo json_encode(['success' => true, 'message' => 'Session cancelled successfully']);
} else {
    $stmt->close();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to cancel session']);
}

