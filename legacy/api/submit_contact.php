<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/EmailService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $referer = $_SERVER['HTTP_REFERER'] ?? '../index.php';
    $redirectUrl = strtok($referer, '?');

    if (empty($name) || empty($email) || empty($message)) {
        header("Location: $redirectUrl?contact_status=error#contact");
        exit;
    }

    try {
        firebase_create('contact_requests', [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'status' => 'unread',
            'created_at' => date('Y-m-d H:i:s'),
        ], $firebaseDatabase);

        $to = 'emmco96@gmail.com';
        $emailSubject = "New Portfolio Message: $subject";
        $emailBody = "You have received a new message from your portfolio contact form.\n\n" .
            "Name: $name\n" .
            "Email: $email\n\n" .
            "Message:\n$message";

        EmailService::send($to, $emailSubject, $emailBody);

        header("Location: $redirectUrl?contact_status=success#contact");
        exit;
    } catch (Throwable $e) {
        header("Location: $redirectUrl?contact_status=error#contact");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>
