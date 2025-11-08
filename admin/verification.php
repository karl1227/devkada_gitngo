<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/admin_functions.php';

// Security check
requireAdmin();

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$pending_verifications = getPendingVerifications();

// Get recently approved (last 10)
$db = getDB();
$stmt = $db->prepare("
    SELECT t.*, u.full_name, u.email, t.verified_at
    FROM teachers t
    JOIN users u ON t.user_id = u.id
    WHERE t.verification_status = 'approved'
    ORDER BY t.verified_at DESC
    LIMIT 10
");
$stmt->execute();
$result = $stmt->get_result();
$approved_teachers = [];
while ($row = $result->fetch_assoc()) {
    $approved_teachers[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Center - LEARNSAFE.AI</title>
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
                <a href="verification.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Verification Center</h1>
                <p class="text-gray-600">Review and approve teacher license documents.</p>
            </div>

            <!-- Pending Verifications -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Pending Verifications</h2>
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full font-semibold"><?php echo count($pending_verifications); ?> Pending</span>
                    </div>
                    
                    <?php if (!empty($pending_verifications)): ?>
                        <?php foreach ($pending_verifications as $verification): ?>
                        <div class="border-2 border-yellow-300 rounded-lg p-6 mb-6 bg-yellow-50" id="verification-<?php echo $verification['id']; ?>">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($verification['full_name']); ?></h3>
                                    <p class="text-gray-600 mb-1"><?php echo htmlspecialchars($verification['email']); ?></p>
                                    <p class="text-sm text-gray-500">Applied: <?php echo formatDate($verification['applied_at']); ?></p>
                                </div>
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full font-semibold">Pending</span>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Specialization</label>
                                    <p class="text-gray-800"><?php echo htmlspecialchars($verification['specialization']); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                                    <p class="text-gray-800"><?php echo htmlspecialchars($verification['location']); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Experience</label>
                                    <p class="text-gray-800"><?php echo $verification['experience_years']; ?> years</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teaching License</label>
                                    <?php if ($verification['license_file']): ?>
                                    <a href="../<?php echo htmlspecialchars($verification['license_file']); ?>" target="_blank" class="text-blue-600 hover:underline font-semibold">
                                        <i class="fas fa-file-pdf mr-1"></i>View Document
                                    </a>
                                    <?php else: ?>
                                    <p class="text-gray-500">No license uploaded</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <button onclick="approveVerification(<?php echo $verification['id']; ?>)" class="flex-1 px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold">
                                    <i class="fas fa-check mr-2"></i>Approve
                                </button>
                                <button onclick="rejectVerification(<?php echo $verification['id']; ?>)" class="flex-1 px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                                    <i class="fas fa-times mr-2"></i>Reject
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                            <p class="text-xl font-semibold text-gray-800 mb-2">All Clear!</p>
                            <p class="text-gray-600">No pending verifications at this time.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Approved Verifications -->
                <?php if (!empty($approved_teachers)): ?>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Recently Approved</h2>
                    <div class="space-y-4">
                        <?php foreach ($approved_teachers as $teacher): ?>
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                            <div>
                                <h3 class="font-bold text-gray-800"><?php echo htmlspecialchars($teacher['full_name']); ?></h3>
                                <p class="text-sm text-gray-600">Approved on <?php echo $teacher['verified_at'] ? formatDate($teacher['verified_at']) : 'N/A'; ?></p>
                            </div>
                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full font-semibold">Verified</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        function approveVerification(teacherId) {
            if (!confirm('Are you sure you want to approve this teacher verification?')) {
                return;
            }
            
            fetch('../api/admin_verify.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'approve',
                    teacher_id: teacherId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Teacher verification approved successfully!');
                    document.getElementById('verification-' + teacherId).remove();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
            });
        }
        
        function rejectVerification(teacherId) {
            const reason = prompt('Please provide a reason for rejection (optional):');
            
            if (reason === null) {
                return; // User cancelled
            }
            
            if (!confirm('Are you sure you want to reject this teacher verification?')) {
                return;
            }
            
            fetch('../api/admin_verify.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'reject',
                    teacher_id: teacherId,
                    reason: reason || ''
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Teacher verification rejected.');
                    document.getElementById('verification-' + teacherId).remove();
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


