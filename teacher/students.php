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

// Get students
$students = $teacher_id ? getTeacherStudents($teacher_id) : [];

// Get user initials for avatar
$initials = '';
if ($user && $user['full_name']) {
    $name_parts = explode(' ', $user['full_name']);
    $initials = strtoupper(substr($name_parts[0], 0, 1) . (isset($name_parts[1]) ? substr($name_parts[1], 0, 1) : ''));
}

// Get stats for each student
$db = getDB();
foreach ($students as &$student) {
    // Get completed sessions count
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM sessions WHERE child_id = ? AND teacher_id = ? AND status = 'completed'");
    $stmt->bind_param("ii", $student['id'], $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $session_data = $result->fetch_assoc();
    $student['completed_sessions'] = $session_data['count'] ?? 0;
    $stmt->close();
    
    // Get progress reports count
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM progress_reports WHERE child_id = ? AND teacher_id = ?");
    $stmt->bind_param("ii", $student['id'], $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report_data = $result->fetch_assoc();
    $student['progress_reports'] = $report_data['count'] ?? 0;
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - LEARNSAFE.AI</title>
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
                <a href="students.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Student List</h1>
                <p class="text-gray-600">View and manage your assigned students.</p>
            </div>

            <!-- Student Cards -->
            <?php if (empty($students)): ?>
                <div class="bg-white rounded-xl shadow-sm p-12 border border-gray-100 text-center">
                    <i class="fas fa-user-graduate text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg mb-2">No students assigned yet</p>
                    <p class="text-gray-500">Students will appear here once they book sessions with you.</p>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 gap-6">
                    <?php 
                    $colors = ['blue', 'green', 'purple', 'orange', 'pink', 'indigo', 'teal'];
                    foreach ($students as $index => $student): 
                        $student_initials = '';
                        $student_name_parts = explode(' ', $student['name']);
                        $student_initials = strtoupper(substr($student_name_parts[0], 0, 1) . (isset($student_name_parts[1]) ? substr($student_name_parts[1], 0, 1) : ''));
                        $color = $colors[$index % count($colors)];
                    ?>
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-16 h-16 bg-<?php echo $color; ?>-100 rounded-full flex items-center justify-center">
                                    <span class="text-<?php echo $color; ?>-600 font-bold text-xl"><?php echo htmlspecialchars($student_initials); ?></span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($student['name']); ?></h3>
                                    <p class="text-gray-600">Age <?php echo htmlspecialchars($student['age']); ?> <?php echo $student['learning_style'] ? '• ' . htmlspecialchars($student['learning_style']) : ''; ?></p>
                                </div>
                            </div>
                            <div class="space-y-2 mb-4">
                                <p class="text-sm text-gray-600"><span class="font-semibold">Parent:</span> <?php echo htmlspecialchars($student['parent_name']); ?></p>
                                <p class="text-sm text-gray-600"><span class="font-semibold">Sessions:</span> <?php echo number_format($student['completed_sessions']); ?> completed</p>
                                <p class="text-sm text-gray-600"><span class="font-semibold">Progress Reports:</span> <?php echo number_format($student['progress_reports']); ?></p>
                            </div>
                            <div class="flex space-x-3">
                                <a href="reports.php?child_id=<?php echo $student['id']; ?>" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                                    View Progress
                                </a>
                                <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                    Message
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
