<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('teacher');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$teacher = getTeacherByUserId($user_id);
$teacher_id = $teacher ? $teacher['id'] : null;
$specializations = $teacher_id ? getTeacherSpecializations($teacher_id) : [];

// Get user initials for avatar
$initials = '';
if ($user && $user['full_name']) {
    $name_parts = explode(' ', $user['full_name']);
    $initials = strtoupper(substr($name_parts[0], 0, 1) . (isset($name_parts[1]) ? substr($name_parts[1], 0, 1) : ''));
}

// Available specializations
$available_specializations = ['Autism', 'Speech Therapy', 'Behavioral Support', 'Math & Logic', 'Visual Learning'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - LEARNSAFE.AI</title>
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
                <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <a href="verification.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-check-circle"></i>
                    <span>Verification</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Profile Management</h1>
                <p class="text-gray-600">View and update your profile information.</p>
            </div>

            <!-- Profile Photo -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Profile Photo</h2>
                <div class="flex items-center space-x-6">
                    <div class="w-32 h-32 bg-purple-100 rounded-full flex items-center justify-center">
                        <?php if ($teacher && $teacher['profile_image']): ?>
                            <img src="../<?php echo htmlspecialchars($teacher['profile_image']); ?>" alt="Profile" class="w-32 h-32 rounded-full object-cover">
                        <?php else: ?>
                            <i class="fas fa-user-tie text-5xl text-purple-600"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <button class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold mb-2">
                            Upload New Photo
                        </button>
                        <p class="text-sm text-gray-500">Recommended: Square photo, max 5MB</p>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Basic Information</h2>
                <form id="profileForm" method="POST" action="../api/teacher_update_profile.php">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" disabled>
                            <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Specialization (Select all that apply)</label>
                            <div class="grid grid-cols-2 gap-3 p-4 border-2 border-gray-200 rounded-lg">
                                <?php foreach ($available_specializations as $spec): ?>
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" name="specializations[]" value="<?php echo htmlspecialchars($spec); ?>" <?php echo in_array($spec, $specializations) ? 'checked' : ''; ?> class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="text-gray-700"><?php echo htmlspecialchars($spec); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                            <input type="text" name="location" value="<?php echo htmlspecialchars($teacher['location'] ?? ''); ?>" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Hourly Rate</label>
                            <input type="number" name="hourly_rate" step="0.01" value="<?php echo htmlspecialchars($teacher['hourly_rate'] ?? '45.00'); ?>" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Experience (Years)</label>
                            <input type="number" name="experience_years" value="<?php echo htmlspecialchars($teacher['experience_years'] ?? '0'); ?>" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" required>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Certifications & Teaching Style -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Certifications & Teaching Style</h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bio / About Me</label>
                        <textarea name="bio" form="profileForm" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" rows="4" placeholder="Tell parents about yourself, your teaching style, and experience"><?php echo htmlspecialchars($teacher['bio'] ?? ''); ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">License Number</label>
                        <input type="text" name="license_number" form="profileForm" value="<?php echo htmlspecialchars($teacher['license_number'] ?? ''); ?>" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="Enter your teaching license number">
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end space-x-4">
                <a href="dashboard.php" class="px-6 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" form="profileForm" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                    Save Changes
                </button>
            </div>
        </main>
    </div>
</body>
</html>
