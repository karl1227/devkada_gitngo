<?php
// Script to generate seed.sql with proper password hashes
// Run this script: php database/generate_seed.php
// It will generate a seed.sql file with correct password hashes

$password = 'password123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Generating seed.sql with password hash for 'password123'...\n";
echo "Hash: {$hash}\n\n";

$seed_content = <<<SQL
-- LearnSafe.AI Seed Data
-- This file contains sample data for testing and development
-- Password for all users: password123
-- Generated hash: {$hash}

USE devkada_gitngo;

-- Insert Users (Parents, Teachers, Admin)
INSERT INTO users (email, password, full_name, role, status, created_at) VALUES
-- Admin
('admin@learnsafe.ai', '{$hash}', 'Admin User', 'admin', 'active', NOW()),

-- Parents
('sarah.martinez@email.com', '{$hash}', 'Sarah Martinez', 'parent', 'active', NOW()),
('michael.chen@email.com', '{$hash}', 'Michael Chen', 'parent', 'active', NOW()),
('jennifer.williams@email.com', '{$hash}', 'Jennifer Williams', 'parent', 'active', NOW()),
('david.johnson@email.com', '{$hash}', 'David Johnson', 'parent', 'active', NOW()),
('maria.garcia@email.com', '{$hash}', 'Maria Garcia', 'parent', 'active', NOW()),

-- Teachers
('emily.johnson@email.com', '{$hash}', 'Emily Johnson', 'teacher', 'active', NOW()),
('david.chen@email.com', '{$hash}', 'David Chen', 'teacher', 'active', NOW()),
('sarah.williams@email.com', '{$hash}', 'Dr. Sarah Williams', 'teacher', 'active', NOW()),
('jennifer.lopez@email.com', '{$hash}', 'Jennifer Lopez', 'teacher', 'active', NOW()),
('robert.smith@email.com', '{$hash}', 'Robert Smith', 'teacher', 'active', NOW()),
('lisa.anderson@email.com', '{$hash}', 'Lisa Anderson', 'teacher', 'active', NOW()),
('james.brown@email.com', '{$hash}', 'James Brown', 'teacher', 'active', NOW()),
('patricia.davis@email.com', '{$hash}', 'Patricia Davis', 'teacher', 'active', NOW());

-- Insert Children (linked to parents)
INSERT INTO children (parent_id, name, age, learning_style, communication_style, special_needs, created_at) VALUES
((SELECT id FROM users WHERE email = 'sarah.martinez@email.com'), 'Alex Martinez', 7, 'Visual, Hands-on', 'Verbal & AAC', 'Prefers structured routines, benefits from visual schedules', NOW()),
((SELECT id FROM users WHERE email = 'michael.chen@email.com'), 'Emma Chen', 9, 'Auditory', 'Verbal', 'Needs frequent breaks, responds well to music', NOW()),
((SELECT id FROM users WHERE email = 'jennifer.williams@email.com'), 'Lucas Williams', 6, 'Kinesthetic', 'Non-verbal', 'Uses AAC device, loves sensory activities', NOW()),
((SELECT id FROM users WHERE email = 'david.johnson@email.com'), 'Sophia Johnson', 8, 'Visual', 'Verbal', 'Sensitive to loud noises, prefers quiet environments', NOW()),
((SELECT id FROM users WHERE email = 'maria.garcia@email.com'), 'Diego Garcia', 10, 'Mixed', 'Verbal & AAC', 'Strong in math, needs support with social skills', NOW());

-- Insert Teachers (linked to users)
INSERT INTO teachers (user_id, specialization, location, experience_years, hourly_rate, bio, license_number, verification_status, verified_at, rating, total_reviews, created_at) VALUES
((SELECT id FROM users WHERE email = 'emily.johnson@email.com'), 'Speech Therapy', 'San Francisco, CA', 8, 45.00, 'Specialized in autism support with a focus on communication and social skills development. Passionate about helping children find their voice.', 'LIC-2024-001', 'approved', NOW(), 4.9, 127, NOW()),
((SELECT id FROM users WHERE email = 'david.chen@email.com'), 'Math & Logic', 'Los Angeles, CA', 6, 40.00, 'Passionate about making learning accessible through visual and hands-on methods. Experienced in working with neurodiverse learners.', 'LIC-2024-002', 'approved', NOW(), 4.8, 93, NOW()),
((SELECT id FROM users WHERE email = 'sarah.williams@email.com'), 'Sensory Integration', 'San Diego, CA', 12, 55.00, 'Board-certified specialist in autism education with extensive sensory integration training. Dedicated to creating inclusive learning environments.', 'LIC-2024-003', 'approved', NOW(), 5.0, 145, NOW()),
((SELECT id FROM users WHERE email = 'jennifer.lopez@email.com'), 'Social Skills', 'Sacramento, CA', 7, 42.00, 'Creating safe, supportive environments for children to thrive academically and socially. Specialized in behavioral support.', 'LIC-2024-004', 'approved', NOW(), 4.9, 108, NOW()),
((SELECT id FROM users WHERE email = 'robert.smith@email.com'), 'Autism', 'Oakland, CA', 5, 38.00, 'Experienced in Applied Behavior Analysis (ABA) and positive behavior support strategies.', 'LIC-2024-005', 'approved', NOW(), 4.7, 76, NOW()),
((SELECT id FROM users WHERE email = 'lisa.anderson@email.com'), 'Visual Learning', 'Fresno, CA', 9, 43.00, 'Expert in visual learning strategies and assistive technology for special needs students.', 'LIC-2024-006', 'approved', NOW(), 4.8, 89, NOW()),
((SELECT id FROM users WHERE email = 'james.brown@email.com'), 'Behavioral Support', 'San Jose, CA', 4, 35.00, 'Specialized in behavioral interventions and emotional regulation strategies.', 'LIC-2024-007', 'pending', NULL, 0.0, 0, NOW()),
((SELECT id FROM users WHERE email = 'patricia.davis@email.com'), 'Academic Support', 'Santa Barbara, CA', 10, 48.00, 'Experienced in adapting curriculum for diverse learning needs and creating individualized education plans.', 'LIC-2024-008', 'approved', NOW(), 4.9, 112, NOW());

-- Insert Teacher Specializations
INSERT INTO teacher_specializations (teacher_id, specialization) VALUES
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'Speech Therapy'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'Behavioral Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'Math & Logic'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'Visual Learning'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'Sensory Integration'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'Behavioral Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'Social Skills'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'Academic Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'Autism'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'Behavioral Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'Visual Learning'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'Academic Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'Behavioral Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'Emotional Regulation'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'Academic Support'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'Math & Logic'),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'Reading & Writing');

-- Insert Teacher Availability
INSERT INTO teacher_availability (teacher_id, day_of_week, start_time, end_time, is_available) VALUES
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'monday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'tuesday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'wednesday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'thursday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-001'), 'friday', '09:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'monday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'tuesday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'wednesday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'thursday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-002'), 'friday', '08:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'monday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'tuesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'wednesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-003'), 'thursday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'monday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'tuesday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'wednesday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'thursday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-004'), 'friday', '09:00:00', '15:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'monday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'tuesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'wednesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'thursday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-005'), 'friday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'monday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'tuesday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'wednesday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'thursday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-006'), 'friday', '09:00:00', '16:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'monday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'tuesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'wednesday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'thursday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-007'), 'friday', '10:00:00', '18:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'monday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'tuesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'wednesday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'thursday', '08:00:00', '17:00:00', TRUE),
((SELECT id FROM teachers WHERE license_number = 'LIC-2024-008'), 'friday', '08:00:00', '17:00:00', TRUE);
SQL;

file_put_contents(__DIR__ . '/seed.sql', $seed_content);

echo "Seed file generated successfully!\n";
echo "File saved to: " . __DIR__ . "/seed.sql\n";
echo "\n";
echo "You can now import this file into your database.\n";
echo "All users will have the password: password123\n";

