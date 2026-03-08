<?php
include '../src/connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';
    $email    = $data['email'] ?? '';
    $access   = 3;

    if ($username === '' || $password === '' || $email === '') {
        echo json_encode([
            "success" => false,
            "message" => "Missing required fields"
        ]);
        exit;
    }
    if (!str_starts_with($username, 'P-')) {
        echo json_encode([
            "success" => false,
            "message" => "Username must start with P-"
        ]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO accounts (username, password, email, access) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $hashedPassword, $email, $access);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Insert failed"
        ]);
    }
}
