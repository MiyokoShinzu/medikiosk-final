<?php
header('Content-Type: application/json');
include "../src/connection.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => 0, 'message' => 'Missing id']);
    exit;
}

$sql = "DELETE FROM medicines WHERE id=$id";
if ($mysqli->query($sql)) {
    echo json_encode(['success' => 1]);
} else {
    echo json_encode(['success' => 0, 'message' => $mysqli->error]);
}
