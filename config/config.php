<?php
// Application Configuration
session_start();

// Base URL
define('BASE_URL', 'http://localhost/devkada_gitngo/');
define('UPLOAD_PATH', __DIR__ . '/../uploads/');

// OpenAI API Configuration
// Get your API key from: https://platform.openai.com/api-keys
// Add your API key here or set it as an environment variable
define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: 'YOUR_OPENAI_API_KEY_HERE');

// Timezone
date_default_timezone_set('America/Los_Angeles');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database
require_once __DIR__ . '/database.php';

// Helper functions
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'signin.php');
        exit();
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user_role'] !== $role) {
        header('Location: ' . BASE_URL . 'index.php');
        exit();
    }
}

// Enhanced admin security check
function requireAdmin() {
    requireLogin();
    if ($_SESSION['user_role'] !== 'admin') {
        // Log unauthorized access attempt
        logActivity('unauthorized_admin_access', "Unauthorized admin access attempt from user ID: {$_SESSION['user_id']}", $_SESSION['user_id']);
        header('Location: ' . BASE_URL . 'admin/login.php');
        exit();
    }
    
    // Additional security: Check if admin account is still active
    $db = getDB();
    $stmt = $db->prepare("SELECT status FROM users WHERE id = ? AND role = 'admin'");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    
    if (!$user || $user['status'] !== 'active') {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'admin/login.php');
        exit();
    }
}

function requireRoles($roles) {
    requireLogin();
    if (!in_array($_SESSION['user_role'], $roles)) {
        header('Location: ' . BASE_URL . 'index.php');
        exit();
    }
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentUserRole() {
    return $_SESSION['user_role'] ?? null;
}

function redirect($url) {
    header('Location: ' . $url);
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

function formatDateTime($datetime) {
    return date('M d, Y h:i A', strtotime($datetime));
}

function formatTime($time) {
    return date('h:i A', strtotime($time));
}

// Log system activity
function logActivity($action, $description = '', $user_id = null) {
    $db = getDB();
    $user_id = $user_id ?? getCurrentUserId();
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    $stmt = $db->prepare("INSERT INTO system_logs (user_id, action, description, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $action, $description, $ip_address, $user_agent);
    $stmt->execute();
    $stmt->close();
}

// Create notification
function createNotification($user_id, $type, $title, $message, $link = null) {
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO notifications (user_id, type, title, message, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $type, $title, $message, $link);
    $stmt->execute();
    $stmt->close();
}

