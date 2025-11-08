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

// Get AI insights for teacher
$insights = $teacher_id ? getTeacherAIInsights($teacher_id, 10) : [];

// Get students for performance analysis
$students = $teacher_id ? getTeacherStudents($teacher_id) : [];

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
    <title>AI Insights - LEARNSAFE.AI</title>
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
                <a href="ai-insights.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">AI Insights</h1>
                <p class="text-gray-600">AI-generated suggestions for better teaching effectiveness.</p>
            </div>

            <!-- AI Insights Cards -->
            <div class="space-y-6">
                <?php if (!empty($insights)): ?>
                    <?php foreach ($insights as $insight): ?>
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center space-x-2 mb-4">
                                <i class="fas fa-lightbulb text-yellow-500"></i>
                                <h2 class="text-xl font-bold text-gray-800">AI Insight for <?php echo htmlspecialchars($insight['child_name'] ?? 'Student'); ?></h2>
                            </div>
                            <div class="space-y-4">
                                <?php if (!empty($insight['insight_type'])): ?>
                                    <div class="p-4 bg-blue-50 rounded-lg">
                                        <h3 class="font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $insight['insight_type']))); ?></h3>
                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($insight['insight_text'] ?? $insight['recommendation'] ?? 'No insight text available.'); ?></p>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($insight['recommendation'])): ?>
                                    <div class="p-4 bg-green-50 rounded-lg">
                                        <h3 class="font-semibold text-gray-800 mb-2">Recommendation</h3>
                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($insight['recommendation']); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="text-xs text-gray-500 mt-4">Generated on <?php echo formatDate($insight['created_at']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="fas fa-lightbulb text-yellow-500"></i>
                            <h2 class="text-xl font-bold text-gray-800">Teaching Effectiveness Insights</h2>
                        </div>
                        <div class="text-center py-12 text-gray-400">
                            <i class="fas fa-robot text-4xl mb-4"></i>
                            <p>AI insights will appear here based on your students' progress and session data.</p>
                            <p class="text-sm mt-2">Start teaching sessions to generate personalized insights.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Student Performance Analysis -->
                <?php if (!empty($students)): ?>
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="fas fa-chart-line text-green-500"></i>
                            <h2 class="text-xl font-bold text-gray-800">Student Performance Analysis</h2>
                        </div>
                        <div class="space-y-4">
                            <?php foreach ($students as $student): ?>
                                <?php
                                $progress = getChildProgressStats($student['id']);
                                $progress_percent = $progress['total'] > 0 ? round(($progress['completed'] / $progress['total']) * 100) : 0;
                                ?>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h3 class="font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($student['name']); ?></h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        <?php echo $progress['completed']; ?> completed sessions out of <?php echo $progress['total']; ?> total.
                                        <?php if ($progress['goals_achieved'] > 0): ?>
                                            <?php echo $progress['goals_achieved']; ?> goals achieved this week.
                                        <?php endif; ?>
                                    </p>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo min($progress_percent, 100); ?>%"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- AI Recommendations -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-robot text-blue-500"></i>
                        <h2 class="text-xl font-bold text-gray-800">AI Recommendations</h2>
                    </div>
                    <div class="space-y-3">
                        <?php if (!empty($students)): ?>
                            <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-lg">
                                <i class="fas fa-check-circle text-blue-500 mt-1"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Try sensory breaks every 20 minutes</p>
                                    <p class="text-sm text-gray-600">Based on student engagement patterns</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-lg">
                                <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Incorporate more hands-on activities</p>
                                    <p class="text-sm text-gray-600">Students show better retention with kinesthetic learning</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 p-4 bg-purple-50 rounded-lg">
                                <i class="fas fa-check-circle text-purple-500 mt-1"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Use visual schedules for transitions</p>
                                    <p class="text-sm text-gray-600">Reduces anxiety during activity changes</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-info-circle text-2xl mb-2"></i>
                                <p>Start working with students to receive personalized AI recommendations.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
