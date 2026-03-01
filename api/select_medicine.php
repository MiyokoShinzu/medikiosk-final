<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/connection.php';

// Get kiosk_id strictly from session
$kiosk_id = (int)($_SESSION['kiosk_id'] ?? 0);

if ($kiosk_id <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT 
            id,
            kiosk_id,
            name,
            brand,
            category,
            unit,
            availability,
            prescription,
            notes,
            image
        FROM medicines
        WHERE kiosk_id = ?
        ORDER BY id DESC";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode([]);
    exit;
}

$stmt->bind_param("i", $kiosk_id);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    // Ensure consistent types for JS
    $row['id'] = (string)$row['id'];
    $row['kiosk_id'] = (string)$row['kiosk_id'];
    $row['availability'] = (string)$row['availability']; // "1" or "0"
    $row['prescription'] = $row['prescription'] ?? "No";
    $row['notes'] = $row['notes'] ?? "";
    $row['image'] = $row['image'] ?? "";

    $data[] = $row;
}

$stmt->close();

echo json_encode($data);
