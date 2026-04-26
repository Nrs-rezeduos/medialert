<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $type     = trim($_POST['type'] ?? '');
    $severity = trim($_POST['severity'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $victims  = intval($_POST['victims'] ?? 1);
    $email    = trim($_POST['email'] ?? '');
    $desc     = trim($_POST['description'] ?? '');
    $lat      = $_POST['lat'] ?? null;
    $lng      = $_POST['lng'] ?? null;

    $errors = [];
    if (strlen($name) < 2)    $errors[] = "Name is required.";
    if (!preg_match('/^[0-9]{10}$/', $phone)) $errors[] = "Valid 10-digit phone required.";
    if (empty($type))         $errors[] = "Emergency type is required.";
    if (empty($severity))     $errors[] = "Severity is required.";
    if (strlen($location) < 5) $errors[] = "Location is required.";
    if (strlen($desc) < 20)   $errors[] = "Description too short (min 20 chars).";

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO incidents
                (reporter_name, reporter_phone, reporter_email, type, severity,
                 location, latitude, longitude, victims_count, description, status, reported_at)
            VALUES
                (:name, :phone, :email, :type, :severity,
                 :location, :lat, :lng, :victims, :desc, 'pending', NOW())
        ");
        $stmt->execute([
            ':name'     => $name,   ':phone'    => $phone,
            ':email'    => $email,  ':type'     => $type,
            ':severity' => $severity, ':location' => $location,
            ':lat'      => $lat,    ':lng'      => $lng,
            ':victims'  => $victims, ':desc'    => $desc,
        ]);
        echo json_encode(['success' => true, 'incident_id' => $db->lastInsertId()]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'errors' => ['Database error: ' . $e->getMessage()]]);
    }
} else {
    http_response_code(405);
}
?>
