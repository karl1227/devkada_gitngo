<?php
// Common Functions for Dashboard
require_once __DIR__ . '/../config/config.php';

// Get parent's child data
function getParentChild($parent_id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM children WHERE parent_id = ? LIMIT 1");
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $child = $result->fetch_assoc();
    $stmt->close();
    return $child;
}

// Get teacher data
function getTeacherData($teacher_id) {
    $db = getDB();
    $stmt = $db->prepare("SELECT t.*, u.full_name, u.email FROM teachers t JOIN users u ON t.user_id = u.id WHERE t.id = ?");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();
    $stmt->close();
    return $teacher;
}

// Get upcoming sessions for parent
function getUpcomingSessions($parent_id, $limit = 5) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT s.*, t.id as teacher_id, u.full_name as teacher_name, c.name as child_name
        FROM sessions s
        JOIN teachers t ON s.teacher_id = t.id
        JOIN users u ON t.user_id = u.id
        JOIN children c ON s.child_id = c.id
        WHERE s.parent_id = ? AND s.status IN ('pending', 'confirmed')
        AND (s.session_date > CURDATE() OR (s.session_date = CURDATE() AND s.session_time > CURTIME()))
        ORDER BY s.session_date ASC, s.session_time ASC
        LIMIT ?
    ");
    $stmt->bind_param("ii", $parent_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $sessions = [];
    while ($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }
    $stmt->close();
    return $sessions;
}

// Get progress stats for child
function getChildProgressStats($child_id) {
    $db = getDB();
    
    // Get sessions completed this week
    $stmt = $db->prepare("
        SELECT COUNT(*) as completed, 
               (SELECT COUNT(*) FROM sessions WHERE child_id = ? AND status = 'confirmed') as total
        FROM sessions 
        WHERE child_id = ? AND status = 'completed'
        AND YEARWEEK(session_date) = YEARWEEK(CURDATE())
    ");
    $stmt->bind_param("ii", $child_id, $child_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();
    $stmt->close();
    
    // Get goals achieved
    $stmt = $db->prepare("
        SELECT COUNT(*) as goals_achieved
        FROM progress_reports 
        WHERE child_id = ? AND goals_achieved IS NOT NULL AND goals_achieved != ''
        AND YEARWEEK(report_date) = YEARWEEK(CURDATE())
    ");
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $goals = $result->fetch_assoc();
    $stmt->close();
    
    $stats['goals_achieved'] = $goals['goals_achieved'] ?? 0;
    
    return $stats;
}

// Get AI insights for child
function getAIInsights($child_id, $limit = 3) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT * FROM ai_insights 
        WHERE child_id = ? 
        ORDER BY created_at DESC 
        LIMIT ?
    ");
    $stmt->bind_param("ii", $child_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $insights = [];
    while ($row = $result->fetch_assoc()) {
        $insights[] = $row;
    }
    $stmt->close();
    return $insights;
}

// Get matched teacher for parent
function getMatchedTeacher($parent_id) {
    $db = getDB();
    // Get the first active teacher (in a real system, this would use matching algorithm)
    $stmt = $db->prepare("
        SELECT t.*, u.full_name, u.email
        FROM teachers t
        JOIN users u ON t.user_id = u.id
        WHERE t.verification_status = 'approved' AND u.status = 'active'
        LIMIT 1
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();
    $stmt->close();
    return $teacher;
}

// Get all verified teachers (for find teacher page)
function getVerifiedTeachers($filters = []) {
    $db = getDB();
    
    $sql = "
        SELECT t.*, u.full_name, u.email,
               GROUP_CONCAT(ts.specialization) as specializations
        FROM teachers t
        JOIN users u ON t.user_id = u.id
        LEFT JOIN teacher_specializations ts ON t.id = ts.teacher_id
        WHERE t.verification_status = 'approved' AND u.status = 'active'
    ";
    
    $params = [];
    $types = '';
    
    if (!empty($filters['location'])) {
        $sql .= " AND t.location LIKE ?";
        $params[] = '%' . $filters['location'] . '%';
        $types .= 's';
    }
    
    if (!empty($filters['specialization'])) {
        $sql .= " AND ts.specialization = ?";
        $params[] = $filters['specialization'];
        $types .= 's';
    }
    
    $sql .= " GROUP BY t.id ORDER BY t.rating DESC, t.total_reviews DESC";
    
    $stmt = $db->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $teachers = [];
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
    $stmt->close();
    return $teachers;
}

// Get teacher availability
function getTeacherAvailability($teacher_id, $day = null) {
    $db = getDB();
    
    if ($day) {
        $stmt = $db->prepare("SELECT * FROM teacher_availability WHERE teacher_id = ? AND day_of_week = ? AND is_available = 1");
        $stmt->bind_param("is", $teacher_id, $day);
    } else {
        $stmt = $db->prepare("SELECT * FROM teacher_availability WHERE teacher_id = ? AND is_available = 1");
        $stmt->bind_param("i", $teacher_id);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $availability = [];
    while ($row = $result->fetch_assoc()) {
        $availability[] = $row;
    }
    $stmt->close();
    return $availability;
}

// Book a session
function bookSession($parent_id, $teacher_id, $child_id, $session_date, $session_time, $duration_minutes, $amount) {
    $db = getDB();
    
    // Check if time slot is available
    $day_of_week = strtolower(date('l', strtotime($session_date)));
    $stmt = $db->prepare("
        SELECT * FROM teacher_availability 
        WHERE teacher_id = ? AND day_of_week = ? AND is_available = 1
        AND start_time <= ? AND end_time >= ?
    ");
    $end_time = date('H:i:s', strtotime($session_time . " +{$duration_minutes} minutes"));
    $stmt->bind_param("isss", $teacher_id, $day_of_week, $session_time, $end_time);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt->close();
        return ['success' => false, 'message' => 'Selected time slot is not available'];
    }
    $stmt->close();
    
    // Check for conflicts
    $stmt = $db->prepare("
        SELECT * FROM sessions 
        WHERE teacher_id = ? AND session_date = ? 
        AND status IN ('pending', 'confirmed')
        AND (
            (session_time <= ? AND ADDTIME(session_time, SEC_TO_TIME(duration_minutes * 60)) > ?)
            OR (session_time < ? AND ADDTIME(session_time, SEC_TO_TIME(duration_minutes * 60)) >= ?)
        )
    ");
    $stmt->bind_param("isssss", $teacher_id, $session_date, $session_time, $session_time, $end_time, $end_time);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt->close();
        return ['success' => false, 'message' => 'Time slot is already booked'];
    }
    $stmt->close();
    
    // Create session
    $stmt = $db->prepare("
        INSERT INTO sessions (parent_id, teacher_id, child_id, session_date, session_time, duration_minutes, amount, status, payment_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', 'pending')
    ");
    $stmt->bind_param("iiissid", $parent_id, $teacher_id, $child_id, $session_date, $session_time, $duration_minutes, $amount);
    
    if ($stmt->execute()) {
        $session_id = $db->insert_id;
        $stmt->close();
        
        logActivity('session_booked', "Session booked: Session ID {$session_id}", $parent_id);
        
        // Create notification for teacher
        $teacher = getTeacherData($teacher_id);
        if ($teacher) {
            $teacher_user_id = $db->query("SELECT user_id FROM teachers WHERE id = {$teacher_id}")->fetch_assoc()['user_id'];
            createNotification($teacher_user_id, 'session_booking', 'New Session Booking', "A new session has been booked with you.");
        }
        
        return ['success' => true, 'session_id' => $session_id, 'message' => 'Session booked successfully!'];
    } else {
        $stmt->close();
        return ['success' => false, 'message' => 'Failed to book session'];
    }
}

// Get teacher dashboard stats
function getTeacherDashboardStats($teacher_id) {
    $db = getDB();
    
    // Active students count
    $stmt = $db->prepare("
        SELECT COUNT(DISTINCT child_id) as active_students
        FROM sessions 
        WHERE teacher_id = ? AND status IN ('pending', 'confirmed', 'completed')
        AND session_date >= CURDATE()
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();
    $stmt->close();
    
    // Sessions this month
    $stmt = $db->prepare("
        SELECT COUNT(*) as sessions_this_month
        FROM sessions 
        WHERE teacher_id = ? AND status = 'completed'
        AND MONTH(session_date) = MONTH(CURDATE())
        AND YEAR(session_date) = YEAR(CURDATE())
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $month_stats = $result->fetch_assoc();
    $stats['sessions_this_month'] = $month_stats['sessions_this_month'] ?? 0;
    $stmt->close();
    
    // Average rating
    $stmt = $db->prepare("SELECT rating, total_reviews FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rating_data = $result->fetch_assoc();
    $stats['rating'] = $rating_data['rating'] ?? 0.00;
    $stats['total_reviews'] = $rating_data['total_reviews'] ?? 0;
    $stmt->close();
    
    // Earnings this month
    $stmt = $db->prepare("
        SELECT COALESCE(SUM(amount), 0) as earnings
        FROM sessions 
        WHERE teacher_id = ? AND payment_status = 'paid'
        AND MONTH(session_date) = MONTH(CURDATE())
        AND YEAR(session_date) = YEAR(CURDATE())
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $earnings = $result->fetch_assoc();
    $stats['earnings'] = $earnings['earnings'] ?? 0.00;
    $stmt->close();
    
    return $stats;
}

// Get teacher's upcoming sessions
function getTeacherUpcomingSessions($teacher_id, $limit = 5) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT s.*, u.full_name as parent_name, c.name as child_name
        FROM sessions s
        JOIN users u ON s.parent_id = u.id
        JOIN children c ON s.child_id = c.id
        WHERE s.teacher_id = ? AND s.status IN ('pending', 'confirmed')
        AND (s.session_date > CURDATE() OR (s.session_date = CURDATE() AND s.session_time > CURTIME()))
        ORDER BY s.session_date ASC, s.session_time ASC
        LIMIT ?
    ");
    $stmt->bind_param("ii", $teacher_id, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $sessions = [];
    while ($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }
    $stmt->close();
    return $sessions;
}

// Get teacher's students
function getTeacherStudents($teacher_id) {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT DISTINCT c.*, u.full_name as parent_name, u.email as parent_email
        FROM children c
        JOIN sessions s ON c.id = s.child_id
        JOIN users u ON c.parent_id = u.id
        WHERE s.teacher_id = ? AND s.status IN ('pending', 'confirmed', 'completed')
        ORDER BY c.name ASC
    ");
    $stmt->bind_param("i", $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();
    return $students;
}

