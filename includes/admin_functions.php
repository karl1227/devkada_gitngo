<?php
// Admin Functions
require_once __DIR__ . '/../config/config.php';

// Get admin dashboard stats
function getAdminDashboardStats() {
    $db = getDB();
    
    $stats = [];
    
    // Total users
    $result = $db->query("SELECT COUNT(*) as total FROM users");
    $stats['total_users'] = $result->fetch_assoc()['total'];
    
    // Verified teachers
    $result = $db->query("SELECT COUNT(*) as total FROM teachers WHERE verification_status = 'approved'");
    $stats['verified_teachers'] = $result->fetch_assoc()['total'];
    
    // Active sessions
    $result = $db->query("SELECT COUNT(*) as total FROM sessions WHERE status IN ('pending', 'confirmed')");
    $stats['active_sessions'] = $result->fetch_assoc()['total'];
    
    // Pending verifications
    $result = $db->query("SELECT COUNT(*) as total FROM teachers WHERE verification_status = 'pending'");
    $stats['pending_verifications'] = $result->fetch_assoc()['total'];
    
    // Users this month
    $result = $db->query("SELECT COUNT(*) as total FROM users WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())");
    $stats['users_this_month'] = $result->fetch_assoc()['total'];
    
    // Teachers this month
    $result = $db->query("SELECT COUNT(*) as total FROM teachers WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())");
    $stats['teachers_this_month'] = $result->fetch_assoc()['total'];
    
    // Sessions this month
    $result = $db->query("SELECT COUNT(*) as total FROM sessions WHERE MONTH(session_date) = MONTH(CURDATE()) AND YEAR(session_date) = YEAR(CURDATE())");
    $stats['sessions_this_month'] = $result->fetch_assoc()['total'];
    
    return $stats;
}

// Get recent teacher applications
function getRecentTeacherApplications($limit = 10) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT t.*, u.full_name, u.email, u.created_at as applied_at
        FROM teachers t
        JOIN users u ON t.user_id = u.id
        WHERE t.verification_status = 'pending'
        ORDER BY u.created_at DESC
        LIMIT ?
    ");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $applications = [];
    while ($row = $result->fetch_assoc()) {
        $applications[] = $row;
    }
    $stmt->close();
    return $applications;
}

// Get platform activity
function getPlatformActivity($limit = 10) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT action, description, created_at, user_id
        FROM system_logs
        ORDER BY created_at DESC
        LIMIT ?
    ");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $activities = [];
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
    $stmt->close();
    return $activities;
}

// Get all users with pagination
function getAllUsers($page = 1, $per_page = 20, $search = '', $role = '', $status = '') {
    $db = getDB();
    $offset = ($page - 1) * $per_page;
    
    $sql = "SELECT * FROM users WHERE 1=1";
    $params = [];
    $types = '';
    
    if (!empty($search)) {
        $sql .= " AND (full_name LIKE ? OR email LIKE ?)";
        $search_param = "%{$search}%";
        $params[] = $search_param;
        $params[] = $search_param;
        $types .= 'ss';
    }
    
    if (!empty($role)) {
        $sql .= " AND role = ?";
        $params[] = $role;
        $types .= 's';
    }
    
    if (!empty($status)) {
        $sql .= " AND status = ?";
        $params[] = $status;
        $types .= 's';
    }
    
    $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $params[] = $per_page;
    $params[] = $offset;
    $types .= 'ii';
    
    $stmt = $db->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    $stmt->close();
    
    // Get total count
    $count_sql = "SELECT COUNT(*) as total FROM users WHERE 1=1";
    $count_params = [];
    $count_types = '';
    
    if (!empty($search)) {
        $count_sql .= " AND (full_name LIKE ? OR email LIKE ?)";
        $search_param = "%{$search}%";
        $count_params[] = $search_param;
        $count_params[] = $search_param;
        $count_types .= 'ss';
    }
    if (!empty($role)) {
        $count_sql .= " AND role = ?";
        $count_params[] = $role;
        $count_types .= 's';
    }
    if (!empty($status)) {
        $count_sql .= " AND status = ?";
        $count_params[] = $status;
        $count_types .= 's';
    }
    
    $count_stmt = $db->prepare($count_sql);
    if (!empty($count_params)) {
        $count_stmt->bind_param($count_types, ...$count_params);
    }
    $count_stmt->execute();
    $total = $count_stmt->get_result()->fetch_assoc()['total'];
    $count_stmt->close();
    
    return ['users' => $users, 'total' => $total];
}

// Get pending verifications
function getPendingVerifications() {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT t.*, u.full_name, u.email, u.created_at as applied_at
        FROM teachers t
        JOIN users u ON t.user_id = u.id
        WHERE t.verification_status = 'pending'
        ORDER BY u.created_at ASC
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $verifications = [];
    while ($row = $result->fetch_assoc()) {
        $verifications[] = $row;
    }
    $stmt->close();
    return $verifications;
}

// Approve teacher verification
function approveTeacherVerification($teacher_id, $admin_id) {
    $db = getDB();
    $db->begin_transaction();
    
    try {
        // Update teacher verification status
        $stmt = $db->prepare("UPDATE teachers SET verification_status = 'approved', verified_at = NOW(), verified_by = ? WHERE id = ?");
        $stmt->bind_param("ii", $admin_id, $teacher_id);
        $stmt->execute();
        $stmt->close();
        
        // Update user status to active
        $stmt = $db->prepare("UPDATE users u JOIN teachers t ON u.id = t.user_id SET u.status = 'active' WHERE t.id = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $stmt->close();
        
        // Get teacher user_id for notification
        $stmt = $db->prepare("SELECT user_id FROM teachers WHERE id = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $teacher = $result->fetch_assoc();
        $stmt->close();
        
        // Create notification
        if ($teacher) {
            createNotification($teacher['user_id'], 'verification_approved', 'Verification Approved', 'Your teacher account has been verified and approved!');
        }
        
        $db->commit();
        
        logActivity('teacher_approved', "Teacher verification approved: Teacher ID {$teacher_id}", $admin_id);
        
        return ['success' => true, 'message' => 'Teacher verification approved successfully'];
    } catch (Exception $e) {
        $db->rollback();
        return ['success' => false, 'message' => 'Failed to approve verification'];
    }
}

// Reject teacher verification
function rejectTeacherVerification($teacher_id, $admin_id, $reason = '') {
    $db = getDB();
    $db->begin_transaction();
    
    try {
        // Update teacher verification status
        $stmt = $db->prepare("UPDATE teachers SET verification_status = 'rejected', verified_at = NOW(), verified_by = ? WHERE id = ?");
        $stmt->bind_param("ii", $admin_id, $teacher_id);
        $stmt->execute();
        $stmt->close();
        
        // Update user status to rejected
        $stmt = $db->prepare("UPDATE users u JOIN teachers t ON u.id = t.user_id SET u.status = 'rejected' WHERE t.id = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $stmt->close();
        
        // Get teacher user_id for notification
        $stmt = $db->prepare("SELECT user_id FROM teachers WHERE id = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $teacher = $result->fetch_assoc();
        $stmt->close();
        
        // Create notification
        if ($teacher) {
            createNotification($teacher['user_id'], 'verification_rejected', 'Verification Rejected', 'Your teacher application has been rejected. ' . $reason);
        }
        
        $db->commit();
        
        logActivity('teacher_rejected', "Teacher verification rejected: Teacher ID {$teacher_id}", $admin_id);
        
        return ['success' => true, 'message' => 'Teacher verification rejected'];
    } catch (Exception $e) {
        $db->rollback();
        return ['success' => false, 'message' => 'Failed to reject verification'];
    }
}

// Get system logs
function getSystemLogs($page = 1, $per_page = 50, $action_filter = '') {
    $db = getDB();
    $offset = ($page - 1) * $per_page;
    
    $sql = "SELECT sl.*, u.full_name, u.email, u.role 
            FROM system_logs sl
            LEFT JOIN users u ON sl.user_id = u.id
            WHERE 1=1";
    $params = [];
    $types = '';
    
    if (!empty($action_filter)) {
        $sql .= " AND sl.action = ?";
        $params[] = $action_filter;
        $types .= 's';
    }
    
    $sql .= " ORDER BY sl.created_at DESC LIMIT ? OFFSET ?";
    $params[] = $per_page;
    $params[] = $offset;
    $types .= 'ii';
    
    $stmt = $db->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
    $stmt->close();
    
    // Get total count
    $count_sql = "SELECT COUNT(*) as total FROM system_logs WHERE 1=1";
    if (!empty($action_filter)) {
        $count_sql .= " AND action = ?";
    }
    
    $count_stmt = $db->prepare($count_sql);
    if (!empty($action_filter)) {
        $count_stmt->bind_param("s", $action_filter);
    }
    $count_stmt->execute();
    $total = $count_stmt->get_result()->fetch_assoc()['total'];
    $count_stmt->close();
    
    return ['logs' => $logs, 'total' => $total];
}

// Update user status
function updateUserStatus($user_id, $status, $admin_id) {
    $db = getDB();
    $stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    
    if ($result) {
        logActivity('user_status_updated', "User status updated: User ID {$user_id} to {$status}", $admin_id);
        return ['success' => true, 'message' => 'User status updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to update user status'];
    }
}

// Delete user
function deleteUser($user_id, $admin_id) {
    $db = getDB();
    
    // Get user info for logging
    $user = getUserData($user_id);
    
    // Delete user (cascade will handle related records)
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $result = $stmt->execute();
    $stmt->close();
    
    if ($result) {
        logActivity('user_deleted', "User deleted: {$user['email']}", $admin_id);
        return ['success' => true, 'message' => 'User deleted successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to delete user'];
    }
}

// Get analytics data
function getAnalyticsData() {
    $db = getDB();
    
    $analytics = [];
    
    // User growth (last 6 months)
    $result = $db->query("
        SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
        FROM users
        WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month ASC
    ");
    $analytics['user_growth'] = [];
    while ($row = $result->fetch_assoc()) {
        $analytics['user_growth'][] = $row;
    }
    
    // Users by role
    $result = $db->query("
        SELECT role, COUNT(*) as count
        FROM users
        GROUP BY role
    ");
    $analytics['users_by_role'] = [];
    while ($row = $result->fetch_assoc()) {
        $analytics['users_by_role'][] = $row;
    }
    
    // Teacher verification status
    $result = $db->query("
        SELECT verification_status, COUNT(*) as count
        FROM teachers
        GROUP BY verification_status
    ");
    $analytics['teacher_verification'] = [];
    while ($row = $result->fetch_assoc()) {
        $analytics['teacher_verification'][] = $row;
    }
    
    // Session status
    $result = $db->query("
        SELECT status, COUNT(*) as count
        FROM sessions
        GROUP BY status
    ");
    $analytics['session_status'] = [];
    while ($row = $result->fetch_assoc()) {
        $analytics['session_status'][] = $row;
    }
    
    return $analytics;
}

