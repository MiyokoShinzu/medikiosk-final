<?php
include '../src/connection.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   $account_id = $_SESSION['user_id'];
    $sql = 'Select * from kiosk_table where account_id = ' . $account_id;
    $result = $mysqli->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}
