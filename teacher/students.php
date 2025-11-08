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
                <p class="text-gray-800 font-semibold">Welcome Back, Emily!</p>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <span class="text-purple-600 font-bold">EJ</span>
                </div>
                <span class="text-gray-800 font-semibold">Emily Johnson</span>
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
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xl">AM</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Alex Martinez</h3>
                            <p class="text-gray-600">Age 7 • Visual Learner</p>
                        </div>
                    </div>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600"><span class="font-semibold">Parent:</span> Sarah Martinez</p>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Sessions:</span> 28 completed</p>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Progress:</span> +12% this month</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="reports.php" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                            View Progress
                        </a>
                        <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            Message
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-bold text-xl">SM</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Sarah Miller</h3>
                            <p class="text-gray-600">Age 8 • Kinesthetic Learner</p>
                        </div>
                    </div>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600"><span class="font-semibold">Parent:</span> John Miller</p>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Sessions:</span> 22 completed</p>
                        <p class="text-sm text-gray-600"><span class="font-semibold">Progress:</span> +8% this month</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="reports.php" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                            View Progress
                        </a>
                        <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            Message
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>


