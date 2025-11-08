<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - LEARNSAFE.AI</title>
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
<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen py-12 px-4">
    <!-- Header -->
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <div class="w-10 h-10 gradient-heart rounded-lg flex items-center justify-center">
                    <i class="fas fa-heart text-white"></i>
                </div>
                <span class="text-3xl font-bold text-blue-600">LEARNSAFE.AI</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Choose Your Role</h1>
            <p class="text-gray-600">Select how you'd like to join our community.</p>
        </div>

        <!-- Role Selection Cards -->
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Teacher Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition">
                <div class="w-16 h-16 gradient-teacher rounded-xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">I'm a Teacher</h2>
                <p class="text-gray-600 text-center mb-8">
                    Share your expertise and help neurodiverse learners reach their full potential
                </p>
                <button onclick="showTeacherForm()" class="w-full gradient-teacher text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                    Sign Up as Teacher
                </button>
            </div>

            <!-- Parent Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition">
                <div class="w-16 h-16 gradient-parent rounded-xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">I'm a Parent</h2>
                <p class="text-gray-600 text-center mb-8">
                    Find verified SPED teachers and personalized learning for your child
                </p>
                <button onclick="showParentForm()" class="w-full gradient-parent text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                    Sign Up as Parent
                </button>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="index.php" class="text-gray-600 hover:text-blue-600">— Back to Home</a>
        </div>
    </div>

    <!-- Parent Sign Up Form Modal -->
    <div id="parentForm" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 gradient-heart rounded-lg flex items-center justify-center">
                            <i class="fas fa-heart text-white text-sm"></i>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">LEARNSAFE.AI</span>
                    </div>
                    <button onclick="closeForms()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Parent Sign Up</h2>
                <p class="text-gray-600 mb-8">Create your account to find the perfect teacher for your child.</p>

                <form id="parentSignupForm" class="space-y-6">
                    <div id="parentError" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"></div>
                    <div id="parentSuccess" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"></div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="parent_full_name" name="full_name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="Enter your full name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="parent_email" name="email" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="parent@example.com">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" id="parent_password" name="password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" id="parent_confirm_password" name="confirm_password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Child's Name</label>
                        <input type="text" id="child_name" name="child_name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="Enter your child's name">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Child's Age</label>
                        <input type="number" id="child_age" name="child_age" required min="1" max="18" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="Age">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" required class="mr-2">
                        <span class="text-sm text-gray-600">I agree to the Terms & Conditions</span>
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" onclick="closeForms()" class="flex-1 px-6 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Back
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Teacher Sign Up Form Modal -->
    <div id="teacherForm" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 gradient-heart rounded-lg flex items-center justify-center">
                            <i class="fas fa-heart text-white text-sm"></i>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">LEARNSAFE.AI</span>
                    </div>
                    <button onclick="closeForms()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Teacher Sign Up</h2>
                <p class="text-gray-600 mb-8">Join our community of verified SPED educators.</p>

                <form id="teacherSignupForm" class="space-y-6" enctype="multipart/form-data">
                    <div id="teacherError" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"></div>
                    <div id="teacherSuccess" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"></div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="teacher_full_name" name="full_name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="Enter your full name">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="teacher_email" name="email" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="teacher@example.com">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <input type="password" id="teacher_password" name="password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" id="teacher_confirm_password" name="confirm_password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Specialization (Select all that apply)</label>
                        <div class="grid grid-cols-2 gap-3 p-4 border-2 border-gray-200 rounded-lg">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="specializations[]" value="Autism" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700">Autism</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="specializations[]" value="Speech Therapy" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700">Speech Therapy</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="specializations[]" value="Behavioral Support" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700">Behavioral Support</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="specializations[]" value="Math & Logic" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700">Math & Logic</span>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="specializations[]" value="Visual Learning" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700">Visual Learning</span>
                            </label>
                        </div>
                        <p id="specializationError" class="hidden text-red-600 text-sm mt-2">Please select at least one specialization</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                        <input type="text" id="location" name="location" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none" placeholder="City, State">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teaching License (Required)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer" onclick="document.getElementById('licenseUpload').click()">
                            <i class="fas fa-upload text-3xl text-gray-400 mb-4"></i>
                            <p id="licenseFileName" class="text-gray-600 font-semibold mb-2">Click to upload your teaching license</p>
                            <p class="text-sm text-gray-500">PDF, JPG, or PNG (max 10MB)</p>
                            <input type="file" accept=".pdf,.jpg,.jpeg,.png" class="hidden" id="licenseUpload" name="license_file">
                        </div>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <p class="text-sm text-blue-700">
                                Your account will be reviewed once your license is uploaded. This typically takes 1-2 business days.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" required class="mr-2">
                        <span class="text-sm text-gray-600">I agree to the Terms & Conditions and understand that my credentials will be verified before approval</span>
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" onclick="closeForms()" class="flex-1 px-6 py-3 border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Back
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition">
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Privacy Notice -->
    <div class="fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded text-sm">
        Do not sell or share my personal info
    </div>
    <div class="fixed bottom-4 right-4 w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center cursor-pointer">
        <i class="fas fa-question text-white"></i>
    </div>

    <script>
        function showParentForm() {
            document.getElementById('parentForm').classList.remove('hidden');
        }

        function showTeacherForm() {
            document.getElementById('teacherForm').classList.remove('hidden');
        }

        function closeForms() {
            document.getElementById('parentForm').classList.add('hidden');
            document.getElementById('teacherForm').classList.add('hidden');
        }

        // File upload handler
        document.getElementById('licenseUpload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                document.getElementById('licenseFileName').textContent = `Selected: ${fileName}`;
            }
        });

        document.getElementById('parentSignupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const errorDiv = document.getElementById('parentError');
            const successDiv = document.getElementById('parentSuccess');
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            
            const formData = {
                type: 'parent',
                full_name: document.getElementById('parent_full_name').value,
                email: document.getElementById('parent_email').value,
                password: document.getElementById('parent_password').value,
                confirm_password: document.getElementById('parent_confirm_password').value,
                child_name: document.getElementById('child_name').value,
                child_age: parseInt(document.getElementById('child_age').value)
            };
            
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Creating Account...';
            
            fetch('api/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    successDiv.textContent = data.message || 'Account created successfully! Redirecting...';
                    successDiv.classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = 'parent/dashboard.php';
                    }, 2000);
                } else {
                    errorDiv.textContent = data.message || 'Registration failed. Please try again.';
                    errorDiv.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Create Account';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = 'An error occurred. Please try again. Error: ' + error.message;
                errorDiv.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Create Account';
            });
        });

        document.getElementById('teacherSignupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const errorDiv = document.getElementById('teacherError');
            const successDiv = document.getElementById('teacherSuccess');
            const specError = document.getElementById('specializationError');
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            specError.classList.add('hidden');
            
            // Get selected specializations
            const specializations = Array.from(document.querySelectorAll('input[name="specializations[]"]:checked')).map(cb => cb.value);
            
            if (specializations.length === 0) {
                specError.classList.remove('hidden');
                return;
            }
            
            const formData = new FormData();
            formData.append('type', 'teacher');
            formData.append('full_name', document.getElementById('teacher_full_name').value);
            formData.append('email', document.getElementById('teacher_email').value);
            formData.append('password', document.getElementById('teacher_password').value);
            formData.append('confirm_password', document.getElementById('teacher_confirm_password').value);
            formData.append('location', document.getElementById('location').value);
            
            // Append each specialization
            specializations.forEach(spec => {
                formData.append('specializations[]', spec);
            });
            
            const licenseFile = document.getElementById('licenseUpload').files[0];
            if (licenseFile) {
                formData.append('license_file', licenseFile);
            }
            
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting Application...';
            
            fetch('api/register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    successDiv.textContent = data.message || 'Application submitted successfully!';
                    successDiv.classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 3000);
                } else {
                    errorDiv.textContent = data.message || 'Registration failed. Please try again.';
                    errorDiv.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Submit Application';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = 'An error occurred. Please try again. Error: ' + error.message;
                errorDiv.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Application';
            });
        });
    </script>
</body>
</html>


