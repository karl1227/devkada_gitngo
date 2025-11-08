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
$data = [];

if (strpos($contentType, 'application/json') !== false) {
    // JSON data
    $json_input = file_get_contents('php://input');
    $data = json_decode($json_input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
        exit;
    }
} else {
    // FormData - PHP automatically parses arrays from FormData
    $data = $_POST;
    
    // Debug: Log received data (remove in production)
    // error_log("FormData received: " . print_r($data, true));
}

$type = sanitize($data['type'] ?? '');

if (empty($type)) {
    echo json_encode(['success' => false, 'message' => 'Registration type is required']);
    exit;
}

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
    
    try {
        $result = registerParent($full_name, $email, $password, $child_name, $child_age);
        echo json_encode($result);
    } catch (Exception $e) {
        error_log("Parent registration error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()]);
    }
    
} elseif ($type === 'teacher') {
    $full_name = sanitize($data['full_name'] ?? '');
    $email = sanitize($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $confirm_password = $data['confirm_password'] ?? '';
    $location = sanitize($data['location'] ?? '');
    
    // Get specializations (can be array from checkboxes)
    // When FormData.append('specializations[]', value) is used, PHP parses it as $_POST['specializations'] array
    $specializations = [];
    
    // Check for specializations array (most common case)
    if (isset($data['specializations']) && is_array($data['specializations'])) {
        $specializations = array_map('sanitize', $data['specializations']);
    } elseif (isset($data['specializations']) && !empty($data['specializations'])) {
        // Single value case
        $specializations = [sanitize($data['specializations'])];
    }
    
    // Also check for specializations[] format (some PHP configurations use this)
    if (empty($specializations) && isset($data['specializations[]'])) {
        if (is_array($data['specializations[]'])) {
            $specializations = array_map('sanitize', $data['specializations[]']);
        } else {
            $specializations = [sanitize($data['specializations[]'])];
        }
    }
    
    // Debug: Log received specializations (remove in production)
    // error_log("Received specializations: " . print_r($specializations, true));
    
    if (empty($full_name) || empty($email) || empty($password) || empty($location)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    if (empty($specializations)) {
        echo json_encode(['success' => false, 'message' => 'Please select at least one specialization']);
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
    
    // Use first specialization as primary (for backward compatibility)
    $primary_specialization = $specializations[0];
    
    $result = registerTeacher($full_name, $email, $password, $primary_specialization, $location, $license_file, $specializations);
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid registration type']);
}

