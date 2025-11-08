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
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold">
                    Contact our support
                </button>
            </div>
            <p class="mt-4 text-xs text-gray-500">Do not sell or share my personal info</p>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Schedule</h1>
                <p class="text-gray-600">View and manage your upcoming sessions.</p>
            </div>

            <!-- Calendar View -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">November 2025</h2>
                    <div class="flex space-x-2">
                        <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-2">
                    <div class="text-center font-semibold text-gray-600 py-2">Sun</div>
                    <div class="text-center font-semibold text-gray-600 py-2">Mon</div>
                    <div class="text-center font-semibold text-gray-600 py-2">Tue</div>
                    <div class="text-center font-semibold text-gray-600 py-2">Wed</div>
                    <div class="text-center font-semibold text-gray-600 py-2">Thu</div>
                    <div class="text-center font-semibold text-gray-600 py-2">Fri</div>
                    <div class="text-center font-semibold text-gray-600 py-2">Sat</div>
                    <!-- Calendar days would go here -->
                </div>
            </div>

            <!-- Upcoming Sessions List -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Upcoming Sessions</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Speech Therapy</h3>
                                <p class="text-sm text-gray-600">Ms. Emily Johnson</p>
                                <p class="text-sm text-gray-500">Today, 10:00 AM - 11:00 AM</p>
                            </div>
                        </div>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                            Join Session
                        </button>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border-l-4 border-gray-300">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Math Fundamentals</h3>
                                <p class="text-sm text-gray-600">Ms. Emily Johnson</p>
                                <p class="text-sm text-gray-500">Tomorrow, 9:30 AM - 10:15 AM</p>
                            </div>
                        </div>
                        <button class="px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            View Details
                        </button>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border-l-4 border-gray-300">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Social Skills</h3>
                                <p class="text-sm text-gray-600">Mr. David Chen</p>
                                <p class="text-sm text-gray-500">Wed, Nov 10, 10:00 AM - 11:00 AM</p>
                            </div>
                        </div>
                        <button class="px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            View Details
                        </button>
                    </div>
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


