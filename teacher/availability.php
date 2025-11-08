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

// Get availability
$availability = $teacher_id ? getTeacherAvailability($teacher_id) : [];

// Get user initials for avatar
$initials = '';
if ($user && $user['full_name']) {
    $name_parts = explode(' ', $user['full_name']);
    $initials = strtoupper(substr($name_parts[0], 0, 1) . (isset($name_parts[1]) ? substr($name_parts[1], 0, 1) : ''));
}

// Organize availability by day
$availability_by_day = [];
$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
foreach ($days as $day) {
    $availability_by_day[$day] = [];
}
foreach ($availability as $slot) {
    $availability_by_day[$slot['day_of_week']][] = $slot;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Availability - LEARNSAFE.AI</title>
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
                <a href="availability.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Availability Calendar</h1>
                <p class="text-gray-600">Set your available times for sessions.</p>
            </div>

            <!-- Availability by Day -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Weekly Availability</h2>
                <form id="availabilityForm" method="POST" action="../api/teacher_update_availability.php">
                    <div class="space-y-6">
                        <?php foreach ($days as $day): 
                            $day_slots = $availability_by_day[$day] ?? [];
                            $day_label = ucfirst($day);
                        ?>
                            <div class="border-b border-gray-200 pb-6 last:border-b-0">
                                <h3 class="font-semibold text-gray-800 mb-4"><?php echo $day_label; ?></h3>
                                <?php if (!empty($day_slots)): ?>
                                    <div class="space-y-2 mb-4">
                                        <?php foreach ($day_slots as $slot): ?>
                                            <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                                                <span class="text-sm font-semibold text-gray-700">
                                                    <?php echo date('g:i A', strtotime($slot['start_time'])); ?> - <?php echo date('g:i A', strtotime($slot['end_time'])); ?>
                                                </span>
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Available</span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500 mb-4">No availability set for this day</p>
                                <?php endif; ?>
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Start Time</label>
                                        <input type="time" name="availability[<?php echo $day; ?>][start_time]" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">End Time</label>
                                        <input type="time" name="availability[<?php echo $day; ?>][end_time]" class="px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                                    </div>
                                    <div class="flex items-end">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="checkbox" name="availability[<?php echo $day; ?>][is_available]" value="1" <?php echo !empty($day_slots) ? 'checked' : ''; ?> class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            <span class="text-sm text-gray-700">Available</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Save Availability
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
