-- LearnSafe.AI Seed Data
-- This file contains sample data for testing and development
-- Password for all users: password123

USE devkada_gitngo;

-- Clear existing data (optional - uncomment if you want to reset)
-- SET FOREIGN_KEY_CHECKS = 0;
-- TRUNCATE TABLE teacher_specializations;
-- TRUNCATE TABLE teacher_availability;
-- TRUNCATE TABLE sessions;
-- TRUNCATE TABLE progress_reports;
-- TRUNCATE TABLE ai_insights;
-- TRUNCATE TABLE children;
-- TRUNCATE TABLE teachers;
-- TRUNCATE TABLE users;
-- SET FOREIGN_KEY_CHECKS = 1;

-- Insert Users (Parents, Teachers, Admin)
-- Password hash for "password123" - Using provided hash
-- Using INSERT IGNORE to avoid duplicate key errors if data already exists
INSERT IGNORE INTO users (email, password, full_name, role, status, created_at) VALUES
-- Admin
('admin@learnsafe.ai', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Admin User', 'admin', 'active', NOW()),

-- Parents
('sarah.martinez@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Sarah Martinez', 'parent', 'active', NOW()),
('michael.chen@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Michael Chen', 'parent', 'active', NOW()),
('jennifer.williams@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Jennifer Williams', 'parent', 'active', NOW()),
('david.johnson@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'David Johnson', 'parent', 'active', NOW()),
('maria.garcia@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Maria Garcia', 'parent', 'active', NOW()),

-- Teachers
('emily.johnson@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Emily Johnson', 'teacher', 'active', NOW()),
('david.chen@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'David Chen', 'teacher', 'active', NOW()),
('sarah.williams@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Dr. Sarah Williams', 'teacher', 'active', NOW()),
('jennifer.lopez@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Jennifer Lopez', 'teacher', 'active', NOW()),
('robert.smith@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Robert Smith', 'teacher', 'active', NOW()),
('lisa.anderson@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Lisa Anderson', 'teacher', 'active', NOW()),
('james.brown@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'James Brown', 'teacher', 'active', NOW()),
('patricia.davis@email.com', '$2y$10$5dWWs6dulmsBaGhwLrBNAuSo0KCkUhMqb9Uw8rtFTJhz1v2jOwTaW', 'Patricia Davis', 'teacher', 'active', NOW());

-- Insert Children (linked to parents)
-- Using INSERT IGNORE to avoid duplicate key errors
INSERT IGNORE INTO children (parent_id, name, age, learning_style, communication_style, special_needs, created_at) VALUES
-- Sarah Martinez's child
((SELECT id FROM users WHERE email = 'sarah.martinez@email.com'), 'Alex Martinez', 7, 'Visual, Hands-on', 'Verbal & AAC', 'Prefers structured routines, benefits from visual schedules', NOW()),

-- Michael Chen's child
((SELECT id FROM users WHERE email = 'michael.chen@email.com'), 'Emma Chen', 9, 'Auditory', 'Verbal', 'Needs frequent breaks, responds well to music', NOW()),

-- Jennifer Williams's child
((SELECT id FROM users WHERE email = 'jennifer.williams@email.com'), 'Lucas Williams', 6, 'Kinesthetic', 'Non-verbal', 'Uses AAC device, loves sensory activities', NOW()),

-- David Johnson's child
((SELECT id FROM users WHERE email = 'david.johnson@email.com'), 'Sophia Johnson', 8, 'Visual', 'Verbal', 'Sensitive to loud noises, prefers quiet environments', NOW()),

-- Maria Garcia's child
((SELECT id FROM users WHERE email = 'maria.garcia@email.com'), 'Diego Garcia', 10, 'Mixed', 'Verbal & AAC', 'Strong in math, needs support with social skills', NOW());

-- Insert Teachers (linked to users)
-- Using INSERT IGNORE to avoid duplicate key errors
INSERT IGNORE INTO teachers (user_id, specialization, location, experience_years, hourly_rate, bio, license_number, verification_status, verified_at, rating, total_reviews, created_at) VALUES
-- Emily Johnson
((SELECT id FROM users WHERE email = 'emily.johnson@email.com'), 'Speech Therapy', 'San Francisco, CA', 8, 45.00, 
 'Specialized in autism support with a focus on communication and social skills development. Passionate about helping children find their voice.', 
 'LIC-2024-001', 'approved', NOW(), 4.9, 127, NOW()),

-- David Chen
((SELECT id FROM users WHERE email = 'david.chen@email.com'), 'Math & Logic', 'Los Angeles, CA', 6, 40.00,
 'Passionate about making learning accessible through visual and hands-on methods. Experienced in working with neurodiverse learners.',
 'LIC-2024-002', 'approved', NOW(), 4.8, 93, NOW()),

-- Dr. Sarah Williams
((SELECT id FROM users WHERE email = 'sarah.williams@email.com'), 'Sensory Integration', 'San Diego, CA', 12, 55.00,
 'Board-certified specialist in autism education with extensive sensory integration training. Dedicated to creating inclusive learning environments.',
 'LIC-2024-003', 'approved', NOW(), 5.0, 145, NOW()),

-- Jennifer Lopez
((SELECT id FROM users WHERE email = 'jennifer.lopez@email.com'), 'Social Skills', 'Sacramento, CA', 7, 42.00,
 'Creating safe, supportive environments for children to thrive academically and socially. Specialized in behavioral support.',
 'LIC-2024-004', 'approved', NOW(), 4.9, 108, NOW()),

-- Robert Smith
((SELECT id FROM users WHERE email = 'robert.smith@email.com'), 'Autism', 'Oakland, CA', 5, 38.00,
 'Experienced in Applied Behavior Analysis (ABA) and positive behavior support strategies.',
 'LIC-2024-005', 'approved', NOW(), 4.7, 76, NOW()),

-- Lisa Anderson
((SELECT id FROM users WHERE email = 'lisa.anderson@email.com'), 'Visual Learning', 'Fresno, CA', 9, 43.00,
 'Expert in visual learning strategies and assistive technology for special needs students.',
 'LIC-2024-006', 'approved', NOW(), 4.8, 89, NOW()),

-- James Brown
((SELECT id FROM users WHERE email = 'james.brown@email.com'), 'Behavioral Support', 'San Jose, CA', 4, 35.00,
 'Specialized in behavioral interventions and emotional regulation strategies.',
 'LIC-2024-007', 'pending', NULL, 0.0, 0, NOW()),

-- Patricia Davis
((SELECT id FROM users WHERE email = 'patricia.davis@email.com'), 'Academic Support', 'Santa Barbara, CA', 10, 48.00,
 'Experienced in adapting curriculum for diverse learning needs and creating individualized education plans.',
 'LIC-2024-008', 'approved', NOW(), 4.9, 112, NOW());

-- Insert Teacher Specializations (many-to-many)
-- Using INSERT IGNORE to avoid duplicate key errors
INSERT IGNORE INTO teacher_specializations (teacher_id, specialization) VALUES
-- Emily Johnson
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'Speech Therapy'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'Behavioral Support'),

-- David Chen
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'Math & Logic'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'Visual Learning'),

-- Dr. Sarah Williams
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'Sensory Integration'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'Behavioral Support'),

-- Jennifer Lopez
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'Social Skills'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'Academic Support'),

-- Robert Smith
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'Behavioral Support'),

-- Lisa Anderson
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'Visual Learning'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'Academic Support'),

-- James Brown
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'Behavioral Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'Emotional Regulation'),

-- Patricia Davis
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'Academic Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'Math & Logic'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'Reading & Writing');

-- Insert Teacher Availability
-- Using INSERT IGNORE to avoid duplicate key errors
INSERT IGNORE INTO teacher_availability (teacher_id, day_of_week, start_time, end_time, is_available) VALUES
-- Emily Johnson - Monday to Friday, 9 AM to 5 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'monday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'tuesday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'wednesday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'thursday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'friday', '09:00:00', '17:00:00', TRUE),

-- David Chen - Monday to Friday, 8 AM to 4 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'monday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'tuesday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'wednesday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'thursday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'friday', '08:00:00', '16:00:00', TRUE),

-- Dr. Sarah Williams - Monday to Thursday, 10 AM to 6 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'monday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'tuesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'wednesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'thursday', '10:00:00', '18:00:00', TRUE),

-- Jennifer Lopez - Monday to Friday, 9 AM to 3 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'monday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'tuesday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'wednesday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'thursday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'friday', '09:00:00', '15:00:00', TRUE),

-- Robert Smith - Monday to Friday, 8 AM to 5 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'monday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'tuesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'wednesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'thursday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'friday', '08:00:00', '17:00:00', TRUE),

-- Lisa Anderson - Monday to Friday, 9 AM to 4 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'monday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'tuesday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'wednesday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'thursday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'friday', '09:00:00', '16:00:00', TRUE),

-- James Brown - Monday to Friday, 10 AM to 6 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'monday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'tuesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'wednesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'thursday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'friday', '10:00:00', '18:00:00', TRUE),

-- Patricia Davis - Monday to Friday, 8 AM to 5 PM
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'monday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'tuesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'wednesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'thursday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'friday', '08:00:00', '17:00:00', TRUE);

-- Note: The password hash above is for "password123"
-- All users can log in with their email and password: password123
-- Admin: admin@learnsafe.ai / password123
-- Parents: sarah.martinez@email.com, michael.chen@email.com, etc. / password123
-- Teachers: emily.johnson@email.com, david.chen@email.com, etc. / password123
