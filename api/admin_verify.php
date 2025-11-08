<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/admin_functions.php';

header('Content-Type: application/json');

// Security check
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$action = sanitize($data['action'] ?? '');
$teacher_id = intval($data['teacher_id'] ?? 0);
$admin_id = getCurrentUserId();

if (empty($action) || $teacher_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if ($action === 'approve') {
    $result = approveTeacherVerification($teacher_id, $admin_id);
    echo json_encode($result);
} elseif ($action === 'reject') {
    $reason = sanitize($data['reason'] ?? '');
    $result = rejectTeacherVerification($teacher_id, $admin_id, $reason);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

