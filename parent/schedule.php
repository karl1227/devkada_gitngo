<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('parent');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$child = getParentChild($user_id);

// Get current month/year or from query
$current_month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$current_year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Get all sessions for the current month
$sessions = getAllSessions($user_id, null, $current_month, $current_year);
$upcoming_sessions = getUpcomingSessions($user_id, 10);

// Get child's name or default
$child_name = $child ? $child['name'] : 'Your Child';

// Helper function to get status color
function getStatusColor($status) {
    switch($status) {
        case 'confirmed': return 'bg-green-50 border-green-500';
        case 'pending': return 'bg-yellow-50 border-yellow-500';
        case 'completed': return 'bg-blue-50 border-blue-500';
        case 'cancelled': return 'bg-red-50 border-red-500';
        default: return 'bg-gray-50 border-gray-300';
    }
}

// Helper function to format session time
function formatSessionTime($date, $time, $duration) {
    $start = date('h:i A', strtotime($time));
    $end_time = date('h:i A', strtotime($time . " +{$duration} minutes"));
    $date_formatted = date('M d, Y', strtotime($date));
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    
    if ($date == $today) {
        return "Today, {$start} - {$end_time}";
    } elseif ($date == $tomorrow) {
        return "Tomorrow, {$start} - {$end_time}";
    } else {
        return "{$date_formatted}, {$start} - {$end_time}";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule - LEARNSAFE.AI</title>
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
                <a href="schedule.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <a href="support.php" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold text-center">
                    Contact our support
                </a>
            </div>
            <p class="mt-4 text-xs text-gray-500">Do not sell or share my personal info</p>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Schedule</h1>
                    <p class="text-gray-600">View and manage your upcoming sessions.</p>
                </div>
                <a href="find-teacher.php" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                    <i class="fas fa-plus mr-2"></i>Book New Session
                </a>
            </div>

            <!-- Upcoming Sessions List -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Upcoming Sessions</h2>
                <div class="space-y-4" id="sessionsList">
                    <?php if (empty($upcoming_sessions)): ?>
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600 text-lg">No upcoming sessions</p>
                            <p class="text-gray-500 text-sm mt-2">Book a session with a teacher to get started!</p>
                            <a href="find-teacher.php" class="inline-block mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                Find a Teacher
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($upcoming_sessions as $session): ?>
                            <div class="flex items-center justify-between p-4 <?php echo getStatusColor($session['status']); ?> rounded-lg border-l-4">
                                <div class="flex items-center space-x-4 flex-1">
                                    <div class="w-12 h-12 <?php echo $session['status'] == 'confirmed' ? 'bg-green-500' : 'bg-yellow-500'; ?> rounded-full flex items-center justify-center">
                                        <i class="fas fa-calendar text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-800">Session with <?php echo htmlspecialchars($session['teacher_name']); ?></h3>
                                        <p class="text-sm text-gray-600">For: <?php echo htmlspecialchars($session['child_name']); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo formatSessionTime($session['session_date'], $session['session_time'], $session['duration_minutes']); ?></p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Status: <span class="font-semibold capitalize"><?php echo htmlspecialchars($session['status']); ?></span>
                                            | Amount: $<?php echo number_format($session['amount'], 2); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <?php if ($session['status'] == 'confirmed' && strtotime($session['session_date'] . ' ' . $session['session_time']) <= time() + 3600): ?>
                                        <button onclick="joinSession(<?php echo $session['id']; ?>)" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                            Join Session
                                        </button>
                                    <?php endif; ?>
                                    <?php if (in_array($session['status'], ['pending', 'confirmed'])): ?>
                                        <button onclick="openRescheduleModal(<?php echo $session['id']; ?>)" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition font-semibold">
                                            <i class="fas fa-edit mr-1"></i>Reschedule
                                        </button>
                                        <button onclick="cancelSession(<?php echo $session['id']; ?>)" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition font-semibold">
                                            <i class="fas fa-times mr-1"></i>Cancel
                                        </button>
                                    <?php endif; ?>
                                    <button onclick="viewSessionDetails(<?php echo $session['id']; ?>)" class="px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Past Sessions -->
            <?php 
            $past_sessions = array_filter($sessions, function($s) {
                $session_datetime = strtotime($s['session_date'] . ' ' . $s['session_time']);
                return $session_datetime < time() || in_array($s['status'], ['completed', 'cancelled']);
            });
            if (!empty($past_sessions)): 
            ?>
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Past Sessions</h2>
                <div class="space-y-4">
                    <?php foreach (array_slice($past_sessions, 0, 5) as $session): ?>
                        <div class="flex items-center justify-between p-4 <?php echo getStatusColor($session['status']); ?> rounded-lg border-l-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Session with <?php echo htmlspecialchars($session['teacher_name']); ?></h3>
                                    <p class="text-sm text-gray-600">For: <?php echo htmlspecialchars($session['child_name']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo formatSessionTime($session['session_date'], $session['session_time'], $session['duration_minutes']); ?></p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Status: <span class="font-semibold capitalize"><?php echo htmlspecialchars($session['status']); ?></span>
                                    </p>
                                </div>
                            </div>
                            <button onclick="viewSessionDetails(<?php echo $session['id']; ?>)" class="px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                View Details
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Reschedule Modal -->
    <div id="rescheduleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Reschedule Session</h3>
                <button onclick="closeRescheduleModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="rescheduleForm" onsubmit="rescheduleSession(event)">
                <input type="hidden" id="rescheduleSessionId" name="session_id">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Date</label>
                    <input type="date" id="newDate" name="new_date" required min="<?php echo date('Y-m-d'); ?>" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Time</label>
                    <input type="time" id="newTime" name="new_time" required class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                        Confirm Reschedule
                    </button>
                    <button type="button" onclick="closeRescheduleModal()" class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Session Details Modal -->
    <div id="sessionDetailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Session Details</h3>
                <button onclick="closeSessionDetailsModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="sessionDetailsContent" class="space-y-4">
                <!-- Details will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function openRescheduleModal(sessionId) {
            document.getElementById('rescheduleSessionId').value = sessionId;
            document.getElementById('rescheduleModal').classList.remove('hidden');
        }

        function closeRescheduleModal() {
            document.getElementById('rescheduleModal').classList.add('hidden');
            document.getElementById('rescheduleForm').reset();
        }

        function rescheduleSession(event) {
            event.preventDefault();
            const sessionId = document.getElementById('rescheduleSessionId').value;
            const newDate = document.getElementById('newDate').value;
            const newTime = document.getElementById('newTime').value;

            fetch('../api/reschedule_session.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    session_id: sessionId,
                    new_date: newDate,
                    new_time: newTime
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Session rescheduled successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred. Please try again.');
            });
        }

        function cancelSession(sessionId) {
            if (!confirm('Are you sure you want to cancel this session?')) return;

            const reason = prompt('Please provide a reason for cancellation (optional):') || '';

            fetch('../api/cancel_session.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    session_id: sessionId,
                    reason: reason
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Session cancelled successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred. Please try again.');
            });
        }

        function viewSessionDetails(sessionId) {
            // Load session details via AJAX
            fetch(`../api/get_session.php?id=${sessionId}`)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const session = data.session;
                        const content = `
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-600">Teacher</p>
                                    <p class="font-semibold text-gray-800">${session.teacher_name}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Child</p>
                                    <p class="font-semibold text-gray-800">${session.child_name}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Date & Time</p>
                                    <p class="font-semibold text-gray-800">${new Date(session.session_date + 'T' + session.session_time).toLocaleString()}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Duration</p>
                                    <p class="font-semibold text-gray-800">${session.duration_minutes} minutes</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <p class="font-semibold text-gray-800 capitalize">${session.status}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Amount</p>
                                    <p class="font-semibold text-gray-800">$${parseFloat(session.amount).toFixed(2)}</p>
                                </div>
                                ${session.notes ? `<div><p class="text-sm text-gray-600">Notes</p><p class="text-gray-800">${session.notes}</p></div>` : ''}
                            </div>
                        `;
                        document.getElementById('sessionDetailsContent').innerHTML = content;
                        document.getElementById('sessionDetailsModal').classList.remove('hidden');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to load session details');
                });
        }

        function closeSessionDetailsModal() {
            document.getElementById('sessionDetailsModal').classList.add('hidden');
        }

        function joinSession(sessionId) {
            // Implement join session functionality (video call, etc.)
            alert('Join session functionality will be implemented here');
        }
    </script>
</body>
</html>
