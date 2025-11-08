<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Session - LEARNSAFE.AI</title>
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
                <a href="schedule.php" class="flex items-center space-x-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-lg font-semibold border-l-4 border-blue-500">
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
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Book a Session</h1>
                <p class="text-gray-600">Schedule a learning session with your teacher.</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Selected Teacher Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Selected Teacher</h2>
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-3xl text-purple-600"></i>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-xl font-bold text-gray-800">Ms. Emily Johnson</h3>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <p class="text-yellow-500">★ 4.9 (127)</p>
                                <p class="text-sm text-gray-600 mt-1"><span class="font-semibold">Specialization:</span> Speech</p>
                                <p class="text-sm text-gray-600"><span class="font-semibold">Experience:</span> 8 years</p>
                                <p class="text-lg font-bold text-blue-600 mt-2">Hourly Rate: $45/hr</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Summary Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Booking Summary</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-semibold text-gray-800">Nov 8, 2025</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Time:</span>
                                <span class="font-semibold text-gray-800">10:00 AM</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold text-gray-800">1 hour</span>
                            </div>
                            <div class="border-t pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                                    <span class="text-xl font-bold text-blue-600">$45.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Select Date & Time Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Select Date & Time</h2>
                        
                        <!-- Calendar Widget -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <button class="px-3 py-1 hover:bg-gray-100 rounded"><i class="fas fa-chevron-left"></i></button>
                                <h3 class="text-lg font-bold text-gray-800">November 2025</h3>
                                <button class="px-3 py-1 hover:bg-gray-100 rounded"><i class="fas fa-chevron-right"></i></button>
                            </div>
                            <div class="grid grid-cols-7 gap-2 mb-2">
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">Su</div>
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">Mo</div>
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">Tu</div>
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">We</div>
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">Th</div>
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">Fr</div>
                                <div class="text-center text-sm font-semibold text-gray-600 py-2">Sa</div>
                            </div>
                            <div class="grid grid-cols-7 gap-2">
                                <div class="text-center py-2 text-gray-400 text-sm">27</div>
                                <div class="text-center py-2 text-gray-400 text-sm">28</div>
                                <div class="text-center py-2 text-gray-400 text-sm">29</div>
                                <div class="text-center py-2 text-gray-400 text-sm">30</div>
                                <div class="text-center py-2 text-gray-400 text-sm">31</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">1</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">2</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">3</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">4</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">5</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">6</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">7</div>
                                <div class="text-center py-2 bg-blue-500 text-white rounded font-semibold">8</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">9</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">10</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">11</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">12</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">13</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">14</div>
                                <div class="text-center py-2 text-gray-700 hover:bg-gray-100 rounded cursor-pointer">15</div>
                            </div>
                        </div>

                        <!-- Available Time Slots -->
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-3">Available Time Slots</h3>
                            <div class="grid grid-cols-4 gap-2">
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">9:00 AM</button>
                                <button class="px-4 py-2 border-2 border-blue-500 bg-blue-50 rounded-lg font-semibold text-blue-600">10:00 AM</button>
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">11:00 AM</button>
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">1:00 PM</button>
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">2:00 PM</button>
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">3:00 PM</button>
                                <button class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">4:00 PM</button>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Payment Method</h2>
                        <p class="text-gray-600 mb-6">Payment will be processed securely through our platform.</p>
                        <div class="space-y-3 mb-6">
                            <button class="w-full px-6 py-4 border-2 border-blue-500 bg-blue-50 rounded-lg hover:bg-blue-100 transition flex items-center justify-center space-x-3">
                                <i class="fab fa-paypal text-2xl text-blue-600"></i>
                                <span class="font-semibold text-gray-800">PayPal</span>
                            </button>
                            <button class="w-full px-6 py-4 border-2 border-orange-500 bg-orange-50 rounded-lg hover:bg-orange-100 transition flex items-center justify-center space-x-3">
                                <i class="fas fa-mobile-alt text-2xl text-orange-600"></i>
                                <span class="font-semibold text-gray-800">GCash</span>
                            </button>
                        </div>
                        <button class="w-full px-6 py-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-lg">
                            Confirm Booking
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


