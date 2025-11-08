<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEARNSAFE.AI - Safe, Smart, and Supportive Learning</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-heart {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
        }
        .gradient-teacher {
            background: linear-gradient(135deg, #818cf8 0%, #a78bfa 100%);
        }
        .gradient-parent {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 gradient-heart rounded-lg flex items-center justify-center">
                    <i class="fas fa-heart text-white text-sm"></i>
                </div>
                <span class="text-2xl font-bold text-blue-600">LEARNSAFE.AI</span>
            </div>
            <a href="signin.php" class="px-6 py-2 border-2 border-blue-400 rounded-lg text-blue-600 font-semibold hover:bg-blue-50 transition">
                Sign In
            </a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="container mx-auto px-6 py-16">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div>
                <div class="inline-block bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    Trusted by 500+ families
                </div>
                <h1 class="text-5xl font-bold text-gray-800 mb-6">
                    Safe, Smart, and Supportive Learning for Every Child
                </h1>
                <p class="text-lg text-gray-600 mb-8">
                    Find verified SPED teachers trained for autism-friendly home learning. Personalized, safe, and empowering education for your child.
                </p>
                <div class="flex space-x-4">
                    <a href="signup.php" class="px-8 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition">
                        Get Started
                    </a>
                    <a href="#how-it-works" class="px-8 py-3 bg-white border-2 border-blue-400 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">
                        Learn More
                    </a>
                </div>
            </div>
            <!-- Right Image -->
            <div class="hidden md:block">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="bg-gradient-to-br from-blue-100 to-green-100 rounded-xl h-96 flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-6xl text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Parents Choose Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Why Parents Choose LearnSafe.AI</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-12">
                We understand the unique needs of children with autism and provide a safe, supportive environment for personalized learning.
            </p>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-blue-50 rounded-xl p-8">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Verified Teachers</h3>
                    <p class="text-gray-600">All teachers are background-checked and SPED-certified</p>
                </div>
                <div class="bg-green-50 rounded-xl p-8">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-brain text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">AI-Powered Matching</h3>
                    <p class="text-gray-600">Smart recommendations based on your child's unique needs</p>
                </div>
                <div class="bg-purple-50 rounded-xl p-8">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Progress Tracking</h3>
                    <p class="text-gray-600">Monitor your child's learning journey with detailed insights</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="container mx-auto px-6 py-16">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-4">How It Works</h2>
        <p class="text-lg text-gray-600 text-center mb-12">Simple steps for teachers and parents</p>
        
        <div class="grid md:grid-cols-2 gap-8">
            <!-- For Teachers Card -->
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-8 text-white">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold">For Teachers</h3>
                </div>
                <p class="mb-6 opacity-90">Join our network of verified educators.</p>
                <ol class="space-y-3">
                    <li class="flex items-start">
                        <span class="font-bold mr-3">1.</span>
                        <span>Sign up with your credentials</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">2.</span>
                        <span>Upload teaching license for verification</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">3.</span>
                        <span>Wait for account approval (1-2 days)</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">4.</span>
                        <span>Start connecting with parents</span>
                    </li>
                </ol>
            </div>

            <!-- For Parents Card -->
            <div class="bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl p-8 text-white">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold">For Parents</h3>
                </div>
                <p class="mb-6 opacity-90">Find the perfect teacher for your child.</p>
                <ol class="space-y-3">
                    <li class="flex items-start">
                        <span class="font-bold mr-3">1.</span>
                        <span>Sign up and create your profile</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">2.</span>
                        <span>Add your child's information</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">3.</span>
                        <span>Match with verified SPED teachers</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-3">4.</span>
                        <span>Monitor learning progress with AI insights</span>
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-white py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-gray-800 text-center mb-12">What Parents Are Saying</h2>
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white border-2 border-gray-100 rounded-xl p-8 shadow-sm">
                    <div class="flex mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-700 mb-6 italic">
                        "LearnSafe.AI helped us find the perfect teacher for our son. She understands his needs and he's made incredible progress!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold">MJ</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Maria Johnson</p>
                            <p class="text-sm text-gray-500">Parent from California</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white border-2 border-gray-100 rounded-xl p-8 shadow-sm">
                    <div class="flex mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-700 mb-6 italic">
                        "The platform is so easy to use and the teachers are amazing. My daughter actually looks forward to her sessions now!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold">TS</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Tom Sanders</p>
                            <p class="text-sm text-gray-500">Parent from Texas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-400 to-green-400 py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Ready to Get Started?</h2>
            <p class="text-xl text-white opacity-90 mb-8">
                Join hundreds of families finding the perfect learning match for their child.
            </p>
            <a href="signup.php" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-bold text-lg hover:bg-gray-100 transition">
                Create Account
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <p class="text-gray-400">© 2025 LearnSafe.AI — Supporting neurodiverse learners everywhere</p>
            <a href="admin/login.php" class="text-gray-400 hover:text-white">Admin Login</a>
        </div>
    </footer>

    <!-- Privacy Notice -->
    <div class="fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded text-sm">
        Do not sell or share my personal info
    </div>
    <div class="fixed bottom-4 right-4 w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center cursor-pointer">
        <i class="fas fa-question text-white"></i>
    </div>
</body>
</html>


