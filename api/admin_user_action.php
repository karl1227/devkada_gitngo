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
$admin_id = getCurrentUserId();

if ($action === 'update_status') {
    $user_id = intval($data['user_id'] ?? 0);
    $status = sanitize($data['status'] ?? '';
    
    if ($user_id <= 0 || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }
    
    // Prevent admin from changing their own status
    if ($user_id == $admin_id) {
        echo json_encode(['success' => false, 'message' => 'Cannot change your own status']);
        exit;
    }
    
    $result = updateUserStatus($user_id, $status, $admin_id);
    echo json_encode($result);
    
} elseif ($action === 'delete') {
    $user_id = intval($data['user_id'] ?? 0);
    
    if ($user_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }
    
    // Prevent admin from deleting themselves
    if ($user_id == $admin_id) {
        echo json_encode(['success' => false, 'message' => 'Cannot delete your own account']);
        exit;
    }
    
    $result = deleteUser($user_id, $admin_id);
    echo json_encode($result);
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

