<?php
// Quick script to get password hash
// Open this file in your browser: http://localhost/devkada_gitngo/database/get_hash.php

$password = 'password123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Password Hash Generator</h2>";
echo "<p><strong>Password:</strong> {$password}</p>";
echo "<p><strong>Hash:</strong></p>";
echo "<textarea style='width: 100%; height: 50px; font-family: monospace;'>{$hash}</textarea>";
echo "<p>Copy the hash above and replace all password hashes in seed.sql</p>";
echo "<p>Or use this hash directly in your seed.sql file.</p>";

