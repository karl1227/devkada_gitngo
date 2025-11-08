<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('parent');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$child = getParentChild($user_id);

if (!$child) {
    header('Location: child-profile.php');
    exit;
}

// Get progress data
$progress_stats = getChildProgressStats($child['id']);
$insights = getAIInsights($child['id'], 5);

// Get progress reports
$db = getDB();
$stmt = $db->prepare("
    SELECT pr.*, u.full_name as teacher_name, s.session_date
    FROM progress_reports pr
    JOIN teachers t ON pr.teacher_id = t.id
    JOIN users u ON t.user_id = u.id
    JOIN sessions s ON pr.session_id = s.id
    WHERE pr.child_id = ?
    ORDER BY pr.report_date DESC
    LIMIT 10
");
$stmt->bind_param("i", $child['id']);
$stmt->execute();
$result = $stmt->get_result();
$reports = [];
while ($row = $result->fetch_assoc()) {
    $reports[] = $row;
}
$stmt->close();

// Get child's name
$child_name = $child['name'];

// Calculate weekly goals progress
$completed_sessions = $progress_stats['completed'] ?? 0;
$total_sessions = $progress_stats['total'] ?? 5;
$goals_achieved = $progress_stats['goals_achieved'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking - LEARNSAFE.AI</title>
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
                <p class="text-gray-800 font-semibold">Welcome Back, <?php echo htmlspecialchars($user['full_name']); ?>! Let's make today great for <?php echo htmlspecialchars($child_name); ?></p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="../api/logout.php" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-sign-out-alt text-xl cursor-pointer" title="Logout"></i>
                </a>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 font-bold"><?php echo strtoupper(substr($user['full_name'], 0, 2)); ?></span>
                </div>
                <span class="text-gray-800 font-semibold"><?php echo htmlspecialchars(explode(' ', $user['full_name'])[0]); ?></span>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Left Sidebar -->
        <aside class="w-64 bg-gray-100 min-h-screen p-6">
            <nav class="space-y-2">
                <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="child-profile.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-user"></i>
                    <span>My Child</span>
                </a>
                <a href="find-teacher.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-search"></i>
                    <span>Find Teacher</span>
                </a>
                <a href="schedule.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-calendar"></i>
                    <span>Schedule</span>
                </a>
                <a href="progress.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
                    <i class="fas fa-chart-line"></i>
                    <span>Progress</span>
                </a>
                <a href="support.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-question-circle"></i>
                    <span>Support</span>
                </a>
            </nav>
            <div class="mt-8 p-4 bg-white rounded-lg">
                <p class="font-semibold text-gray-800 mb-2">Need Help?</p>
                <a href="support.php" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold text-center">
                    Contact our support
                </a>
            </div>
            <p class="mt-4 text-xs text-gray-500">Do not sell or share my personal info</p>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Progress Tracking</h1>
                <p class="text-gray-600">Monitor <?php echo htmlspecialchars($child_name); ?>'s learning journey and achievements.</p>
            </div>

            <!-- Weekly Goals Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center space-x-2 mb-6">
                    <i class="fas fa-bullseye text-blue-500"></i>
                    <h2 class="text-xl font-bold text-gray-800">Weekly Goals</h2>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700">Complete <?php echo $total_sessions; ?> sessions</span>
                            <span class="text-sm text-gray-600"><?php echo $completed_sessions; ?> / <?php echo $total_sessions; ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: <?php echo $total_sessions > 0 ? min(100, ($completed_sessions / $total_sessions) * 100) : 0; ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700">Goals Achieved</span>
                            <span class="text-sm text-gray-600"><?php echo $goals_achieved; ?> goals</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full" style="width: <?php echo min(100, $goals_achieved * 20); ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Reports -->
            <?php if (!empty($reports)): ?>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center space-x-2 mb-6">
                    <i class="fas fa-file-alt text-green-500"></i>
                    <h2 class="text-xl font-bold text-gray-800">Recent Progress Reports</h2>
                </div>
                <div class="space-y-4">
                    <?php foreach ($reports as $report): ?>
                        <div class="border-b border-gray-200 pb-4 last:border-b-0">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($report['subject']); ?></h3>
                                    <p class="text-sm text-gray-600">
                                        By <?php echo htmlspecialchars($report['teacher_name']); ?> 
                                        on <?php echo formatDate($report['report_date']); ?>
                                    </p>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold capitalize">
                                    <?php echo htmlspecialchars($report['engagement_level']); ?> engagement
                                </span>
                            </div>
                            <p class="text-gray-700 mb-2"><?php echo nl2br(htmlspecialchars($report['progress_notes'])); ?></p>
                            <?php if (!empty($report['goals_achieved'])): ?>
                                <div class="mt-2 p-3 bg-green-50 rounded-lg">
                                    <p class="text-sm font-semibold text-green-800 mb-1">Goals Achieved:</p>
                                    <p class="text-sm text-green-700"><?php echo nl2br(htmlspecialchars($report['goals_achieved'])); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($report['next_goals'])): ?>
                                <div class="mt-2 p-3 bg-blue-50 rounded-lg">
                                    <p class="text-sm font-semibold text-blue-800 mb-1">Next Goals:</p>
                                    <p class="text-sm text-blue-700"><?php echo nl2br(htmlspecialchars($report['next_goals'])); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- AI Insights & Recommendations -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center space-x-2 mb-6">
                    <i class="fas fa-lightbulb text-yellow-500"></i>
                    <h2 class="text-xl font-bold text-gray-800">AI Insights & Recommendations</h2>
                </div>
                <?php if (empty($insights)): ?>
                    <div class="text-center py-12 text-gray-400">
                        <i class="fas fa-robot text-4xl mb-4"></i>
                        <p>AI insights will appear here based on <?php echo htmlspecialchars($child_name); ?>'s progress</p>
                        <p class="text-sm mt-2">Complete more sessions to generate insights</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($insights as $insight): ?>
                            <div class="p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($insight['insight_type']); ?></h3>
                                    <?php if ($insight['confidence_score'] > 0): ?>
                                        <span class="text-xs text-gray-500">
                                            Confidence: <?php echo number_format($insight['confidence_score'], 0); ?>%
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($insight['insight_text'])); ?></p>
                                <p class="text-xs text-gray-500 mt-2">
                                    <?php echo formatDateTime($insight['created_at']); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
