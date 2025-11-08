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
$teacher_id = intval($data['teacher_id'] ?? 0);
$child_id = intval($data['child_id'] ?? 0);
$session_date = sanitize($data['session_date'] ?? '');
$session_time = sanitize($data['session_time'] ?? '');
$duration_minutes = intval($data['duration_minutes'] ?? 60);
$amount = floatval($data['amount'] ?? 0);
$payment_method = sanitize($data['payment_method'] ?? '');

// Validation
if (empty($teacher_id) || empty($child_id) || empty($session_date) || empty($session_time) || $amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Verify child belongs to parent
$db = getDB();
$stmt = $db->prepare("SELECT id FROM children WHERE id = ? AND parent_id = ?");
$stmt->bind_param("ii", $child_id, $parent_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'Invalid child selected']);
    exit;
}
$stmt->close();

// Book the session
$result = bookSession($parent_id, $teacher_id, $child_id, $session_date, $session_time, $duration_minutes, $amount);

if ($result['success']) {
    // Update payment method if provided
    if (!empty($payment_method)) {
        $session_id = $result['session_id'];
        $stmt = $db->prepare("UPDATE sessions SET payment_method = ? WHERE id = ?");
        $stmt->bind_param("si", $payment_method, $session_id);
        $stmt->execute();
        $stmt->close();
    }
    
    // Create reminder notification (24 hours before)
    $session_datetime = strtotime($session_date . ' ' . $session_time);
    $reminder_time = $session_datetime - (24 * 60 * 60); // 24 hours before
    if ($reminder_time > time()) {
        // Schedule reminder (you can implement a cron job or queue system for this)
        createNotification($parent_id, 'session_reminder', 'Session Reminder', 
            "You have a session scheduled for " . date('M d, Y h:i A', $session_datetime) . ". Don't forget!",
            'parent/schedule.php');
    }
    
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode($result);
}

