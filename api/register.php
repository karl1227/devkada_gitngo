<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Check if data is JSON or FormData
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (strpos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents('php://input'), true);
} else {
    $data = $_POST;
}

$type = sanitize($data['type'] ?? '');

if ($type === 'parent') {
    $full_name = sanitize($data['full_name'] ?? '');
    $email = sanitize($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $confirm_password = $data['confirm_password'] ?? '';
    $child_name = sanitize($data['child_name'] ?? '');
    $child_age = intval($data['child_age'] ?? 0);
    
    if (empty($full_name) || empty($email) || empty($password) || empty($child_name) || $child_age <= 0) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }
    
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
        exit;
    }
    
    $result = registerParent($full_name, $email, $password, $child_name, $child_age);
    echo json_encode($result);
    
} elseif ($type === 'teacher') {
    $full_name = sanitize($data['full_name'] ?? '');
    $email = sanitize($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $confirm_password = $data['confirm_password'] ?? '';
    $specialization = sanitize($data['specialization'] ?? '');
    $location = sanitize($data['location'] ?? '');
    
    if (empty($full_name) || empty($email) || empty($password) || empty($specialization) || empty($location)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }
    
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
        exit;
    }
    
    // Handle file upload
    $license_file = null;
    if (isset($_FILES['license_file']) && $_FILES['license_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../uploads/licenses/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['license_file']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $file_name = uniqid() . '_' . time() . '.' . $file_extension;
            $file_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['license_file']['tmp_name'], $file_path)) {
                $license_file = 'uploads/licenses/' . $file_name;
            }
        }
    }
    
    $result = registerTeacher($full_name, $email, $password, $specialization, $location, $license_file);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid registration type']);
}

