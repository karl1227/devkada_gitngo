<?php
// Quick script to generate password hash for seed data
// Run this script: php generate_password_hash.php

$password = 'password123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: {$password}\n";
echo "Hash: {$hash}\n";
echo "\n";
echo "Copy the hash above and replace the password hash in seed.sql\n";
echo "Or use this hash directly: {$hash}\n";

