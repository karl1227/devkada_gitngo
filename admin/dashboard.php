<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/admin_functions.php';

// Security check - require admin role
requireAdmin();

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$stats = getAdminDashboardStats();
$recent_applications = getRecentTeacherApplications(5);
$activities = getPlatformActivity(5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LEARNSAFE.AI</title>
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
                <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <a href="analytics.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">System Overview</h1>
                <p class="text-gray-600">Platform analytics and management dashboard.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($stats['total_users']); ?></h3>
                    <p class="text-gray-600 text-sm">Total Users</p>
                    <p class="text-green-600 text-xs mt-2">+<?php echo $stats['users_this_month']; ?> this month</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($stats['verified_teachers']); ?></h3>
                    <p class="text-gray-600 text-sm">Verified Teachers</p>
                    <p class="text-green-600 text-xs mt-2">+<?php echo $stats['teachers_this_month']; ?> this month</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($stats['active_sessions']); ?></h3>
                    <p class="text-gray-600 text-sm">Active Sessions</p>
                    <p class="text-green-600 text-xs mt-2">+<?php echo $stats['sessions_this_month']; ?> this month</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-purple-600 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo number_format($stats['pending_verifications']); ?></h3>
                    <p class="text-gray-600 text-sm">Pending Verifications</p>
                    <?php if ($stats['pending_verifications'] > 0): ?>
                    <p class="text-red-600 text-xs mt-2">Requires attention</p>
                    <?php else: ?>
                    <p class="text-green-600 text-xs mt-2">All clear</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Teacher Applications</h2>
                    <div class="space-y-4">
                        <?php if (!empty($recent_applications)): ?>
                            <?php foreach ($recent_applications as $application): ?>
                            <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                                <div>
                                    <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($application['full_name']); ?></h3>
                                    <p class="text-sm text-gray-600">
                                        <?php 
                                        $applied_at = new DateTime($application['applied_at']);
                                        $now = new DateTime();
                                        $diff = $now->diff($applied_at);
                                        
                                        if ($diff->days > 0) {
                                            echo "Applied {$diff->days} day" . ($diff->days > 1 ? 's' : '') . " ago";
                                        } elseif ($diff->h > 0) {
                                            echo "Applied {$diff->h} hour" . ($diff->h > 1 ? 's' : '') . " ago";
                                        } else {
                                            echo "Applied {$diff->i} minute" . ($diff->i > 1 ? 's' : '') . " ago";
                                        }
                                        ?>
                                    </p>
                                </div>
                                <a href="verification.php?id=<?php echo $application['id']; ?>" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-sm">
                                    Review
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-gray-600">No pending applications</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Platform Activity</h2>
                    <div class="space-y-4">
                        <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 bg-<?php 
                                    $icon_colors = [
                                        'login' => 'blue',
                                        'register' => 'green',
                                        'teacher_approved' => 'green',
                                        'session_booked' => 'purple',
                                        'logout' => 'gray'
                                    ];
                                    echo $icon_colors[$activity['action']] ?? 'blue';
                                ?>-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-<?php 
                                        $icons = [
                                            'login' => 'sign-in-alt',
                                            'register' => 'user-plus',
                                            'teacher_approved' => 'check-circle',
                                            'session_booked' => 'calendar',
                                            'logout' => 'sign-out-alt'
                                        ];
                                        echo $icons[$activity['action']] ?? 'circle';
                                    ?> text-<?php 
                                        echo $icon_colors[$activity['action']] ?? 'blue';
                                    ?>-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $activity['action']))); ?></p>
                                    <p class="text-sm text-gray-600">
                                        <?php 
                                        if ($activity['description']) {
                                            echo htmlspecialchars($activity['description']);
                                        } else {
                                            echo $activity['full_name'] ?? 'System';
                                        }
                                        ?>
                                        - <?php echo formatDateTime($activity['created_at']); ?>
                                    </p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-gray-600">No recent activity</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
                <div class="grid md:grid-cols-3 gap-4">
                    <a href="verification.php" class="p-6 bg-blue-50 rounded-lg hover:bg-blue-100 transition text-center">
                        <i class="fas fa-check-circle text-blue-600 text-3xl mb-3"></i>
                        <p class="font-semibold text-gray-800">Review Verifications</p>
                        <p class="text-sm text-gray-600 mt-2"><?php echo $stats['pending_verifications']; ?> pending</p>
                    </a>
                    <a href="users.php" class="p-6 bg-green-50 rounded-lg hover:bg-green-100 transition text-center">
                        <i class="fas fa-users text-green-600 text-3xl mb-3"></i>
                        <p class="font-semibold text-gray-800">Manage Users</p>
                        <p class="text-sm text-gray-600 mt-2"><?php echo number_format($stats['total_users']); ?> total users</p>
                    </a>
                    <a href="analytics.php" class="p-6 bg-purple-50 rounded-lg hover:bg-purple-100 transition text-center">
                        <i class="fas fa-chart-bar text-purple-600 text-3xl mb-3"></i>
                        <p class="font-semibold text-gray-800">View Analytics</p>
                        <p class="text-sm text-gray-600 mt-2">Platform insights</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>


