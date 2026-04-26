<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
if (empty($email) || empty($password)) {
    echo "Email and password required.";
    exit;
}

    try {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

       if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['first_name'];
    $_SESSION['user_role'] = $user['role'];

    header("Location: ../index.php"); // or dashboard page
    exit;
} else {
    echo "Invalid email or password.";
}
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error.']);
    }
} else {
    http_response_code(405);
}
?>
