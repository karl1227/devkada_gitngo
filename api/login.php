<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$email = sanitize($data['email'] ?? '');
$password = $data['password'] ?? '';
$role = sanitize($data['role'] ?? '');

if (empty($email) || empty($password) || empty($role)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

$result = login($email, $password, $role);

if ($result['success']) {
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'role' => $role,
        'redirect' => $role === 'parent' ? 'parent/dashboard.php' : 'teacher/dashboard.php'
    ]);
} else {
    echo json_encode($result);
}

