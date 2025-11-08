<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Insights - LEARNSAFE.AI</title>
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
                <a href="students.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-users"></i>
                    <span>Students</span>
                </a>
                <a href="reports.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                <a href="ai-insights.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">AI Insights</h1>
                <p class="text-gray-600">AI-generated suggestions for better teaching effectiveness.</p>
            </div>

            <!-- AI Insights Cards -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-lightbulb text-yellow-500"></i>
                        <h2 class="text-xl font-bold text-gray-800">Teaching Effectiveness Insights</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-2">Visual Learning Methods</h3>
                            <p class="text-sm text-gray-600">Your students show 25% better engagement when using visual aids. Consider incorporating more visual learning tools in your sessions.</p>
                        </div>
                        <div class="p-4 bg-green-50 rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-2">Session Timing</h3>
                            <p class="text-sm text-gray-600">Morning sessions (9-11 AM) show higher student focus rates. Consider scheduling more sessions during this time.</p>
                        </div>
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-2">Break Frequency</h3>
                            <p class="text-sm text-gray-600">Students perform better with 20-minute intervals between activities. Current average is 25 minutes - consider shorter intervals.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-chart-line text-green-500"></i>
                        <h2 class="text-xl font-bold text-gray-800">Student Performance Analysis</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-2">Alex Martinez</h3>
                            <p class="text-sm text-gray-600 mb-2">Strong progress in communication skills (+12% this month). Recommended focus: Social interaction exercises.</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold text-gray-800 mb-2">Sarah Miller</h3>
                            <p class="text-sm text-gray-600 mb-2">Good progress in social interaction (+8% this month). Recommended focus: Fine motor skills.</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 72%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-robot text-blue-500"></i>
                        <h2 class="text-xl font-bold text-gray-800">AI Recommendations</h2>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-lg">
                            <i class="fas fa-check-circle text-blue-500 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Try sensory breaks every 20 minutes</p>
                                <p class="text-sm text-gray-600">Based on student engagement patterns</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-lg">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Incorporate more hands-on activities</p>
                                <p class="text-sm text-gray-600">Students show better retention with kinesthetic learning</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 p-4 bg-purple-50 rounded-lg">
                            <i class="fas fa-check-circle text-purple-500 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Use visual schedules for transitions</p>
                                <p class="text-sm text-gray-600">Reduces anxiety during activity changes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>


