<?php
// Authentication Functions
require_once __DIR__ . '/../config/config.php';

function login($email, $password, $role) {
    $db = getDB();
    $stmt = $db->prepare("SELECT id, email, password, full_name, role, status FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            if ($user['status'] === 'active' || ($user['role'] === 'teacher' && $user['status'] === 'pending')) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_role'] = $user['role'];
                
                // Update last login
                $updateStmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $updateStmt->bind_param("i", $user['id']);
                $updateStmt->execute();
                $updateStmt->close();
                
                logActivity('login', "User logged in: {$user['email']}", $user['id']);
                
                $stmt->close();
                return ['success' => true, 'user' => $user];
            } else {
                $stmt->close();
                return ['success' => false, 'message' => 'Your account is not active. Please contact support.'];
            }
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }
    } else {
        $stmt->close();
        return ['success' => false, 'message' => 'Invalid email or password.'];
    }
}

function registerParent($full_name, $email, $password, $child_name, $child_age) {
    $db = getDB();
    
    // Check if email already exists
    $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        $checkStmt->close();
        return ['success' => false, 'message' => 'Email already registered.'];
    }
    $checkStmt->close();
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Start transaction
    $db->begin_transaction();
    
    try {
        // Insert user
        $userStmt = $db->prepare("INSERT INTO users (email, password, full_name, role, status) VALUES (?, ?, ?, 'parent', 'active')");
        $userStmt->bind_param("sss", $email, $hashed_password, $full_name);
        $userStmt->execute();
        $parent_id = $db->insert_id;
        $userStmt->close();
        
        // Insert child
        $childStmt = $db->prepare("INSERT INTO children (parent_id, name, age) VALUES (?, ?, ?)");
        $childStmt->bind_param("isi", $parent_id, $child_name, $child_age);
        $childStmt->execute();
        $childStmt->close();
        
        $db->commit();
        
        logActivity('register', "New parent registered: {$email}", $parent_id);
        
        return ['success' => true, 'user_id' => $parent_id, 'message' => 'Account created successfully!'];
    } catch (Exception $e) {
        $db->rollback();
        error_log("Parent registration error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
    }
}

function registerTeacher($full_name, $email, $password, $specialization, $location, $license_file = null, $specializations = []) {
    $db = getDB();
    
    // Check if email already exists
    $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows > 0) {
        $checkStmt->close();
        return ['success' => false, 'message' => 'Email already registered.'];
    }
    $checkStmt->close();
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Start transaction
    $db->begin_transaction();
    
    try {
        // Insert user
        $userStmt = $db->prepare("INSERT INTO users (email, password, full_name, role, status) VALUES (?, ?, ?, 'teacher', 'pending')");
        $userStmt->bind_param("sss", $email, $hashed_password, $full_name);
        $userStmt->execute();
        $user_id = $db->insert_id;
        $userStmt->close();
        
        // Insert teacher
        $hourly_rate = 45.00; // Default rate
        $teacherStmt = $db->prepare("INSERT INTO teachers (user_id, specialization, location, hourly_rate, license_file, verification_status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $teacherStmt->bind_param("issds", $user_id, $specialization, $location, $hourly_rate, $license_file);
        $teacherStmt->execute();
        $teacher_id = $db->insert_id;
        $teacherStmt->close();
        
        // Insert specializations (use provided array or single specialization)
        $specs_to_insert = !empty($specializations) ? $specializations : [$specialization];
        
        // Remove duplicates and empty values
        $specs_to_insert = array_unique(array_filter($specs_to_insert));
        
        if (!empty($specs_to_insert)) {
            $specStmt = $db->prepare("INSERT INTO teacher_specializations (teacher_id, specialization) VALUES (?, ?)");
            foreach ($specs_to_insert as $spec) {
                $spec = trim($spec);
                if (!empty($spec)) {
                    $specStmt->bind_param("is", $teacher_id, $spec);
                    try {
                        $specStmt->execute();
                    } catch (Exception $e) {
                        // Ignore duplicate entry errors (UNIQUE constraint)
                        if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                            throw $e;
                        }
                    }
                }
            }
            $specStmt->close();
        }
        
        $db->commit();
        
        logActivity('register', "New teacher registered: {$email}", $user_id);
        
        // Notify admin
        $adminStmt = $db->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        $adminStmt->execute();
        $adminResult = $adminStmt->get_result();
        if ($adminResult->num_rows > 0) {
            $admin = $adminResult->fetch_assoc();
            createNotification($admin['id'], 'teacher_application', 'New Teacher Application', "{$full_name} has submitted a teacher application for review.");
        }
        $adminStmt->close();
        
        return ['success' => true, 'user_id' => $user_id, 'message' => 'Application submitted successfully! Your account will be reviewed within 1-2 business days.'];
    } catch (Exception $e) {
        $db->rollback();
        error_log("Registration error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
    }
}

function logout() {
    if (isset($_SESSION['user_id'])) {
        logActivity('logout', "User logged out: {$_SESSION['user_email']}", $_SESSION['user_id']);
    }
    
    session_unset();
    session_destroy();
    
    redirect(BASE_URL . 'signin.php');
}

function getUserData($user_id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user;
}

