<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('teacher');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$teacher = getTeacherByUserId($user_id);

// Get user initials for avatar
$initials = '';
if ($user && $user['full_name']) {
    $name_parts = explode(' ', $user['full_name']);
    $initials = strtoupper(substr($name_parts[0], 0, 1) . (isset($name_parts[1]) ? substr($name_parts[1], 0, 1) : ''));
}

$verification_status = $teacher['verification_status'] ?? 'pending';
$verified_at = $teacher['verified_at'] ?? null;
$license_file = $teacher['license_file'] ?? null;

// Status colors
$status_colors = [
    'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
    'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-clock'],
    'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-times-circle']
];

$status_labels = [
    'approved' => 'Verified',
    'pending' => 'Pending Review',
    'rejected' => 'Rejected'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification - LEARNSAFE.AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-heart {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Top Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 gradient-heart rounded-lg flex items-center justify-center">
                    <i class="fas fa-heart text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-blue-600">LEARNSAFE.AI</span>
            </div>
            <div class="flex-1 text-center">
                <p class="text-gray-800 font-semibold">Welcome Back, <?php echo htmlspecialchars($user['full_name'] ?? 'Teacher'); ?>!</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="../api/logout.php" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-sign-out-alt text-xl cursor-pointer" title="Logout"></i>
                </a>
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <span class="text-purple-600 font-bold"><?php echo htmlspecialchars($initials); ?></span>
                </div>
                <span class="text-gray-800 font-semibold"><?php echo htmlspecialchars($user['full_name'] ?? 'Teacher'); ?></span>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Left Sidebar -->
        <aside class="w-64 bg-gray-100 min-h-screen p-6">
            <nav class="space-y-2">
                <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="availability.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-calendar"></i>
                    <span>Availability</span>
                </a>
                <a href="students.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-users"></i>
                    <span>Students</span>
                </a>
                <a href="reports.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                <a href="ai-insights.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-lightbulb"></i>
                    <span>AI Insights</span>
                </a>
                <a href="verification.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
                    <i class="fas fa-check-circle"></i>
                    <span>Verification</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Verification Status</h1>
                <p class="text-gray-600">View and update your verification documents.</p>
            </div>

            <!-- Verification Status -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Account Status</h2>
                    <span class="px-4 py-2 <?php echo $status_colors[$verification_status]['bg']; ?> <?php echo $status_colors[$verification_status]['text']; ?> rounded-full font-semibold">
                        <i class="fas <?php echo $status_colors[$verification_status]['icon']; ?> mr-2"></i><?php echo $status_labels[$verification_status]; ?>
                    </span>
                </div>
                <div class="space-y-4">
                    <?php if ($license_file): ?>
                        <div class="flex items-center justify-between p-4 <?php echo $verification_status === 'approved' ? 'bg-green-50' : 'bg-gray-50'; ?> rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas <?php echo $verification_status === 'approved' ? 'fa-check-circle text-green-500' : 'fa-file-alt text-gray-400'; ?> text-xl"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Teaching License</p>
                                    <?php if ($verified_at): ?>
                                        <p class="text-sm text-gray-600">Verified on <?php echo formatDate($verified_at); ?></p>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-600">Pending review</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ($license_file): ?>
                                <a href="../<?php echo htmlspecialchars($license_file); ?>" target="_blank" class="text-blue-600 hover:underline font-semibold">View</a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-file-alt text-gray-400 text-xl"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Teaching License</p>
                                    <p class="text-sm text-gray-600">No license uploaded</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Update Documents -->
            <?php if ($verification_status !== 'approved'): ?>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Update Documents</h2>
                    <form id="verificationForm" method="POST" action="../api/teacher_update_verification.php" enctype="multipart/form-data">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Teaching License</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer" onclick="document.getElementById('license_file').click()">
                                    <i class="fas fa-upload text-3xl text-gray-400 mb-4"></i>
                                    <p class="text-gray-600 font-semibold mb-2">Click to upload or update</p>
                                    <p class="text-sm text-gray-500">PDF, JPG, or PNG (max 10MB)</p>
                                    <input type="file" id="license_file" name="license_file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" onchange="document.getElementById('licenseFileName').textContent = this.files[0] ? 'Selected: ' + this.files[0].name : ''">
                                    <p id="licenseFileName" class="text-sm text-blue-600 mt-2"></p>
                                </div>
                            </div>
                            <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                Submit for Review
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
