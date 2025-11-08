<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking - LEARNSAFE.AI</title>
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
                <p class="text-gray-800 font-semibold">Welcome Back, Sarah! Let's make today great for Alex</p>
            </div>
            <div class="flex items-center space-x-4">
                <i class="fas fa-bell text-gray-600 text-xl cursor-pointer"></i>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 font-bold">SM</span>
                </div>
                <span class="text-gray-800 font-semibold">Sarah M.</span>
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
                <a href="progress.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold">
                    Contact our support
                </button>
            </div>
            <p class="mt-4 text-xs text-gray-500">Do not sell or share my personal info</p>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Progress Tracking</h1>
                <p class="text-gray-600">Monitor Alex's learning journey and achievements.</p>
            </div>

            <!-- Weekly Goals Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center space-x-2 mb-6">
                    <i class="fas fa-bullseye text-blue-500"></i>
                    <h2 class="text-xl font-bold text-gray-800">Weekly Goals</h2>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700">Complete 5 sessions</span>
                            <span class="text-sm text-gray-600">4 / 5</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: 80%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700">Practice phonics daily</span>
                            <span class="text-sm text-gray-600">6 / 7</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: 86%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700">Social interaction exercises</span>
                            <span class="text-sm text-gray-600">3 / 4</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-700">Fine motor skills activities</span>
                            <span class="text-sm text-gray-600">4 / 4</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Progress Overview -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center space-x-2 mb-6">
                    <i class="fas fa-chart-line text-green-500"></i>
                    <h2 class="text-xl font-bold text-gray-800">Monthly Progress Overview</h2>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold text-gray-800">Communication Skills</h3>
                            <span class="text-green-600 font-bold">+12%</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Progress 85%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold text-gray-800">Social Interaction</h3>
                            <span class="text-green-600 font-bold">+8%</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Progress 72%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 72%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold text-gray-800">Academic Learning</h3>
                            <span class="text-green-600 font-bold">+15%</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Progress 78%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold text-gray-800">Fine Motor Skills</h3>
                            <span class="text-green-600 font-bold">+5%</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Progress 90%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                    <div class="p-4 bg-pink-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-semibold text-gray-800">Emotional Regulation</h3>
                            <span class="text-green-600 font-bold">+10%</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Progress 68%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-pink-500 h-2 rounded-full" style="width: 68%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Insights & Recommendations -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center space-x-2 mb-6">
                    <i class="fas fa-lightbulb text-yellow-500"></i>
                    <h2 class="text-xl font-bold text-gray-800">AI Insights & Recommendations</h2>
                </div>
                <div class="text-center py-12 text-gray-400">
                    <i class="fas fa-robot text-4xl mb-4"></i>
                    <p>AI insights will appear here based on your child's progress</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Floating Help Button -->
    <div class="fixed bottom-6 right-6 w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-blue-600 transition">
        <i class="fas fa-question text-white text-xl"></i>
    </div>
</body>
</html>


