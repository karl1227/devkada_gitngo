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
$new_date = sanitize($data['new_date'] ?? '');
$new_time = sanitize($data['new_time'] ?? '');

// Validation
if (empty($session_id) || empty($new_date) || empty($new_time)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
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
    echo json_encode(['success' => false, 'message' => 'Session not found or cannot be rescheduled']);
    exit;
}

// Check if new time slot is available
$teacher_id = $session['teacher_id'];
$day_of_week = strtolower(date('l', strtotime($new_date)));
$duration_minutes = $session['duration_minutes'];
$end_time = date('H:i:s', strtotime($new_time . " +{$duration_minutes} minutes"));

// Check teacher availability
$stmt = $db->prepare("
    SELECT * FROM teacher_availability 
    WHERE teacher_id = ? AND day_of_week = ? AND is_available = 1
    AND start_time <= ? AND end_time >= ?
");
$stmt->bind_param("isss", $teacher_id, $day_of_week, $new_time, $end_time);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'Selected time slot is not available']);
    exit;
}
$stmt->close();

// Check for conflicts (excluding current session)
$stmt = $db->prepare("
    SELECT * FROM sessions 
    WHERE teacher_id = ? AND session_date = ? 
    AND status IN ('pending', 'confirmed')
    AND id != ?
    AND (
        (session_time <= ? AND ADDTIME(session_time, SEC_TO_TIME(duration_minutes * 60)) > ?)
        OR (session_time < ? AND ADDTIME(session_time, SEC_TO_TIME(duration_minutes * 60)) >= ?)
    )
");
$stmt->bind_param("isiss", $teacher_id, $new_date, $session_id, $new_time, $new_time, $end_time, $end_time);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();
    echo json_encode(['success' => false, 'message' => 'Time slot is already booked']);
    exit;
}
$stmt->close();

// Update session
$stmt = $db->prepare("UPDATE sessions SET session_date = ?, session_time = ?, updated_at = NOW() WHERE id = ?");
$stmt->bind_param("ssi", $new_date, $new_time, $session_id);

if ($stmt->execute()) {
    $stmt->close();
    
    logActivity('session_rescheduled', "Session rescheduled: Session ID {$session_id}", $parent_id);
    
    // Notify teacher
    $teacher = getTeacherData($teacher_id);
    if ($teacher) {
        $teacher_user_id = $db->query("SELECT user_id FROM teachers WHERE id = {$teacher_id}")->fetch_assoc()['user_id'];
        createNotification($teacher_user_id, 'session_rescheduled', 'Session Rescheduled', 
            "A session has been rescheduled to " . date('M d, Y h:i A', strtotime($new_date . ' ' . $new_time)) . ".",
            'teacher/schedule.php');
    }
    
    // Create reminder for new time
    $session_datetime = strtotime($new_date . ' ' . $new_time);
    $reminder_time = $session_datetime - (24 * 60 * 60);
    if ($reminder_time > time()) {
        createNotification($parent_id, 'session_reminder', 'Session Reminder', 
            "You have a session scheduled for " . date('M d, Y h:i A', $session_datetime) . ". Don't forget!",
            'parent/schedule.php');
    }
    
    echo json_encode(['success' => true, 'message' => 'Session rescheduled successfully!']);
} else {
    $stmt->close();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to reschedule session']);
}

