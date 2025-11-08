<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('parent');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$child = getParentChild($user_id);

// Get filters from query
$location_filter = sanitize($_GET['location'] ?? '');
$specialization_filter = sanitize($_GET['specialization'] ?? '');
$availability_filter = sanitize($_GET['availability'] ?? '');

// Build filters array
$filters = [];
if (!empty($location_filter)) {
    $filters['location'] = $location_filter;
}
if (!empty($specialization_filter)) {
    $filters['specialization'] = $specialization_filter;
}

// Get all verified teachers
$teachers = getVerifiedTeachers($filters);

// Get all specializations for filter dropdown
$db = getDB();
$stmt = $db->query("SELECT DISTINCT specialization FROM teacher_specializations ORDER BY specialization");
$all_specializations = [];
while ($row = $stmt->fetch_assoc()) {
    $all_specializations[] = $row['specialization'];
}
$stmt->close();

// Get child's name or default
$child_name = $child ? $child['name'] : 'Your Child';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Teacher - LEARNSAFE.AI</title>
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
                <a href="find-teacher.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Find a Teacher</h1>
                <p class="text-gray-600">Browse verified SPED teachers for your child.</p>
            </div>

            <!-- Search Filters -->
            <div class="bg-gray-100 rounded-xl p-6 mb-8">
                <form method="GET" action="find-teacher.php" class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                        <input type="text" name="location" value="<?php echo htmlspecialchars($location_filter); ?>" 
                               placeholder="City or ZIP code" 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Specialization</label>
                        <select name="specialization" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                            <option value="">All Specializations</option>
                            <?php foreach ($all_specializations as $spec): ?>
                                <option value="<?php echo htmlspecialchars($spec); ?>" 
                                        <?php echo $specialization_filter === $spec ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($spec); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Availability</label>
                        <select name="availability" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                            <option value="">All Times</option>
                            <option value="morning" <?php echo $availability_filter === 'morning' ? 'selected' : ''; ?>>Morning (9 AM - 12 PM)</option>
                            <option value="afternoon" <?php echo $availability_filter === 'afternoon' ? 'selected' : ''; ?>>Afternoon (12 PM - 5 PM)</option>
                            <option value="evening" <?php echo $availability_filter === 'evening' ? 'selected' : ''; ?>>Evening (5 PM - 8 PM)</option>
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            <i class="fas fa-search mr-2"></i>Search Teachers
                        </button>
                        <?php if (!empty($location_filter) || !empty($specialization_filter) || !empty($availability_filter)): ?>
                            <a href="find-teacher.php" class="ml-3 px-6 py-3 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                Clear Filters
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Teacher Listings -->
            <div class="grid md:grid-cols-2 gap-6">
                <?php if (empty($teachers)): ?>
                    <div class="md:col-span-2 text-center py-12">
                        <i class="fas fa-user-tie text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-lg">No teachers found</p>
                        <p class="text-gray-500 text-sm mt-2">Try adjusting your search filters</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($teachers as $teacher): 
                        $specs = !empty($teacher['specializations']) ? explode(',', $teacher['specializations']) : [];
                        $rating = floatval($teacher['rating'] ?? 0);
                        $total_reviews = intval($teacher['total_reviews'] ?? 0);
                        $hourly_rate = floatval($teacher['hourly_rate'] ?? 0);
                        $years_exp = intval($teacher['years_experience'] ?? 0);
                    ?>
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-tie text-2xl text-purple-600"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($teacher['full_name']); ?></h3>
                                            <i class="fas fa-check-circle text-green-500" title="Verified"></i>
                                        </div>
                                        <p class="text-yellow-500">
                                            ★ <?php echo number_format($rating, 1); ?> 
                                            <?php if ($total_reviews > 0): ?>
                                                (<?php echo $total_reviews; ?> review<?php echo $total_reviews !== 1 ? 's' : ''; ?>)
                                            <?php else: ?>
                                                (No reviews yet)
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold text-blue-600">$<?php echo number_format($hourly_rate, 2); ?>/hr</span>
                            </div>
                            <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($teacher['bio'] ?? 'Experienced SPED teacher dedicated to helping children learn and grow.'); ?></p>
                            <div class="space-y-2 mb-4">
                                <?php if ($years_exp > 0): ?>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-user text-gray-400 mr-2"></i>
                                        <?php echo $years_exp; ?> year<?php echo $years_exp !== 1 ? 's' : ''; ?> experience
                                    </p>
                                <?php endif; ?>
                                <?php if (!empty($teacher['location'])): ?>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                        <?php echo htmlspecialchars($teacher['location']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($specs)): ?>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <?php foreach (array_slice($specs, 0, 3) as $spec): ?>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                            <?php echo htmlspecialchars(trim($spec)); ?>
                                        </span>
                                    <?php endforeach; ?>
                                    <?php if (count($specs) > 3): ?>
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-semibold">
                                            +<?php echo count($specs) - 3; ?> more
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="flex space-x-3">
                                <a href="book-session.php?teacher_id=<?php echo $teacher['id']; ?>" 
                                   class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                                    Book Session
                                </a>
                                <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                                    View Profile
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
