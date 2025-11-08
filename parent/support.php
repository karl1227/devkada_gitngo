<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('parent');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$child = getParentChild($user_id);

// Handle support ticket submission
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ticket'])) {
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    $priority = sanitize($_POST['priority'] ?? 'medium');
    
    if (empty($subject) || empty($message)) {
        $error_message = 'Subject and message are required';
    } else {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO support_tickets (user_id, subject, message, priority, status)
            VALUES (?, ?, ?, ?, 'open')
        ");
        $stmt->bind_param("isss", $user_id, $subject, $message, $priority);
        
        if ($stmt->execute()) {
            $success_message = 'Support ticket submitted successfully! We will get back to you soon.';
            logActivity('support_ticket_created', "Support ticket created: {$subject}", $user_id);
            
            // Notify admin
            $adminStmt = $db->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
            $adminStmt->execute();
            $adminResult = $adminStmt->get_result();
            if ($adminResult->num_rows > 0) {
                $admin = $adminResult->fetch_assoc();
                createNotification($admin['id'], 'support_ticket', 'New Support Ticket', 
                    "{$user['full_name']} submitted a support ticket: {$subject}");
            }
            $adminStmt->close();
        } else {
            $error_message = 'Failed to submit support ticket';
        }
        $stmt->close();
    }
}

// Get child's name or default
$child_name = $child ? $child['name'] : 'Your Child';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support & Community - LEARNSAFE.AI</title>
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
                <a href="progress.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-chart-line"></i>
                    <span>Progress</span>
                </a>
                <a href="support.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
                    <i class="fas fa-question-circle"></i>
                    <span>Support</span>
                </a>
            </nav>
            <div class="mt-8 p-4 bg-white rounded-lg">
                <p class="font-semibold text-gray-800 mb-2">Need Help?</p>
                <a href="#contact-support" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold text-center">
                    Contact our support
                </a>
            </div>
            <p class="mt-4 text-xs text-gray-500">Do not sell or share my personal info</p>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Support & Community</h1>
                <p class="text-gray-600">Connect with other parents and access helpful resources.</p>
            </div>

            <?php if ($success_message): ?>
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <!-- Action Cards -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 text-center hover:shadow-md transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-check text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Book Consultation</h3>
                    <p class="text-gray-600 text-sm">With SPED supervisor</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 text-center hover:shadow-md transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-question-circle text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Get Help</h3>
                    <p class="text-gray-600 text-sm">24/7 support available</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 text-center hover:shadow-md transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Join Groups</h3>
                    <p class="text-gray-600 text-sm">Parent support groups</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Contact Support Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6" id="contact-support">
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="fas fa-envelope text-blue-500"></i>
                            <h2 class="text-xl font-bold text-gray-800">Contact Support</h2>
                        </div>
                        <form method="POST" action="support.php">
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                                <input type="text" name="subject" required
                                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                                       placeholder="What can we help you with?">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Priority</label>
                                <select name="priority" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                                <textarea name="message" rows="5" required
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                                          placeholder="Describe your issue or question..."></textarea>
                            </div>
                            <button type="submit" name="submit_ticket" 
                                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                Submit Support Ticket
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Helpful Resources -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Helpful Resources</h2>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-book text-blue-500 mt-1"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Understanding Autism Spectrum</p>
                                    <p class="text-sm text-gray-500">Article • 10 min read</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-book text-blue-500 mt-1"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Creating Sensory-Friendly Spaces</p>
                                    <p class="text-sm text-gray-500">Guide • 15 min read</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-book text-blue-500 mt-1"></i>
                                <div>
                                    <p class="font-semibold text-gray-800">Communication Tools & AAC Devices</p>
                                    <p class="text-sm text-gray-500">Resource • 8 min read</p>
                                </div>
                            </div>
                        </div>
                        <button class="w-full mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            View All Resources
                        </button>
                    </div>

                    <!-- Need Expert Advice -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Need Expert Advice?</h2>
                        <p class="text-gray-600 mb-4">Schedule a free consultation with our SPED education supervisors to discuss your child's unique needs.</p>
                        <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Book Consultation
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
