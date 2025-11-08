<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_functions.php';

// Security check
requireAdmin();

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$analytics = getAnalyticsData();
$stats = getAdminDashboardStats();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - LEARNSAFE.AI</title>
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
                <p class="text-gray-800 font-semibold">Admin Dashboard</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="../api/logout.php" class="text-gray-600 hover:text-red-600" title="Logout">
                    <i class="fas fa-sign-out-alt text-xl cursor-pointer"></i>
                </a>
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                    <span class="text-red-600 font-bold"><?php echo strtoupper(substr($user['full_name'], 0, 2)); ?></span>
                </div>
                <span class="text-gray-800 font-semibold"><?php echo htmlspecialchars($user['full_name']); ?></span>
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
                <a href="users.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                </a>
                <a href="verification.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-check-circle"></i>
                    <span>Verification Center</span>
                </a>
                <a href="analytics.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
                    <i class="fas fa-chart-bar"></i>
                    <span>Analytics</span>
                </a>
                <a href="logs.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-list"></i>
                    <span>System Logs</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Analytics Overview</h1>
                <p class="text-gray-600">Platform insights and performance metrics.</p>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">User Growth</h3>
                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800 mb-1">+<?php echo $stats['users_this_month']; ?></p>
                            <p class="text-sm text-gray-600">This month</p>
                        </div>
                        <i class="fas fa-chart-line text-green-500 text-3xl"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Teacher Approval Rate</h3>
                    <div class="flex items-end justify-between">
                        <div>
                            <?php 
                            $total_teachers = $stats['verified_teachers'] + $stats['pending_verifications'];
                            $approval_rate = $total_teachers > 0 ? round(($stats['verified_teachers'] / $total_teachers) * 100) : 0;
                            ?>
                            <p class="text-3xl font-bold text-gray-800 mb-1"><?php echo $approval_rate; ?>%</p>
                            <p class="text-sm text-gray-600">Approval rate</p>
                        </div>
                        <i class="fas fa-check-circle text-blue-500 text-3xl"></i>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Student Engagement</h3>
                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-3xl font-bold text-gray-800 mb-1">92%</p>
                            <p class="text-sm text-gray-600">Engagement</p>
                        </div>
                        <i class="fas fa-star text-yellow-500 text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">User Registration Trend</h2>
                    <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                        <p class="text-gray-500">Chart visualization would go here</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Session Activity</h2>
                    <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                        <p class="text-gray-500">Chart visualization would go here</p>
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Platform Statistics</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4">User Distribution</h3>
                        <div class="space-y-3">
                            <?php 
                            $parent_count = 0;
                            $teacher_count = 0;
                            $admin_count = 0;
                            
                            foreach ($analytics['users_by_role'] as $role_data) {
                                if ($role_data['role'] === 'parent') $parent_count = $role_data['count'];
                                if ($role_data['role'] === 'teacher') $teacher_count = $role_data['count'];
                                if ($role_data['role'] === 'admin') $admin_count = $role_data['count'];
                            }
                            
                            $total_role_users = $parent_count + $teacher_count + $admin_count;
                            $parent_percent = $total_role_users > 0 ? round(($parent_count / $total_role_users) * 100) : 0;
                            $teacher_percent = $total_role_users > 0 ? round(($teacher_count / $total_role_users) * 100) : 0;
                            ?>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-700">Parents</span>
                                    <span class="text-sm font-semibold text-gray-800"><?php echo number_format($parent_count); ?> (<?php echo $parent_percent; ?>%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo $parent_percent; ?>%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-700">Teachers</span>
                                    <span class="text-sm font-semibold text-gray-800"><?php echo number_format($teacher_count); ?> (<?php echo $teacher_percent; ?>%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: <?php echo $teacher_percent; ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-4">Top Specializations</h3>
                        <div class="space-y-3">
                            <?php 
                            // Get specialization counts
                            $db = getDB();
                            $result = $db->query("
                                SELECT specialization, COUNT(*) as count
                                FROM teacher_specializations
                                GROUP BY specialization
                                ORDER BY count DESC
                                LIMIT 5
                            ");
                            $specializations = [];
                            while ($row = $result->fetch_assoc()) {
                                $specializations[] = $row;
                            }
                            
                            $colors = ['blue', 'green', 'purple', 'yellow', 'pink'];
                            $index = 0;
                            ?>
                            <?php if (!empty($specializations)): ?>
                                <?php foreach ($specializations as $spec): 
                                    // Decode any existing HTML entities first, then encode properly
                                    $specialization = html_entity_decode($spec['specialization'], ENT_QUOTES, 'UTF-8');
                                    $specialization = htmlspecialchars($specialization, ENT_QUOTES, 'UTF-8');
                                ?>
                                <div class="flex items-center justify-between p-3 bg-<?php echo $colors[$index % count($colors)]; ?>-50 rounded-lg">
                                    <span class="font-semibold text-gray-800"><?php echo $specialization; ?></span>
                                    <span class="text-gray-600"><?php echo $spec['count']; ?> teachers</span>
                                </div>
                                <?php 
                                $index++;
                                endforeach; 
                                ?>
                            <?php else: ?>
                                <p class="text-gray-600 text-center py-4">No specialization data available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>


