<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    if (strlen($name) < 2)    $errors[] = "Name required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required.";
    if (strlen($message) < 10) $errors[] = "Message too short.";

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        $db   = getDB();
        $stmt = $db->prepare("INSERT INTO contact_messages (name, email, subject, message, sent_at) VALUES (:name, :email, :subject, :message, NOW())");
        $stmt->execute([':name' => $name, ':email' => $email, ':subject' => $subject, ':message' => $message]);
        echo json_encode(['success' => true, 'message' => 'Message received. We will reply within 24 hours.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'errors' => ['Database error.']]);
    }
} else {
    http_response_code(405);
}
?>
