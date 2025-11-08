<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check authentication
requireRole('parent');

$user_id = getCurrentUserId();
$user = getUserData($user_id);
$child = getParentChild($user_id);

// Get teacher ID from query
$teacher_id = intval($_GET['teacher_id'] ?? 0);

if (empty($teacher_id)) {
    header('Location: find-teacher.php');
    exit;
}

// Get teacher data
$teacher = getTeacherData($teacher_id);

if (!$teacher) {
    header('Location: find-teacher.php');
    exit;
}

// Get teacher specializations
$db = getDB();
$stmt = $db->prepare("SELECT specialization FROM teacher_specializations WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
$specializations = [];
while ($row = $result->fetch_assoc()) {
    $specializations[] = $row['specialization'];
}
$stmt->close();

// Get child's name or default
$child_name = $child ? $child['name'] : 'Your Child';

// Default values
$selected_date = date('Y-m-d', strtotime('+1 day'));
$selected_time = '';
$duration = 60; // 1 hour
$hourly_rate = floatval($teacher['hourly_rate'] ?? 45);
$total_amount = $hourly_rate;
?>
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
                <p class="text-gray-800 font-semibold">Welcome Back, <?php echo htmlspecialchars($user['full_name']); ?>! Let's make today great for <?php echo htmlspecialchars($child_name); ?></p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="../api/logout.php" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-sign-out-alt text-xl cursor-pointer" title="Logout"></i>
                </a>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 font-bold"><?php echo strtoupper(substr($user['full_name'], 0, 2)); ?></span>
                </div>
                <span class="text-gray-800 font-semibold"><?php echo htmlspecialchars(explode(' ', $user['full_name'])[0]); ?></span>
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
                <a href="support.php" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm font-semibold text-center">
                    Contact our support
                </a>
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
                                    <h3 class="text-xl font-bold text-gray-800"><?php echo htmlspecialchars($teacher['full_name']); ?></h3>
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <p class="text-yellow-500">★ <?php echo number_format($teacher['rating'] ?? 4.5, 1); ?> (<?php echo $teacher['total_reviews'] ?? 0; ?>)</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="font-semibold">Specialization:</span> 
                                    <?php echo htmlspecialchars(implode(', ', $specializations)); ?>
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Experience:</span> 
                                    <?php echo $teacher['years_experience'] ?? 'N/A'; ?> years
                                </p>
                                <p class="text-lg font-bold text-blue-600 mt-2">
                                    Hourly Rate: $<?php echo number_format($hourly_rate, 2); ?>/hr
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Summary Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Booking Summary</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Child:</span>
                                <span class="font-semibold text-gray-800"><?php echo htmlspecialchars($child_name); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-semibold text-gray-800" id="summaryDate">Select a date</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Time:</span>
                                <span class="font-semibold text-gray-800" id="summaryTime">Select a time</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-semibold text-gray-800"><?php echo $duration; ?> minutes</span>
                            </div>
                            <div class="border-t pt-3 mt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-800">Total:</span>
                                    <span class="text-xl font-bold text-blue-600" id="summaryTotal">$<?php echo number_format($total_amount, 2); ?></span>
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
                        
                        <!-- Date Picker -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Select Date</label>
                            <input type="date" id="sessionDate" name="session_date" 
                                   min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" 
                                   value="<?php echo $selected_date; ?>"
                                   class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none"
                                   onchange="loadAvailableSlots()">
                        </div>

                        <!-- Available Time Slots -->
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-3">Available Time Slots</h3>
                            <div id="timeSlots" class="grid grid-cols-3 gap-2">
                                <p class="text-gray-500 text-sm">Select a date to see available slots</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Payment Method</h2>
                        <p class="text-gray-600 mb-6">Payment will be processed securely through our platform.</p>
                        <div class="space-y-3 mb-6">
                            <button onclick="selectPaymentMethod('paypal')" id="paypalBtn" class="w-full px-6 py-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition flex items-center justify-center space-x-3">
                                <i class="fab fa-paypal text-2xl text-blue-600"></i>
                                <span class="font-semibold text-gray-800">PayPal</span>
                            </button>
                            <button onclick="selectPaymentMethod('gcash')" id="gcashBtn" class="w-full px-6 py-4 border-2 border-gray-200 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition flex items-center justify-center space-x-3">
                                <i class="fas fa-mobile-alt text-2xl text-orange-600"></i>
                                <span class="font-semibold text-gray-800">GCash</span>
                            </button>
                        </div>
                        <button onclick="confirmBooking()" class="w-full px-6 py-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-semibold text-lg">
                            Confirm Booking
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const teacherId = <?php echo $teacher_id; ?>;
        const childId = <?php echo $child ? $child['id'] : 0; ?>;
        const hourlyRate = <?php echo $hourly_rate; ?>;
        const duration = <?php echo $duration; ?>;
        let selectedDate = '';
        let selectedTime = '';
        let selectedPaymentMethod = '';

        function selectPaymentMethod(method) {
            selectedPaymentMethod = method;
            document.getElementById('paypalBtn').classList.remove('border-blue-500', 'bg-blue-50');
            document.getElementById('paypalBtn').classList.add('border-gray-200');
            document.getElementById('gcashBtn').classList.remove('border-orange-500', 'bg-orange-50');
            document.getElementById('gcashBtn').classList.add('border-gray-200');
            
            if (method === 'paypal') {
                document.getElementById('paypalBtn').classList.add('border-blue-500', 'bg-blue-50');
            } else {
                document.getElementById('gcashBtn').classList.add('border-orange-500', 'bg-orange-50');
            }
        }

        function loadAvailableSlots() {
            const date = document.getElementById('sessionDate').value;
            if (!date) return;

            selectedDate = date;
            document.getElementById('summaryDate').textContent = new Date(date).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            fetch(`../api/get_available_slots.php?teacher_id=${teacherId}&date=${date}`)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const slotsDiv = document.getElementById('timeSlots');
                        if (data.slots.length === 0) {
                            slotsDiv.innerHTML = '<p class="text-gray-500 text-sm col-span-3">No available slots for this date</p>';
                            return;
                        }
                        slotsDiv.innerHTML = data.slots.map(slot => `
                            <button onclick="selectTimeSlot('${slot.time_24}', '${slot.display}')" 
                                    class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold time-slot-btn">
                                ${slot.display}
                            </button>
                        `).join('');
                    }
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('timeSlots').innerHTML = '<p class="text-red-500 text-sm col-span-3">Error loading slots</p>';
                });
        }

        function selectTimeSlot(time, display) {
            selectedTime = time;
            document.getElementById('summaryTime').textContent = display;
            
            // Update button styles
            document.querySelectorAll('.time-slot-btn').forEach(btn => {
                btn.classList.remove('border-blue-500', 'bg-blue-50', 'text-blue-600');
                btn.classList.add('border-gray-200');
            });
            event.target.classList.add('border-blue-500', 'bg-blue-50', 'text-blue-600');
            event.target.classList.remove('border-gray-200');
        }

        function confirmBooking() {
            if (!selectedDate || !selectedTime) {
                alert('Please select a date and time');
                return;
            }

            if (!selectedPaymentMethod) {
                alert('Please select a payment method');
                return;
            }

            if (!childId) {
                alert('Please add a child profile first');
                window.location.href = 'child-profile.php';
                return;
            }

            if (!confirm('Confirm booking for ' + document.getElementById('summaryDate').textContent + ' at ' + document.getElementById('summaryTime').textContent + '?')) {
                return;
            }

            fetch('../api/book_session.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    teacher_id: teacherId,
                    child_id: childId,
                    session_date: selectedDate,
                    session_time: selectedTime,
                    duration_minutes: duration,
                    amount: hourlyRate,
                    payment_method: selectedPaymentMethod
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Session booked successfully!');
                    window.location.href = 'schedule.php';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred. Please try again.');
            });
        }

        // Load slots on page load
        window.onload = function() {
            loadAvailableSlots();
        };
    </script>
</body>
</html>
