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

// Get dashboard stats
$stats = $teacher_id ? getTeacherDashboardStats($teacher_id) : [
    'active_students' => 0,
    'sessions_this_month' => 0,
    'rating' => 0.00,
    'total_reviews' => 0,
    'earnings' => 0.00
];

// Get upcoming sessions
$sessions = $teacher_id ? getTeacherUpcomingSessions($teacher_id, 5) : [];

// Get recent student progress
$recent_students = $teacher_id ? getTeacherRecentStudentProgress($teacher_id, 5) : [];

// Get user initials for avatar
$initials = '';
if ($user && $user['full_name']) {
    $name_parts = explode(' ', $user['full_name']);
    $initials = strtoupper(substr($name_parts[0], 0, 1) . (isset($name_parts[1]) ? substr($name_parts[1], 0, 1) : ''));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - LEARNSAFE.AI</title>
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
                <p class="text-gray-800 font-semibold">Welcome Back, <?php echo htmlspecialchars($user['full_name'] ?? 'Teacher'); ?>! Ready to make a difference today?</p>
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
                <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <a href="verification.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-check-circle"></i>
                    <span>Verification</span>
                </a>
            </nav>
            <div class="mt-8 p-4 bg-white rounded-lg">
                <p class="font-semibold text-gray-800 mb-2">Need Help?</p>
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold">
                    Contact Support
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
                <p class="text-gray-600">Overview of your teaching activities and student progress.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($stats['active_students']); ?></h3>
                    <p class="text-gray-600 text-sm">Active Students</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($stats['sessions_this_month']); ?></h3>
                    <p class="text-gray-600 text-sm">Sessions This Month</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($stats['rating'], 1); ?></h3>
                    <p class="text-gray-600 text-sm">Average Rating (<?php echo number_format($stats['total_reviews']); ?> reviews)</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">$<?php echo number_format($stats['earnings'], 2); ?></h3>
                    <p class="text-gray-600 text-sm">This Month's Earnings</p>
                </div>
            </div>

            <!-- Upcoming Sessions -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Upcoming Sessions</h2>
                    <a href="availability.php" class="text-blue-600 hover:underline font-semibold">View All</a>
                </div>
                <div class="space-y-4">
                    <?php if (empty($sessions)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-calendar-times text-4xl mb-4"></i>
                            <p>No upcoming sessions scheduled</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($sessions as $session): 
                            $session_date = new DateTime($session['session_date']);
                            $session_time = new DateTime($session['session_time']);
                            $end_time = clone $session_time;
                            $end_time->modify('+' . $session['duration_minutes'] . ' minutes');
                            
                            $is_today = $session_date->format('Y-m-d') === date('Y-m-d');
                            $is_tomorrow = $session_date->format('Y-m-d') === date('Y-m-d', strtotime('+1 day'));
                            
                            $date_label = $is_today ? 'Today' : ($is_tomorrow ? 'Tomorrow' : $session_date->format('M d, Y'));
                            
                            $child_initials = '';
                            $child_name_parts = explode(' ', $session['child_name']);
                            $child_initials = strtoupper(substr($child_name_parts[0], 0, 1) . (isset($child_name_parts[1]) ? substr($child_name_parts[1], 0, 1) : ''));
                        ?>
                            <div class="flex items-center justify-between p-4 <?php echo $is_today ? 'bg-blue-50 border-l-4 border-blue-500' : 'bg-gray-50 border-l-4 border-gray-300'; ?> rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 <?php echo $is_today ? 'bg-blue-500' : 'bg-gray-400'; ?> rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm"><?php echo htmlspecialchars($child_initials); ?></span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($session['child_name']); ?></h3>
                                        <p class="text-sm text-gray-600">Parent: <?php echo htmlspecialchars($session['parent_name']); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($date_label); ?>, <?php echo $session_time->format('g:i A'); ?> - <?php echo $end_time->format('g:i A'); ?></p>
                                    </div>
                                </div>
                                <?php if ($is_today && $session['status'] === 'confirmed'): ?>
                                    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                        Start Session
                                    </button>
                                <?php else: ?>
                                    <button class="px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                        View Details
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Student Progress -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Student Progress</h2>
                <div class="space-y-4">
                    <?php if (empty($recent_students)): ?>
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-user-graduate text-4xl mb-4"></i>
                            <p>No student progress data available yet</p>
                        </div>
                    <?php else: ?>
                        <?php 
                        $colors = ['blue', 'green', 'purple', 'orange', 'pink'];
                        foreach ($recent_students as $index => $student): 
                            $student_initials = '';
                            $student_name_parts = explode(' ', $student['name']);
                            $student_initials = strtoupper(substr($student_name_parts[0], 0, 1) . (isset($student_name_parts[1]) ? substr($student_name_parts[1], 0, 1) : ''));
                            
                            $color = $colors[$index % count($colors)];
                            $completed_sessions = $student['completed_sessions'] ?? 0;
                            $progress_reports = $student['progress_reports_count'] ?? 0;
                        ?>
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-<?php echo $color; ?>-100 rounded-full flex items-center justify-center">
                                        <span class="text-<?php echo $color; ?>-600 font-bold"><?php echo htmlspecialchars($student_initials); ?></span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($student['name']); ?></h3>
                                        <p class="text-sm text-gray-600">Completed Sessions: <?php echo number_format($completed_sessions); ?> | Progress Reports: <?php echo number_format($progress_reports); ?></p>
                                        <?php if ($student['last_report_date']): ?>
                                            <p class="text-sm text-gray-500">Last Report: <?php echo formatDate($student['last_report_date']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="reports.php?child_id=<?php echo $student['id']; ?>" class="text-blue-600 hover:underline font-semibold">View Report</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>


