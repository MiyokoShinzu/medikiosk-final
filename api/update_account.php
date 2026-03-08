<?php

include '../src/connection.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? '';
$username = $data['username'] ?? '';
$email = $data['email'] ?? '';

if ($id == '' || $username == '' || $email == '') {

    echo json_encode([
        "success" => false,
        "message" => "Missing fields"
    ]);
    exit;
}

$stmt = $mysqli->prepare("UPDATE accounts SET username=?, email=? WHERE id=?");
$stmt->bind_param("ssi", $username, $email, $id);

if ($stmt->execute()) {

    echo json_encode(["success" => true]);
} else {

    echo json_encode([
        "success" => false,
        "message" => "Update failed"
    ]);
}
