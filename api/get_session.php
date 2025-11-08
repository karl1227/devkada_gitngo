<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

// Check authentication
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$session_id = intval($_GET['id'] ?? 0);

if (empty($session_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Session ID is required']);
    exit;
}

$user_id = getCurrentUserId();
$user_role = getCurrentUserRole();

// Get session - verify ownership based on role
if ($user_role === 'parent') {
    $session = getSessionById($session_id, $user_id);
} else {
    $session = getSessionById($session_id);
}

if (!$session) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Session not found']);
    exit;
}

echo json_encode(['success' => true, 'session' => $session]);

