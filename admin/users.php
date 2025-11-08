<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_functions.php';

// Security check
requireAdmin();

$user_id = getCurrentUserId();
$user = getUserData($user_id);

// Get filter parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = sanitize($_GET['search'] ?? '');
$role_filter = sanitize($_GET['role'] ?? '');
$status_filter = sanitize($_GET['status'] ?? '');

// Get users
$users_data = getAllUsers($page, 20, $search, $role_filter, $status_filter);
$users = $users_data['users'];
$total_users = $users_data['total'];
$total_pages = ceil($total_users / 20);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - LEARNSAFE.AI</title>
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
                <a href="users.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">User Management</h1>
                <p class="text-gray-600">View, approve, and manage user accounts.</p>
            </div>

            <!-- Filters -->
            <form method="GET" action="users.php" class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="grid md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                        <select name="role" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                            <option value="">All Roles</option>
                            <option value="parent" <?php echo $role_filter === 'parent' ? 'selected' : ''; ?>>Parent</option>
                            <option value="teacher" <?php echo $role_filter === 'teacher' ? 'selected' : ''; ?>>Teacher</option>
                            <option value="admin" <?php echo $role_filter === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                            <option value="">All Status</option>
                            <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="suspended" <?php echo $status_filter === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                            <option value="rejected" <?php echo $status_filter === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search users..." class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Users Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user_row): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-<?php 
                                                $colors = ['parent' => 'blue', 'teacher' => 'purple', 'admin' => 'red'];
                                                echo $colors[$user_row['role']] ?? 'gray';
                                            ?>-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-<?php 
                                                    echo $colors[$user_row['role']] ?? 'gray';
                                                ?>-600 font-bold"><?php echo strtoupper(substr($user_row['full_name'], 0, 2)); ?></span>
                                            </div>
                                            <span class="font-semibold text-gray-800"><?php echo htmlspecialchars($user_row['full_name']); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo htmlspecialchars($user_row['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-<?php 
                                            $role_colors = ['parent' => 'green', 'teacher' => 'purple', 'admin' => 'red'];
                                            echo $role_colors[$user_row['role']] ?? 'gray';
                                        ?>-100 text-<?php 
                                            echo $role_colors[$user_row['role']] ?? 'gray';
                                        ?>-700 rounded-full text-sm font-semibold"><?php echo ucfirst($user_row['role']); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-<?php 
                                            $status_colors = ['active' => 'green', 'pending' => 'yellow', 'suspended' => 'red', 'rejected' => 'red'];
                                            echo $status_colors[$user_row['status']] ?? 'gray';
                                        ?>-100 text-<?php 
                                            echo $status_colors[$user_row['status']] ?? 'gray';
                                        ?>-700 rounded-full text-sm font-semibold"><?php echo ucfirst($user_row['status']); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600"><?php echo formatDate($user_row['created_at']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($user_row['id'] != $user_id): ?>
                                        <button onclick="updateUserStatus(<?php echo $user_row['id']; ?>, '<?php echo $user_row['status'] === 'active' ? 'suspended' : 'active'; ?>')" class="text-<?php echo $user_row['status'] === 'active' ? 'red' : 'green'; ?>-600 hover:underline font-semibold mr-3">
                                            <?php echo $user_row['status'] === 'active' ? 'Suspend' : 'Activate'; ?>
                                        </button>
                                        <button onclick="deleteUser(<?php echo $user_row['id']; ?>)" class="text-red-600 hover:underline font-semibold">Delete</button>
                                        <?php else: ?>
                                        <span class="text-gray-400 text-sm">Current User</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-600">
                                        No users found
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
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&role=<?php echo urlencode($role_filter); ?>&status=<?php echo urlencode($status_filter); ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Previous
                </a>
                <?php endif; ?>
                
                <span class="px-4 py-2 text-gray-600">
                    Page <?php echo $page; ?> of <?php echo $total_pages; ?> (<?php echo $total_users; ?> total users)
                </span>
                
                <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&role=<?php echo urlencode($role_filter); ?>&status=<?php echo urlencode($status_filter); ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                    Next
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function updateUserStatus(userId, newStatus) {
            const action = newStatus === 'active' ? 'activate' : 'suspend';
            if (!confirm(`Are you sure you want to ${action} this user?`)) {
                return;
            }
            
            fetch('../api/admin_user_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'update_status',
                    user_id: userId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User status updated successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
            });
        }
        
        function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone!')) {
                return;
            }
            
            if (!confirm('This will permanently delete the user and all associated data. Are you absolutely sure?')) {
                return;
            }
            
            fetch('../api/admin_user_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'delete',
                    user_id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User deleted successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
            });
        }
    </script>
</body>
</html>


