<?php
include '../src/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $username   = $_GET['username'] ?? '';
    $password   = $_GET['password'] ?? '';
    $name       = $_GET['name'] ?? '';
    $account_id = $_GET['account_id'] ?? '';
    $address    = $_GET['address'] ?? '';

    if ($username == '' || $password == '' || $name == '' || $account_id == '' || $address == '') {
        echo json_encode(['success' => '0', 'message' => 'Missing required fields']);
        exit;
    }

    if (strpos($username, 'K-') !== 0) {
        echo json_encode(['success' => '0', 'message' => 'Username must start with K-']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check = $mysqli->query("SELECT id FROM kiosk_table WHERE username = '$username'");

    if ($check && $check->num_rows > 0) {
        echo json_encode(['success' => '0', 'message' => 'Username already exists']);
        exit;
    }

    $sql = "INSERT INTO kiosk_table (username, password, name, account_id, address)
            VALUES ('$username', '$hashedPassword', '$name', '$account_id', '$address')";

    $result = $mysqli->query($sql);

    if ($result) {
        echo json_encode(['success' => '1']);
    } else {
        echo json_encode(['success' => '0']);
    }
}
