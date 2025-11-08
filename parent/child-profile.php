<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('parent');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$child = getParentChild($user_id);

// Handle form submission
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $learning_style = sanitize($_POST['learning_style'] ?? '');
    $communication_style = sanitize($_POST['communication_style'] ?? '');
    $sensitivities = sanitize($_POST['sensitivities'] ?? '');
    $interests = sanitize($_POST['interests'] ?? '');
    $special_accommodations = sanitize($_POST['special_accommodations'] ?? '');
    
    if (empty($name) || $age <= 0) {
        $error_message = 'Name and age are required';
    } else {
        $db = getDB();
        if ($child) {
            // Update existing child
            $stmt = $db->prepare("
                UPDATE children 
                SET name = ?, age = ?, learning_style = ?, communication_style = ?, 
                    sensitivities = ?, interests = ?, special_accommodations = ?, updated_at = NOW()
                WHERE id = ? AND parent_id = ?
            ");
            $stmt->bind_param("sisssssii", $name, $age, $learning_style, $communication_style, 
                $sensitivities, $interests, $special_accommodations, $child['id'], $user_id);
        } else {
            // Create new child
            $stmt = $db->prepare("
                INSERT INTO children (parent_id, name, age, learning_style, communication_style, 
                    sensitivities, interests, special_accommodations)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("isisssss", $user_id, $name, $age, $learning_style, $communication_style,
                $sensitivities, $interests, $special_accommodations);
        }
        
        if ($stmt->execute()) {
            $success_message = 'Child profile saved successfully!';
            $child = getParentChild($user_id); // Refresh child data
            logActivity('child_profile_updated', "Child profile updated: {$name}", $user_id);
        } else {
            $error_message = 'Failed to save profile';
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
    <title>My Child's Profile - LEARNSAFE.AI</title>
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
                <a href="child-profile.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <a href="support.php" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold text-center">
                    Contact our support
                </a>
            </div>
            <p class="mt-4 text-xs text-gray-500">Do not sell or share my personal info</p>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">My Child's Profile</h1>
                <p class="text-gray-600">Help teachers understand your child's unique needs</p>
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

            <form method="POST" action="">
                <!-- Profile Photo Section -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                        Profile Photo
                    </h2>
                    <div class="flex items-center space-x-6">
                        <div class="w-32 h-32 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-5xl text-blue-600"></i>
                        </div>
                        <div>
                            <button type="button" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold mb-2">
                                Upload New Photo
                            </button>
                            <p class="text-sm text-gray-500">Recommended: Square photo, max 5MB</p>
                        </div>
                    </div>
                </div>

                <!-- Basic Information Section -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-6">Basic Information</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Child's Name *</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($child['name'] ?? ''); ?>" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Age *</label>
                            <input type="number" name="age" value="<?php echo htmlspecialchars($child['age'] ?? ''); ?>" 
                                   min="1" max="18" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Learning Style</label>
                            <select name="learning_style" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                                <option value="">Select learning style</option>
                                <option value="Visual" <?php echo ($child['learning_style'] ?? '') === 'Visual' ? 'selected' : ''; ?>>Visual</option>
                                <option value="Auditory" <?php echo ($child['learning_style'] ?? '') === 'Auditory' ? 'selected' : ''; ?>>Auditory</option>
                                <option value="Kinesthetic" <?php echo ($child['learning_style'] ?? '') === 'Kinesthetic' ? 'selected' : ''; ?>>Kinesthetic</option>
                                <option value="Visual, Hands-on" <?php echo ($child['learning_style'] ?? '') === 'Visual, Hands-on' ? 'selected' : ''; ?>>Visual, Hands-on</option>
                                <option value="Mixed" <?php echo ($child['learning_style'] ?? '') === 'Mixed' ? 'selected' : ''; ?>>Mixed</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Communication Style</label>
                            <select name="communication_style" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                                <option value="">Select communication style</option>
                                <option value="Verbal" <?php echo ($child['communication_style'] ?? '') === 'Verbal' ? 'selected' : ''; ?>>Verbal</option>
                                <option value="Non-verbal" <?php echo ($child['communication_style'] ?? '') === 'Non-verbal' ? 'selected' : ''; ?>>Non-verbal</option>
                                <option value="Verbal & AAC" <?php echo ($child['communication_style'] ?? '') === 'Verbal & AAC' ? 'selected' : ''; ?>>Verbal & AAC</option>
                                <option value="AAC Only" <?php echo ($child['communication_style'] ?? '') === 'AAC Only' ? 'selected' : ''; ?>>AAC Only</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Learning Preferences & Needs Section -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-6">Learning Preferences & Needs</h2>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sensitivities</label>
                            <input type="text" name="sensitivities" 
                                   value="<?php echo htmlspecialchars($child['sensitivities'] ?? ''); ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" 
                                   placeholder="List any sensitivities (e.g., Loud noises, bright lights)">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Interests & Motivators</label>
                            <input type="text" name="interests" 
                                   value="<?php echo htmlspecialchars($child['interests'] ?? ''); ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" 
                                   placeholder="What interests your child? (e.g., Dinosaurs, building blocks, music)">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Special Accommodations</label>
                            <textarea name="special_accommodations" rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" 
                                      placeholder="Any special accommodations needed?"><?php echo htmlspecialchars($child['special_accommodations'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end space-x-4">
                    <a href="dashboard.php" class="px-6 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                        Save Changes
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
