<?php

include '../src/connection.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? '';

if ($id == '') {
    echo json_encode(['success' => '0']);
    exit;
}

$stmt = $mysqli->prepare("DELETE FROM accounts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => '1']);
} else {
    echo json_encode(['success' => '0']);
}
