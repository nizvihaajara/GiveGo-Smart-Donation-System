<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$storageDir = __DIR__ . '/config';
if (!is_dir($storageDir)) {
    @mkdir($storageDir, 0777, true);
}
$storageFile = $storageDir . '/guest_inquiries.json';

// Helper to load inquiries
function getStoredInquiries($file) {
    if (!file_exists($file)) {
        return [];
    }
    $content = @file_get_contents($file);
    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

// Helper to save inquiries
function saveStoredInquiries($file, $data) {
    @file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

// 1. GET: Retrieve list of inquiries (for Admin sync)
if ($method === 'GET') {
    $inquiries = getStoredInquiries($storageFile);
    echo json_encode([
        'success' => true,
        'inquiries' => $inquiries
    ]);
    exit;
}

// 2. POST: Submit a new inquiry or reply
if ($method === 'POST') {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);

    if (!$input) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid JSON payload.']);
        exit;
    }

    $inquiries = getStoredInquiries($storageFile);
    $now = date('c');

    if ($action === 'reply') {
        $inquiryId = $input['inquiryId'] ?? '';
        $message = trim($input['message'] ?? '');
        $senderName = trim($input['senderName'] ?? 'GiveGo Administrator');

        if (!$inquiryId || !$message) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing inquiryId or message.']);
            exit;
        }

        $found = false;
        foreach ($inquiries as &$inq) {
            if ($inq['id'] === $inquiryId) {
                if (!isset($inq['messages']) || !is_array($inq['messages'])) {
                    $inq['messages'] = [];
                }
                $inq['messages'][] = [
                    'id' => 'msg_' . uniqid(),
                    'senderRole' => 'admin',
                    'senderName' => $senderName,
                    'message' => $message,
                    'timestamp' => $now
                ];
                $inq['lastMessage'] = $message;
                $inq['lastMessageTime'] = $now;
                $inq['unreadByUser'] = true;
                $found = true;
                break;
            }
        }

        if ($found) {
            saveStoredInquiries($storageFile, $inquiries);
            echo json_encode(['success' => true, 'message' => 'Reply recorded successfully.']);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Inquiry not found.']);
        }
        exit;
    }

    // Default: Submit New Guest Inquiry
    $name = trim($input['name'] ?? $input['userName'] ?? '');
    $email = trim($input['email'] ?? $input['userEmail'] ?? '');
    $subject = trim($input['subject'] ?? 'General Public Inquiry');
    $message = trim($input['message'] ?? $input['lastMessage'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Name, email, and message are required.']);
        exit;
    }

    $inquiryId = $input['id'] ?? ('guest_inq_' . uniqid());
    $guestId = $input['userId'] ?? ('guest_' . time() . '_' . mt_rand(100, 999));

    $newInquiry = [
        'id' => $inquiryId,
        'userId' => $guestId,
        'userName' => $name,
        'userEmail' => $email,
        'userRole' => 'guest',
        'isGuest' => true,
        'district' => 'Public Web / Guest',
        'phone' => $input['phone'] ?? 'N/A',
        'subject' => $subject,
        'status' => 'open',
        'lastMessage' => $message,
        'lastMessageTime' => $now,
        'unreadByAdmin' => true,
        'unreadByUser' => false,
        'createdAt' => $now,
        'messages' => [
            [
                'id' => 'msg_' . uniqid(),
                'inquiryId' => $inquiryId,
                'senderId' => $guestId,
                'senderEmail' => $email,
                'senderName' => $name,
                'senderRole' => 'guest',
                'message' => $message,
                'timestamp' => $now,
                'read' => false
            ]
        ]
    ];

    array_unshift($inquiries, $newInquiry);
    saveStoredInquiries($storageFile, $inquiries);

    echo json_encode([
        'success' => true,
        'message' => 'Inquiry submitted successfully.',
        'inquiry' => $newInquiry
    ]);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'error' => 'Method not allowed.']);
