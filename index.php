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
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce {
            animation: bounce 1s infinite;
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
            <!-- Right Image Carousel -->
            <div class="hidden md:block">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="relative bg-gradient-to-br from-blue-100 to-green-100 rounded-xl h-96 overflow-hidden">
                        <!-- Carousel Container -->
                        <div id="heroCarousel" class="relative h-full">
                            <div class="flex transition-transform duration-500 ease-in-out h-full" id="heroCarouselTrack">
                                <!-- Slide 1: Homepage Image -->
                                <div class="min-w-full flex-shrink-0 h-full">
                                    <img src="uploads/img/homepage.jpg" alt="LearnSafe.AI Homepage" class="w-full h-full object-cover rounded-xl">
                                </div>
                                <!-- Slide 2: Homepage1 Image -->
                                <div class="min-w-full flex-shrink-0 h-full">
                                    <img src="uploads/img/homepage1.jpeg" alt="LearnSafe.AI" class="w-full h-full object-cover rounded-xl">
                                </div>
                                <!-- Slide 3: Homepage2 Image -->
                                <div class="min-w-full flex-shrink-0 h-full">
                                    <img src="uploads/img/homepage2.jpg" alt="LearnSafe.AI" class="w-full h-full object-cover rounded-xl">
                                </div>
                            </div>
                            
                            <!-- Navigation Buttons -->
                            <button id="heroPrevBtn" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 shadow-lg hover:bg-opacity-100 transition z-10">
                                <i class="fas fa-chevron-left text-gray-700"></i>
                            </button>
                            <button id="heroNextBtn" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-80 rounded-full p-2 shadow-lg hover:bg-opacity-100 transition z-10">
                                <i class="fas fa-chevron-right text-gray-700"></i>
                            </button>
                            
                            <!-- Carousel Indicators -->
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2" id="heroCarouselIndicators">
                                <button class="w-2 h-2 rounded-full bg-blue-500 transition" data-slide="0"></button>
                                <button class="w-2 h-2 rounded-full bg-white bg-opacity-50 transition" data-slide="1"></button>
                                <button class="w-2 h-2 rounded-full bg-white bg-opacity-50 transition" data-slide="2"></button>
                            </div>
                        </div>
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
        </div>
    </footer>

    <!-- Privacy Notice -->
    <div class="fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded text-sm">
        Do not sell or share my personal info
    </div>

    <!-- Voice and Chat Agent Widget -->
    <div id="chatWidget" class="fixed bottom-6 right-6 z-50">
        <!-- Chat Button -->
        <button id="chatToggleBtn" class="w-16 h-16 bg-blue-500 rounded-full shadow-lg hover:bg-blue-600 transition flex items-center justify-center text-white">
            <i id="chatIcon" class="fas fa-comments text-2xl"></i>
            <i id="closeIcon" class="fas fa-times text-2xl hidden"></i>
        </button>

        <!-- Chat Window -->
        <div id="chatWindow" class="hidden absolute bottom-20 right-0 w-96 h-[600px] bg-white rounded-2xl shadow-2xl flex flex-col border border-gray-200">
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-blue-500 to-green-500 text-white p-4 rounded-t-2xl flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div>
                        <h3 class="font-bold">LearnSafe AI Assistant</h3>
                        <p class="text-xs opacity-90">Here to help you get started</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="ttsToggleBtn" class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition" title="Toggle Text-to-Speech">
                        <i id="ttsIcon" class="fas fa-volume-up"></i>
                    </button>
                    <button id="voiceToggleBtn" class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition" title="Voice Input">
                        <i id="voiceIcon" class="fas fa-microphone"></i>
                    </button>
                </div>
            </div>

            <!-- Chat Messages -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
                <!-- Welcome Message -->
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-robot text-white text-sm"></i>
                    </div>
                    <div class="bg-white rounded-lg p-3 shadow-sm max-w-[80%]">
                        <p class="text-sm text-gray-800">Hello! I'm your LearnSafe AI Assistant. I'm here to help you with:</p>
                        <ul class="text-sm text-gray-700 mt-2 space-y-1 list-disc list-inside">
                            <li>Getting started with LearnSafe.AI</li>
                            <li>Finding the right teacher for your child</li>
                            <li>Understanding our platform features</li>
                            <li>Answering your questions</li>
                        </ul>
                        <p class="text-sm text-gray-800 mt-2">How can I help you today? 😊</p>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="p-4 border-t border-gray-200 bg-white rounded-b-2xl">
                <div class="flex items-center space-x-2">
                    <input type="text" id="chatInput" placeholder="Type your message..." 
                           class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                           onkeypress="if(event.key === 'Enter') sendMessage()">
                    <button id="sendBtn" onclick="sendMessage()" 
                            class="w-10 h-10 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition flex items-center justify-center">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <p id="voiceStatus" class="text-xs text-gray-500 mt-2 hidden">
                    <i class="fas fa-microphone text-red-500"></i> Listening...
                </p>
            </div>
        </div>
    </div>

    <!-- Hero Carousel Script -->
    <script>
        let heroCurrentSlide = 0;
        const heroTotalSlides = 3; // homepage.jpg, homepage1.jpeg, homepage2.jpg
        const heroCarouselTrack = document.getElementById('heroCarouselTrack');
        const heroIndicators = document.querySelectorAll('#heroCarouselIndicators button');
        const heroPrevBtn = document.getElementById('heroPrevBtn');
        const heroNextBtn = document.getElementById('heroNextBtn');

        function updateHeroCarousel() {
            heroCarouselTrack.style.transform = `translateX(-${heroCurrentSlide * 100}%)`;
            
            // Update indicators
            heroIndicators.forEach((indicator, index) => {
                if (index === heroCurrentSlide) {
                    indicator.classList.remove('bg-white', 'bg-opacity-50');
                    indicator.classList.add('bg-blue-500');
                } else {
                    indicator.classList.remove('bg-blue-500');
                    indicator.classList.add('bg-white', 'bg-opacity-50');
                }
            });
        }

        function heroNextSlide() {
            heroCurrentSlide = (heroCurrentSlide + 1) % heroTotalSlides;
            updateHeroCarousel();
        }

        function heroPrevSlide() {
            heroCurrentSlide = (heroCurrentSlide - 1 + heroTotalSlides) % heroTotalSlides;
            updateHeroCarousel();
        }

        // Button event listeners
        heroNextBtn.addEventListener('click', heroNextSlide);
        heroPrevBtn.addEventListener('click', heroPrevSlide);

        // Indicator event listeners
        heroIndicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                heroCurrentSlide = index;
                updateHeroCarousel();
            });
        });

        // Auto-play carousel (optional - uncomment to enable)
        // setInterval(heroNextSlide, 4000);
    </script>

    <!-- Voice and Chat Agent Script -->
    <script>
        // Chat Widget State
        let isChatOpen = false;
        let isListening = false;
        let isTTSEnabled = true; // Text-to-speech enabled by default
        let recognition = null;
        let synth = window.speechSynthesis;

        // DOM Elements
        const chatToggleBtn = document.getElementById('chatToggleBtn');
        const chatWindow = document.getElementById('chatWindow');
        const chatIcon = document.getElementById('chatIcon');
        const closeIcon = document.getElementById('closeIcon');
        const chatMessages = document.getElementById('chatMessages');
        const chatInput = document.getElementById('chatInput');
        const sendBtn = document.getElementById('sendBtn');
        const voiceToggleBtn = document.getElementById('voiceToggleBtn');
        const voiceIcon = document.getElementById('voiceIcon');
        const voiceStatus = document.getElementById('voiceStatus');
        const ttsToggleBtn = document.getElementById('ttsToggleBtn');
        const ttsIcon = document.getElementById('ttsIcon');

        // Toggle Chat Window
        chatToggleBtn.addEventListener('click', () => {
            isChatOpen = !isChatOpen;
            if (isChatOpen) {
                chatWindow.classList.remove('hidden');
                chatIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                chatWindow.classList.add('hidden');
                chatIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                if (isListening) {
                    stopListening();
                }
            }
        });

        // Initialize Speech Recognition (if available)
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                chatInput.value = transcript;
                sendMessage();
            };

            recognition.onerror = (event) => {
                console.error('Speech recognition error:', event.error);
                stopListening();
            };

            recognition.onend = () => {
                if (isListening) {
                    stopListening();
                }
            };
        }

        // TTS Toggle
        ttsToggleBtn.addEventListener('click', () => {
            isTTSEnabled = !isTTSEnabled;
            if (isTTSEnabled) {
                ttsIcon.classList.remove('fa-volume-mute');
                ttsIcon.classList.add('fa-volume-up');
                ttsToggleBtn.classList.remove('bg-red-500', 'bg-opacity-50');
                ttsToggleBtn.classList.add('bg-white', 'bg-opacity-20');
            } else {
                ttsIcon.classList.remove('fa-volume-up');
                ttsIcon.classList.add('fa-volume-mute');
                ttsToggleBtn.classList.remove('bg-white', 'bg-opacity-20');
                ttsToggleBtn.classList.add('bg-red-500', 'bg-opacity-50');
                // Stop any ongoing speech
                if (synth && synth.speaking) {
                    synth.cancel();
                }
            }
        });

        // Voice Toggle
        voiceToggleBtn.addEventListener('click', () => {
            if (isListening) {
                stopListening();
            } else {
                startListening();
            }
        });

        function startListening() {
            if (recognition) {
                isListening = true;
                recognition.start();
                voiceIcon.classList.remove('fa-microphone');
                voiceIcon.classList.add('fa-microphone-slash');
                voiceStatus.classList.remove('hidden');
                voiceToggleBtn.classList.add('bg-red-500');
            } else {
                alert('Speech recognition is not supported in your browser. Please use Chrome or Edge.');
            }
        }

        function stopListening() {
            if (recognition && isListening) {
                recognition.stop();
                isListening = false;
                voiceIcon.classList.remove('fa-microphone-slash');
                voiceIcon.classList.add('fa-microphone');
                voiceStatus.classList.add('hidden');
                voiceToggleBtn.classList.remove('bg-red-500');
            }
        }

        // Send Message
        function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;

            // Add user message to chat
            addMessage(message, 'user');
            chatInput.value = '';

            // Show typing indicator
            const typingIndicator = addTypingIndicator();

            // Call AI API
            fetch('api/chat.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => response.json())
            .then(data => {
                // Remove typing indicator
                typingIndicator.remove();
                
                if (data.success) {
                    addMessage(data.message, 'bot');
                    
                    // Speak response if TTS is enabled
                    if (isTTSEnabled && data.speak) {
                        speakText(data.message);
                    }
                } else {
                    addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                }
            })
            .catch(error => {
                // Remove typing indicator
                typingIndicator.remove();
                
                // Fallback to rule-based response
                const response = getAIResponse(message);
                addMessage(response.text, 'bot');
                
                if (isTTSEnabled && response.speak) {
                    speakText(response.text);
                }
            });
        }

        // Add typing indicator
        function addTypingIndicator() {
            const typingDiv = document.createElement('div');
            typingDiv.className = 'flex items-start space-x-2';
            typingDiv.id = 'typing-indicator';
            
            const avatar = document.createElement('div');
            avatar.className = 'w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0';
            avatar.innerHTML = '<i class="fas fa-robot text-white text-sm"></i>';
            
            const messageContent = document.createElement('div');
            messageContent.className = 'bg-white rounded-lg p-3 shadow-sm';
            messageContent.innerHTML = '<div class="flex space-x-1"><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div></div>';
            
            typingDiv.appendChild(avatar);
            typingDiv.appendChild(messageContent);
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            return typingDiv;
        }

        // Add Message to Chat
        function addMessage(text, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex items-start space-x-2 ${sender === 'user' ? 'flex-row-reverse space-x-reverse' : ''}`;
            
            const avatar = document.createElement('div');
            avatar.className = `w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${
                sender === 'user' ? 'bg-green-500' : 'bg-blue-500'
            }`;
            avatar.innerHTML = sender === 'user' 
                ? '<i class="fas fa-user text-white text-sm"></i>'
                : '<i class="fas fa-robot text-white text-sm"></i>';
            
            const messageContent = document.createElement('div');
            messageContent.className = `rounded-lg p-3 shadow-sm max-w-[80%] ${
                sender === 'user' ? 'bg-green-500 text-white' : 'bg-white text-gray-800'
            }`;
            messageContent.innerHTML = `<p class="text-sm">${text}</p>`;
            
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(messageContent);
            chatMessages.appendChild(messageDiv);
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // AI Response Logic
        function getAIResponse(userMessage) {
            const message = userMessage.toLowerCase();
            
            // Greeting responses
            if (message.includes('hello') || message.includes('hi') || message.includes('hey')) {
                return {
                    text: "Hello! Welcome to LearnSafe.AI! I'm here to help you get started. Would you like to know more about how our platform works, or do you have specific questions about finding a teacher for your child?",
                    speak: true
                };
            }
            
            // Getting started
            if (message.includes('start') || message.includes('begin') || message.includes('how do i')) {
                return {
                    text: "Great! To get started:\n\n1. Click 'Get Started' or 'Sign Up' to create your account\n2. Choose whether you're a Parent or Teacher\n3. Fill in your information and your child's profile (if you're a parent)\n4. Our AI will match you with verified SPED teachers\n5. Browse teachers and book sessions\n\nWould you like me to explain any of these steps in more detail?",
                    speak: true
                };
            }
            
            // Teacher questions
            if (message.includes('teacher') || message.includes('tutor') || message.includes('find')) {
                return {
                    text: "We have verified SPED teachers ready to help! Here's how to find one:\n\n1. Sign up as a Parent\n2. Complete your child's profile with their learning needs\n3. Our AI matching system will suggest compatible teachers\n4. Browse teacher profiles, specializations, and reviews\n5. Book a session with your preferred teacher\n\nAll our teachers are background-checked and SPED-certified. Would you like to know more about our verification process?",
                    speak: true
                };
            }
            
            // Pricing questions
            if (message.includes('price') || message.includes('cost') || message.includes('fee') || message.includes('pay')) {
                return {
                    text: "Pricing varies by teacher, typically ranging from $35-$55 per hour. Each teacher sets their own rates based on experience and specialization. You can see the hourly rate on each teacher's profile before booking. Payment is secure and processed through our platform. Would you like to see available teachers and their rates?",
                    speak: true
                };
            }
            
            // Safety/verification questions
            if (message.includes('safe') || message.includes('verify') || message.includes('background') || message.includes('check')) {
                return {
                    text: "Safety is our top priority! All teachers go through:\n\n✓ Background checks\n✓ License verification\n✓ SPED certification verification\n✓ Identity verification\n✓ Admin approval process\n\nWe ensure every teacher on our platform is qualified and safe to work with children. Would you like to know more about our safety measures?",
                    speak: true
                };
            }
            
            // Features questions
            if (message.includes('feature') || message.includes('what can') || message.includes('offer')) {
                return {
                    text: "LearnSafe.AI offers:\n\n✨ AI-powered teacher matching\n📊 Progress tracking and insights\n📅 Easy session scheduling\n💬 Direct communication with teachers\n📈 Detailed learning reports\n🤖 AI insights for personalized learning\n\nWould you like details on any specific feature?",
                    speak: true
                };
            }
            
            // Help/Support
            if (message.includes('help') || message.includes('support') || message.includes('problem')) {
                return {
                    text: "I'm here to help! You can:\n\n1. Ask me questions about the platform\n2. Contact our support team through your dashboard\n3. Check our FAQ section\n4. Email us at support@learnsafe.ai\n\nWhat specific help do you need?",
                    speak: true
                };
            }
            
            // Default response
            return {
                text: "I understand you're asking about: \"" + userMessage + "\". Let me help you with that! You can ask me about:\n\n• Getting started\n• Finding teachers\n• Pricing\n• Safety and verification\n• Platform features\n• How to sign up\n\nWhat would you like to know more about?",
                speak: true
            };
        }

        // Text to Speech
        function speakText(text) {
            if (synth) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.rate = 0.9;
                utterance.pitch = 1;
                utterance.volume = 0.8;
                synth.speak(utterance);
            }
        }

        // Enter key to send message
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    </script>
</body>
</html>


