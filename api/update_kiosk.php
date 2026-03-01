<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

include '../src/connection.php';

$raw = file_get_contents("php://input");
$body = json_decode($raw, true);

if (!$body || !isset($body['id'])) {
    echo json_encode(["success" => false, "message" => "Invalid payload"]);
    exit;
}

$id = (int)$body['id'];
$username = trim($body['username'] ?? '');
$name = trim($body['name'] ?? '');
$address = trim($body['address'] ?? '');

$stmt = $mysqli->prepare("UPDATE kiosk_table SET username = ?, name = ?, address = ? WHERE id = ?");
$stmt->bind_param("sssi", $username, $name, $address, $id);

$ok = $stmt->execute();

echo json_encode([
    "success" => $ok ? true : false,
    "message" => $ok ? "Updated" : "Update failed"
]);

$stmt->close();
$mysqli->close();
