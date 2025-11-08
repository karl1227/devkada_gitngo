<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json');

$teacher_id = intval($_GET['teacher_id'] ?? 0);
$date = sanitize($_GET['date'] ?? '');

if (empty($teacher_id) || empty($date)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Teacher ID and date are required']);
    exit;
}

$db = getDB();
$day_of_week = strtolower(date('l', strtotime($date)));

// Get teacher availability for that day
$availability = getTeacherAvailability($teacher_id, $day_of_week);

if (empty($availability)) {
    echo json_encode(['success' => true, 'slots' => []]);
    exit;
}

// Get existing bookings for that date
$stmt = $db->prepare("
    SELECT session_time, duration_minutes
    FROM sessions
    WHERE teacher_id = ? AND session_date = ?
    AND status IN ('pending', 'confirmed')
");
$stmt->bind_param("is", $teacher_id, $date);
$stmt->execute();
$result = $stmt->get_result();
$bookings = [];
while ($row = $result->fetch_assoc()) {
    $start = strtotime($row['session_time']);
    $end = $start + ($row['duration_minutes'] * 60);
    $bookings[] = ['start' => $start, 'end' => $end];
}
$stmt->close();

// Generate available time slots (every 30 minutes)
$slots = [];
foreach ($availability as $avail) {
    $start = strtotime($avail['start_time']);
    $end = strtotime($avail['end_time']);
    
    $current = $start;
    while ($current < $end) {
        $slot_time = date('H:i:s', $current);
        $slot_end = $current + (60 * 60); // 1 hour slot
        
        // Check if slot conflicts with existing bookings
        $conflict = false;
        foreach ($bookings as $booking) {
            $slot_start_ts = strtotime($date . ' ' . $slot_time);
            if (($slot_start_ts >= $booking['start'] && $slot_start_ts < $booking['end']) ||
                ($slot_end > $booking['start'] && $slot_end <= $booking['end']) ||
                ($slot_start_ts <= $booking['start'] && $slot_end >= $booking['end'])) {
                $conflict = true;
                break;
            }
        }
        
        if (!$conflict && $slot_end <= $end) {
            $slots[] = [
                'time' => date('H:i', $current),
                'time_24' => $slot_time,
                'display' => date('h:i A', $current)
            ];
        }
        
        $current += (30 * 60); // Next slot in 30 minutes
    }
}

echo json_encode(['success' => true, 'slots' => $slots]);

