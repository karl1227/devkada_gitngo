<?php
/**
 * Rate Limiting for Chat API
 * Prevents abuse by limiting requests per user session
 */

session_start();

// Configuration
$rate_limit = 20; // Maximum requests
$time_window = 60; // Time window in seconds (1 minute)

// Initialize session array if not exists
if (!isset($_SESSION['chat_requests'])) {
    $_SESSION['chat_requests'] = [];
}

// Clean old requests outside the time window
$current_time = time();
$_SESSION['chat_requests'] = array_filter(
    $_SESSION['chat_requests'],
    function($timestamp) use ($current_time, $time_window) {
        return ($current_time - $timestamp) < $time_window;
    }
);

// Check if rate limit exceeded
if (count($_SESSION['chat_requests']) >= $rate_limit) {
    http_response_code(429);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Too many requests. Please wait a moment before sending another message.'
    ]);
    exit;
}

// Add current request timestamp
$_SESSION['chat_requests'][] = $current_time;

