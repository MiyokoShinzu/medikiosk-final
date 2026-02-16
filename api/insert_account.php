<?php
include '../src/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $username = $_GET['username'];
    $password = $_GET['password'];
    $email    = $_GET['email'];
    $access   = $_GET['access'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO accounts (username, password, email, access)
            VALUES ('$username', '$hashedPassword', '$email', '$access')";

    $result = $mysqli->query($sql);

    if ($result) {
        echo json_encode(['success' => '1']);
    } else {
        echo json_encode(['success' => '0']);
    }
}
