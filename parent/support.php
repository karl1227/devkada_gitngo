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
                <a href="progress.php" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-200 rounded-lg transition">
                    <i class="fas fa-chart-line"></i>
                    <span>Progress</span>
                </a>
                <a href="support.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold border-l-4 border-blue-500">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Support & Community</h1>
                <p class="text-gray-600">Connect with other parents and access helpful resources.</p>
            </div>

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
                <!-- Community Forum -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-6">
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="fas fa-comments text-blue-500"></i>
                            <h2 class="text-xl font-bold text-gray-800">Community Forum</h2>
                        </div>
                        <div class="mb-6">
                            <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" rows="3" placeholder="Share your experiences, ask questions, or offer support..."></textarea>
                            <button class="mt-3 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                                Post to Community
                            </button>
                        </div>
                        <div class="space-y-4">
                            <!-- Post 1 -->
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-start space-x-4 mb-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-bold">MJ</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="font-semibold text-gray-800">Maria J.</span>
                                            <span class="text-sm text-gray-500">2 hours ago</span>
                                        </div>
                                        <h3 class="font-bold text-gray-800 mb-2">Visual schedule templates that worked for us</h3>
                                        <p class="text-gray-600 mb-3">Wanted to share some visual schedule templates we've been using with our son. They've really helped with morning routines!</p>
                                        <div class="flex items-center space-x-4">
                                            <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span>24</span>
                                            </button>
                                            <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                                                <i class="fas fa-comment"></i>
                                                <span>8 replies</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Post 2 -->
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-start space-x-4 mb-3">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 font-bold">TS</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="font-semibold text-gray-800">Tom S.</span>
                                            <span class="text-sm text-gray-500">5 hours ago</span>
                                        </div>
                                        <h3 class="font-bold text-gray-800 mb-2">Transition strategies during sessions</h3>
                                        <p class="text-gray-600 mb-3">Does anyone have tips for helping with transitions during learning sessions? My daughter struggles when switching activities.</p>
                                        <div class="flex items-center space-x-4">
                                            <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span>15</span>
                                            </button>
                                            <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                                                <i class="fas fa-comment"></i>
                                                <span>12 replies</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <!-- Floating Help Button -->
    <div class="fixed bottom-6 right-6 w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-blue-600 transition">
        <i class="fas fa-question text-white text-xl"></i>
    </div>
</body>
</html>


