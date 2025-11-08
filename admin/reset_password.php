<?php
/**
 * Admin Password Reset Script
 * Run this once to set/reset the admin password
 * DELETE THIS FILE AFTER USE FOR SECURITY
 */

require_once __DIR__ . '/../config/config.php';

$email = 'admin@learnsafe.ai';
$password = 'admin123';

// Generate new password hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$db = getDB();

// Check if admin exists
$stmt = $db->prepare("SELECT id, email, status FROM users WHERE email = ? AND role = 'admin'");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Admin Account Setup</h2>";
echo "<hr>";

if ($result->num_rows > 0) {
    // Update existing admin
    $user = $result->fetch_assoc();
    $updateStmt = $db->prepare("UPDATE users SET password = ?, status = 'active' WHERE id = ?");
    $updateStmt->bind_param("si", $hashed_password, $user['id']);
    $updateStmt->execute();
    $updateStmt->close();
    
    echo "<p style='color: green;'><strong>✓ Admin password updated successfully!</strong></p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo "<p><strong>Password:</strong> " . htmlspecialchars($password) . "</p>";
    echo "<p><strong>Status:</strong> " . htmlspecialchars($user['status']) . " → active</p>";
    echo "<p><strong>New Hash:</strong> " . htmlspecialchars($hashed_password) . "</p>";
} else {
    // Create admin if doesn't exist
    $insertStmt = $db->prepare("INSERT INTO users (email, password, full_name, role, status) VALUES (?, ?, 'System Admin', 'admin', 'active')");
    $insertStmt->bind_param("ss", $email, $hashed_password);
    
    if ($insertStmt->execute()) {
        echo "<p style='color: green;'><strong>✓ Admin user created successfully!</strong></p>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
        echo "<p><strong>Password:</strong> " . htmlspecialchars($password) . "</p>";
        echo "<p><strong>Status:</strong> active</p>";
        echo "<p><strong>Hash:</strong> " . htmlspecialchars($hashed_password) . "</p>";
    } else {
        echo "<p style='color: red;'><strong>✗ Error creating admin user:</strong> " . $insertStmt->error . "</p>";
    }
    $insertStmt->close();
}

$stmt->close();

// Verify the password works
echo "<hr>";
echo "<h3>Verification Test</h3>";
if (password_verify($password, $hashed_password)) {
    echo "<p style='color: green;'>✓ Password hash verification: <strong>SUCCESS</strong></p>";
} else {
    echo "<p style='color: red;'>✗ Password hash verification: <strong>FAILED</strong></p>";
}

// Test login function
echo "<hr>";
echo "<h3>Login Function Test</h3>";
require_once __DIR__ . '/../includes/auth.php';
$testResult = login($email, $password, 'admin');
if ($testResult['success']) {
    echo "<p style='color: green;'>✓ Login function test: <strong>SUCCESS</strong></p>";
    echo "<p>You can now log in at: <a href='login.php'>admin/login.php</a></p>";
} else {
    echo "<p style='color: red;'>✗ Login function test: <strong>FAILED</strong></p>";
    echo "<p>Error: " . htmlspecialchars($testResult['message']) . "</p>";
}

echo "<hr>";
echo "<p style='color: red;'><strong>⚠️ IMPORTANT: Delete this file (admin/reset_password.php) after use for security!</strong></p>";
?>

