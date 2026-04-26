<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first    = trim($_POST['first_name'] ?? '');
    $last     = trim($_POST['last_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $role     = trim($_POST['role'] ?? 'public');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    $errors = [];
    if (strlen($first) < 2) $errors[] = "First name required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required.";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
    if ($password !== $confirm) $errors[] = "Passwords do not match.";

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        $db    = getDB();
        $check = $db->prepare("SELECT id FROM users WHERE email = :email");
        $check->execute([':email' => $email]);
        if ($check->fetch()) {
            http_response_code(409);
            echo json_encode(['success' => false, 'errors' => ['Email already registered.']]);
            exit;
        }

        $stmt = $db->prepare("
            INSERT INTO users (first_name, last_name, email, password, role, created_at)
            VALUES (:first, :last, :email, :password, :role, NOW())
        ");
        $stmt->execute([
            ':first'    => $first, ':last'  => $last,
            ':email'    => $email, ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':role'     => $role,
        ]);
        echo json_encode(['success' => true, 'message' => 'Account created. Please login.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'errors' => ['Database error.']]);
    }
} else {
    http_response_code(405);
}
?>
