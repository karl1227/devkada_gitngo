<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - LEARNSAFE.AI</title>
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
                <a href="reports.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Student Reports</h1>
                <p class="text-gray-600">Upload and manage student progress reports.</p>
            </div>

            <!-- Select Student -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Select Student</label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                    <option>Alex Martinez</option>
                    <option>Sarah Miller</option>
                </select>
            </div>

            <!-- Report Form -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Create Progress Report</h2>
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Session Date</label>
                        <input type="date" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Progress Notes</label>
                        <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" rows="5" placeholder="Describe the student's progress, achievements, and areas for improvement..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Skills Practiced</label>
                        <input type="text" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="e.g., Communication, Social Skills, Math">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Next Steps</label>
                        <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" rows="3" placeholder="Recommendations for next session..."></textarea>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                        Submit Report
                    </button>
                </form>
            </div>

            <!-- Recent Reports -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Reports</h2>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-gray-800">Alex Martinez - Session Report</h3>
                                <p class="text-sm text-gray-600">November 5, 2025</p>
                            </div>
                            <button class="text-blue-600 hover:underline font-semibold">View</button>
                        </div>
                        <p class="text-sm text-gray-700">Great progress in communication skills. Alex showed improved focus during visual learning activities.</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-green-500">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-bold text-gray-800">Sarah Miller - Session Report</h3>
                                <p class="text-sm text-gray-600">November 4, 2025</p>
                            </div>
                            <button class="text-blue-600 hover:underline font-semibold">View</button>
                        </div>
                        <p class="text-sm text-gray-700">Excellent engagement in social interaction exercises. Recommended to continue with sensory breaks.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>


