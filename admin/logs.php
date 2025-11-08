<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/admin_functions.php';

// Security check
requireAdmin();

$user_id = getCurrentUserId();
$user = getUserData($user_id);

// Get filter parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$action_filter = sanitize($_GET['action'] ?? '');

// Get logs
$logs_data = getSystemLogs($page, 50, $action_filter);
$logs = $logs_data['logs'];
$total_logs = $logs_data['total'];
$total_pages = ceil($total_logs / 50);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Logs - LEARNSAFE.AI</title>
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
                <a href="analytics.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-chart-bar"></i>
                    <span>Analytics</span>
                </a>
                <a href="logs.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
                    <i class="fas fa-list"></i>
                    <span>System Logs</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">System Logs</h1>
                <p class="text-gray-600">Recent actions and changes in the platform.</p>
            </div>

            <!-- Filters -->
            <form method="GET" action="logs.php" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Action Type</label>
                        <select name="action" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                            <option value="">All Actions</option>
                            <option value="login" <?php echo $action_filter === 'login' ? 'selected' : ''; ?>>Login</option>
                            <option value="register" <?php echo $action_filter === 'register' ? 'selected' : ''; ?>>User Registration</option>
                            <option value="teacher_approved" <?php echo $action_filter === 'teacher_approved' ? 'selected' : ''; ?>>Teacher Verification</option>
                            <option value="session_booked" <?php echo $action_filter === 'session_booked' ? 'selected' : ''; ?>>Session Booking</option>
                            <option value="logout" <?php echo $action_filter === 'logout' ? 'selected' : ''; ?>>Logout</option>
                            <option value="unauthorized_admin_access" <?php echo $action_filter === 'unauthorized_admin_access' ? 'selected' : ''; ?>>Unauthorized Access</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Total Logs</label>
                        <p class="px-4 py-3 text-gray-800 font-semibold"><?php echo number_format($total_logs); ?> entries</p>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Filter Logs
                        </button>
                    </div>
                </div>
            </form>

            <!-- Logs Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Timestamp</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Details</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $log): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo formatDateTime($log['created_at']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php 
                                        $action_colors = [
                                            'login' => 'blue',
                                            'register' => 'green',
                                            'teacher_approved' => 'purple',
                                            'session_booked' => 'green',
                                            'logout' => 'gray',
                                            'unauthorized_admin_access' => 'red'
                                        ];
                                        $color = $action_colors[$log['action']] ?? 'blue';
                                        ?>
                                        <span class="px-3 py-1 bg-<?php echo $color; ?>-100 text-<?php echo $color; ?>-700 rounded-full text-sm font-semibold">
                                            <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $log['action']))); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-800">
                                        <?php echo $log['full_name'] ? htmlspecialchars($log['full_name']) : 'System'; ?>
                                        <?php if ($log['email']): ?>
                                        <br><span class="text-xs text-gray-500"><?php echo htmlspecialchars($log['email']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600"><?php echo htmlspecialchars($log['description'] ?: 'N/A'); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">Success</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-600">
                                        No logs found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="mt-6 flex justify-center items-center space-x-2">
                <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&action=<?php echo urlencode($action_filter); ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Previous
                </a>
                <?php endif; ?>
                
                <span class="px-4 py-2 text-gray-600">
                    Page <?php echo $page; ?> of <?php echo $total_pages; ?>
                </span>
                
                <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&action=<?php echo urlencode($action_filter); ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Next
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>


