<?php
require_once __DIR__ . '/../config/config.php';

// Rate limiting (optional - uncomment to enable)
// require_once __DIR__ . '/rate_limit.php';

header('Content-Type: application/json');
// Allow CORS for same-origin requests (adjust if needed for cross-origin)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$message = sanitize($data['message'] ?? '');

if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Message is required']);
    exit;
}

// OpenAI API Configuration
// IMPORTANT: Add your OpenAI API key in config/config.php or set it here
$api_key = defined('OPENAI_API_KEY') ? OPENAI_API_KEY : 'YOUR_OPENAI_API_KEY_HERE';

// If no API key is set, fall back to rule-based responses
if ($api_key === 'YOUR_OPENAI_API_KEY_HERE' || empty($api_key)) {
    // Fallback to rule-based responses
    $response = getRuleBasedResponse($message);
    echo json_encode([
        'success' => true,
        'message' => $response['text'],
        'speak' => $response['speak']
    ]);
    exit;
}

// OpenAI API Request
$url = 'https://api.openai.com/v1/chat/completions';

$system_prompt = "You are a helpful AI assistant for LearnSafe.AI, a platform that connects parents with verified SPED (Special Education) teachers for children with autism and special needs. Your role is to provide conversational onboarding and support for parents. Be friendly, empathetic, and informative. Help parents understand how to get started, find teachers, understand pricing, safety measures, and platform features. Keep responses concise but helpful.";

$payload = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        [
            'role' => 'system',
            'content' => $system_prompt
        ],
        [
            'role' => 'user',
            'content' => $message
        ]
    ],
    'max_tokens' => 300,
    'temperature' => 0.7
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    // Fallback to rule-based if API call fails
    $response = getRuleBasedResponse($message);
    echo json_encode([
        'success' => true,
        'message' => $response['text'],
        'speak' => $response['speak']
    ]);
    exit;
}

if ($http_code !== 200) {
    // Fallback to rule-based if API returns error
    $response = getRuleBasedResponse($message);
    echo json_encode([
        'success' => true,
        'message' => $response['text'],
        'speak' => $response['speak']
    ]);
    exit;
}

$result = json_decode($response, true);

if (isset($result['choices'][0]['message']['content'])) {
    $ai_message = $result['choices'][0]['message']['content'];
    echo json_encode([
        'success' => true,
        'message' => $ai_message,
        'speak' => true
    ]);
} else {
    // Fallback to rule-based
    $response = getRuleBasedResponse($message);
    echo json_encode([
        'success' => true,
        'message' => $response['text'],
        'speak' => $response['speak']
    ]);
}

// Fallback rule-based response function
function getRuleBasedResponse($userMessage) {
    $message = strtolower($userMessage);
    
    // Greeting responses
    if (strpos($message, 'hello') !== false || strpos($message, 'hi') !== false || strpos($message, 'hey') !== false) {
        return [
            'text' => "Hello! Welcome to LearnSafe.AI! I'm here to help you get started. Would you like to know more about how our platform works, or do you have specific questions about finding a teacher for your child?",
            'speak' => true
        ];
    }
    
    // Getting started
    if (strpos($message, 'start') !== false || strpos($message, 'begin') !== false || strpos($message, 'how do i') !== false) {
        return [
            'text' => "Great! To get started:\n\n1. Click 'Get Started' or 'Sign Up' to create your account\n2. Choose whether you're a Parent or Teacher\n3. Fill in your information and your child's profile (if you're a parent)\n4. Our AI will match you with verified SPED teachers\n5. Browse teachers and book sessions\n\nWould you like me to explain any of these steps in more detail?",
            'speak' => true
        ];
    }
    
    // Teacher questions
    if (strpos($message, 'teacher') !== false || strpos($message, 'tutor') !== false || strpos($message, 'find') !== false) {
        return [
            'text' => "We have verified SPED teachers ready to help! Here's how to find one:\n\n1. Sign up as a Parent\n2. Complete your child's profile with their learning needs\n3. Our AI matching system will suggest compatible teachers\n4. Browse teacher profiles, specializations, and reviews\n5. Book a session with your preferred teacher\n\nAll our teachers are background-checked and SPED-certified. Would you like to know more about our verification process?",
            'speak' => true
        ];
    }
    
    // Pricing questions
    if (strpos($message, 'price') !== false || strpos($message, 'cost') !== false || strpos($message, 'fee') !== false || strpos($message, 'pay') !== false) {
        return [
            'text' => "Pricing varies by teacher, typically ranging from $35-$55 per hour. Each teacher sets their own rates based on experience and specialization. You can see the hourly rate on each teacher's profile before booking. Payment is secure and processed through our platform. Would you like to see available teachers and their rates?",
            'speak' => true
        ];
    }
    
    // Safety/verification questions
    if (strpos($message, 'safe') !== false || strpos($message, 'verify') !== false || strpos($message, 'background') !== false || strpos($message, 'check') !== false) {
        return [
            'text' => "Safety is our top priority! All teachers go through:\n\n✓ Background checks\n✓ License verification\n✓ SPED certification verification\n✓ Identity verification\n✓ Admin approval process\n\nWe ensure every teacher on our platform is qualified and safe to work with children. Would you like to know more about our safety measures?",
            'speak' => true
        ];
    }
    
    // Features questions
    if (strpos($message, 'feature') !== false || strpos($message, 'what can') !== false || strpos($message, 'offer') !== false) {
        return [
            'text' => "LearnSafe.AI offers:\n\n✨ AI-powered teacher matching\n📊 Progress tracking and insights\n📅 Easy session scheduling\n💬 Direct communication with teachers\n📈 Detailed learning reports\n🤖 AI insights for personalized learning\n\nWould you like details on any specific feature?",
            'speak' => true
        ];
    }
    
    // Help/Support
    if (strpos($message, 'help') !== false || strpos($message, 'support') !== false || strpos($message, 'problem') !== false) {
        return [
            'text' => "I'm here to help! You can:\n\n1. Ask me questions about the platform\n2. Contact our support team through your dashboard\n3. Check our FAQ section\n4. Email us at support@learnsafe.ai\n\nWhat specific help do you need?",
            'speak' => true
        ];
    }
    
    // Default response
    return [
        'text' => "I understand you're asking about: \"" . htmlspecialchars($userMessage) . "\". Let me help you with that! You can ask me about:\n\n• Getting started\n• Finding teachers\n• Pricing\n• Safety and verification\n• Platform features\n• How to sign up\n\nWhat would you like to know more about?",
        'speak' => true
    ];
}

