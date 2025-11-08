<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';

// If already logged in as admin, redirect to dashboard
if (isLoggedIn() && getCurrentUserRole() === 'admin') {
    redirect(BASE_URL . 'admin/dashboard.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'All fields are required';
    } else {
        // Check if admin user exists
        $db = getDB();
        $checkStmt = $db->prepare("SELECT id, email, password, status FROM users WHERE email = ? AND role = 'admin'");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows === 0) {
            $error = 'Admin user not found. Please run admin/reset_password.php to create/reset admin account.';
        } else {
            $result = login($email, $password, 'admin');
            
            if ($result['success']) {
                redirect(BASE_URL . 'admin/dashboard.php');
            } else {
                $error = $result['message'];
            }
        }
        $checkStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - LEARNSAFE.AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-heart {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-50 min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <div class="w-10 h-10 gradient-heart rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
                <span class="text-3xl font-bold text-red-600">LEARNSAFE.AI</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Login</h1>
            <p class="text-gray-600">Secure admin access only</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-red-100">
            <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($success); ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-6">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:outline-none" placeholder="admin@learnsafe.ai" autocomplete="email">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-red-500 focus:outline-none" placeholder="Enter your password" autocomplete="current-password">
                </div>

                <!-- Security Notice -->
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
                        <p class="text-sm text-yellow-700">
                            <strong>Security Notice:</strong> This is a restricted area. Unauthorized access is prohibited and will be logged.
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-red-500 text-white py-3 rounded-lg font-semibold hover:bg-red-600 transition">
                    <i class="fas fa-lock mr-2"></i>Login as Admin
                </button>
            </form>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="../index.php" class="text-gray-600 hover:text-red-600">← Back to Home</a>
            </div>
        </div>

        <!-- Security Footer -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                <i class="fas fa-shield-alt mr-1"></i>
                All access attempts are logged and monitored
            </p>
        </div>
    </div>
</body>
</html>

