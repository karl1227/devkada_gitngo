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
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold">
                    Contact our support
                </button>
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
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                        <input type="text" placeholder="City or ZIP code" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Specialization</label>
                        <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                            <option>Select specialization</option>
                            <option>Autism</option>
                            <option>Speech Therapy</option>
                            <option>Behavioral Support</option>
                            <option>Math & Logic</option>
                            <option>Visual Learning</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Availability</label>
                        <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                            <option>Select time</option>
                            <option>Morning (9 AM - 12 PM)</option>
                            <option>Afternoon (12 PM - 5 PM)</option>
                            <option>Evening (5 PM - 8 PM)</option>
                        </select>
                    </div>
                </div>
                <button class="mt-4 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold">
                    Search Teachers
                </button>
            </div>

            <!-- Teacher Listings -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Teacher Card 1 -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-2xl text-purple-600"></i>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xl font-bold text-gray-800">Ms. Emily Johnson</h3>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <p class="text-yellow-500">★ 4.9 (127 reviews)</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-blue-600">$45/hr</span>
                    </div>
                    <p class="text-gray-600 mb-4">Specialized in autism support with a focus on communication and social skills development.</p>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600"><i class="fas fa-user text-gray-400 mr-2"></i>8 years experience</p>
                        <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>San Francisco, CA</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Autism</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Speech Therapy</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Behavioral Support</span>
                    </div>
                    <div class="flex space-x-3">
                        <a href="book-session.php" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                            Book Session
                        </a>
                        <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            View Profile
                        </button>
                    </div>
                </div>

                <!-- Teacher Card 2 -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xl font-bold text-gray-800">Mr. David Chen</h3>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <p class="text-yellow-500">★ 4.8 (93 reviews)</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-blue-600">$40/hr</span>
                    </div>
                    <p class="text-gray-600 mb-4">Passionate about making learning accessible through visual and hands-on methods.</p>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600"><i class="fas fa-user text-gray-400 mr-2"></i>6 years experience</p>
                        <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>Los Angeles, CA</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Autism</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Math & Logic</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Visual Learning</span>
                    </div>
                    <div class="flex space-x-3">
                        <a href="book-session.php" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                            Book Session
                        </a>
                        <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            View Profile
                        </button>
                    </div>
                </div>

                <!-- Teacher Card 3 -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-2xl text-green-600"></i>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xl font-bold text-gray-800">Dr. Sarah Williams</h3>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <p class="text-yellow-500">★ 5 (145 reviews)</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-blue-600">$55/hr</span>
                    </div>
                    <p class="text-gray-600 mb-4">Board-certified specialist in autism education with extensive sensory integration training.</p>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600"><i class="fas fa-user text-gray-400 mr-2"></i>12 years experience</p>
                        <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>San Diego, CA</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Autism</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Sensory Integration</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Behavioral Support</span>
                    </div>
                    <div class="flex space-x-3">
                        <a href="book-session.php" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                            Book Session
                        </a>
                        <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            View Profile
                        </button>
                    </div>
                </div>

                <!-- Teacher Card 4 -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-2xl text-pink-600"></i>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xl font-bold text-gray-800">Ms. Jennifer Lopez</h3>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <p class="text-yellow-500">★ 4.9 (108 reviews)</p>
                            </div>
                        </div>
                        <span class="text-lg font-bold text-blue-600">$42/hr</span>
                    </div>
                    <p class="text-gray-600 mb-4">Creating safe, supportive environments for children to thrive academically and socially.</p>
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600"><i class="fas fa-user text-gray-400 mr-2"></i>7 years experience</p>
                        <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>Sacramento, CA</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Autism</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Social Skills</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">Academic Support</span>
                    </div>
                    <div class="flex space-x-3">
                        <a href="book-session.php" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-center">
                            Book Session
                        </a>
                        <button class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition font-semibold">
                            View Profile
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


