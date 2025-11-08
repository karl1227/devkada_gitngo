<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('parent');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$child = getParentChild($user_id);
$teacher = getMatchedTeacher($user_id);
$sessions = getUpcomingSessions($user_id, 3);
$progress = $child ? getChildProgressStats($child['id']) : ['completed' => 0, 'total' => 0, 'goals_achieved' => 0];
$insights = $child ? getAIInsights($child['id'], 3) : [];

// Get child's name or default
$child_name = $child ? $child['name'] : 'Your Child';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LEARNSAFE.AI</title>
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
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
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
                <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <a href="progress.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
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
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold">
                    Contact our support
                </button>
            </div>
            <p class="mt-4 text-xs text-gray-500">Do not sell or share my personal info</p>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
                <p class="text-gray-600">Overview of <?php echo htmlspecialchars($child_name); ?>'s learning journey</p>
            </div>

            <!-- Dashboard Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- My Child's Profile Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-heart text-red-500"></i>
                            <h2 class="text-xl font-bold text-gray-800">My Child's Profile</h2>
                        </div>
                    </div>
                    <?php if ($child): ?>
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-3xl text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($child['name']); ?></h3>
                            <p class="text-gray-600">Age <?php echo $child['age']; ?></p>
                            <?php if ($child['learning_style']): ?>
                            <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                <?php echo htmlspecialchars($child['learning_style']); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="space-y-2 mb-4">
                        <?php if ($child['learning_style']): ?>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Learning Style:</span> <?php echo htmlspecialchars($child['learning_style']); ?></p>
                        <?php endif; ?>
                        <?php if ($child['communication_style']): ?>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Communication:</span> <?php echo htmlspecialchars($child['communication_style']); ?></p>
                        <?php endif; ?>
                    </div>
                    <a href="child-profile.php" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                        View Full Profile
                    </a>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-600 mb-4">No child profile found</p>
                        <a href="child-profile.php" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Add Child Profile
                        </a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Matched Teacher Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-star text-yellow-500"></i>
                            <h2 class="text-xl font-bold text-gray-800">Matched Teacher</h2>
                        </div>
                    </div>
                    <?php if ($teacher): ?>
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-tie text-3xl text-purple-600"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($teacher['full_name']); ?></h3>
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <p class="text-gray-600">★ <?php echo number_format($teacher['rating'], 1); ?> (<?php echo $teacher['total_reviews']; ?> reviews)</p>
                            <p class="text-sm text-gray-600 mt-1"><span class="font-semibold">Specialization:</span> <?php echo htmlspecialchars($teacher['specialization']); ?></p>
                            <p class="text-sm text-gray-600"><span class="font-semibold">Experience:</span> <?php echo $teacher['experience_years']; ?> years</p>
                        </div>
                    </div>
                    <a href="find-teacher.php" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                        Find Teachers
                    </a>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-600 mb-4">No teacher matched yet</p>
                        <a href="find-teacher.php" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Find Teachers
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- AI Insights Card -->
            <?php if (!empty($insights)): ?>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center space-x-2 mb-4">
                    <i class="fas fa-lightbulb text-yellow-500"></i>
                    <h2 class="text-xl font-bold text-gray-800">AI Insights</h2>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                    <?php foreach ($insights as $index => $insight): ?>
                    <div class="p-4 bg-<?php echo ['blue', 'green', 'purple'][$index % 3]; ?>-50 rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-1"><?php echo htmlspecialchars($insight['insight_type']); ?></h3>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($insight['insight_text']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Bottom Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Upcoming Sessions Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-calendar text-blue-500"></i>
                        <h2 class="text-xl font-bold text-gray-800">Upcoming Sessions</h2>
                    </div>
                    <div class="space-y-4">
                        <?php if (!empty($sessions)): ?>
                            <?php foreach ($sessions as $session): ?>
                            <div class="flex items-center justify-between p-3 <?php echo $session['session_date'] == date('Y-m-d') ? 'bg-blue-50' : 'bg-gray-50'; ?> rounded-lg">
                                <div>
                                    <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($session['child_name']); ?> - Session</p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($session['teacher_name']); ?></p>
                                    <p class="text-sm text-gray-500">
                                        <?php 
                                        $session_date = new DateTime($session['session_date']);
                                        $today = new DateTime();
                                        $tomorrow = (clone $today)->modify('+1 day');
                                        
                                        if ($session_date->format('Y-m-d') == $today->format('Y-m-d')) {
                                            echo 'Today, ';
                                        } elseif ($session_date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
                                            echo 'Tomorrow, ';
                                        } else {
                                            echo $session_date->format('M d, Y') . ', ';
                                        }
                                        echo formatTime($session['session_time']);
                                        echo ' (' . $session['duration_minutes'] . ' min)';
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-gray-600">No upcoming sessions</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <a href="schedule.php" class="block w-full mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                        View All Sessions
                    </a>
                </div>

                <!-- Weekly Progress Snapshot Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-chart-bar text-green-500"></i>
                        <h2 class="text-xl font-bold text-gray-800">Weekly Progress Snapshot</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">Sessions Completed</span>
                                <span class="text-sm text-gray-600"><?php echo $progress['completed']; ?> / <?php echo $progress['total']; ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <?php 
                                $sessions_percent = $progress['total'] > 0 ? ($progress['completed'] / $progress['total']) * 100 : 0;
                                ?>
                                <div class="bg-blue-500 h-3 rounded-full" style="width: <?php echo min($sessions_percent, 100); ?>%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">Goals Achieved</span>
                                <span class="text-sm text-gray-600"><?php echo $progress['goals_achieved']; ?></span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <?php 
                                $goals_percent = min(($progress['goals_achieved'] / 4) * 100, 100);
                                ?>
                                <div class="bg-green-500 h-3 rounded-full" style="width: <?php echo $goals_percent; ?>%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">Engagement Level</span>
                                <span class="text-sm text-green-600 font-semibold">High</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-500 h-3 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-800 mb-3">This Week's Highlights:</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                <span class="text-sm text-gray-700">Improved focus during lessons</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                <span class="text-sm text-gray-700">Great progress in phonics</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                                <span class="text-sm text-gray-700">More comfortable with transitions</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Floating Help Button -->
    <div class="fixed bottom-6 right-6 w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-blue-600 transition">
        <i class="fas fa-question text-white text-xl"></i>
    </div>
</body>
</html>



