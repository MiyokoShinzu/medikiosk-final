<?php
header('Content-Type: application/json');
include "../src/connection.php";

$input = json_decode(file_get_contents("php://input"), true);

$id = isset($input['id']) ? (int)$input['id'] : 0;
if ($id <= 0) {
    echo json_encode(['success' => 0, 'message' => 'Missing id']);
    exit;
}

$name = $mysqli->real_escape_string($input['name'] ?? '');
$brand = $mysqli->real_escape_string($input['brand'] ?? '');
$category = $mysqli->real_escape_string($input['category'] ?? '');
$unit = $mysqli->real_escape_string($input['unit'] ?? '');
$availability = isset($input['availability']) ? (int)$input['availability'] : 0;
$prescription = $mysqli->real_escape_string($input['prescription'] ?? '');
$notes = $mysqli->real_escape_string($input['notes'] ?? '');

if (!in_array($availability, [0, 1], true)) $availability = 0;

$sql = "UPDATE medicines SET
            name='$name',
            brand='$brand',
            category='$category',
            unit='$unit',
            availability=$availability,
            prescription='$prescription',
            notes='$notes'
        WHERE id=$id";

if ($mysqli->query($sql)) {
    echo json_encode(['success' => 1]);
} else {
    echo json_encode(['success' => 0, 'message' => $mysqli->error]);
}
