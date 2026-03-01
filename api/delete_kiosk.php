<?php
include '../src/connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $val1 = $_GET['id'];
    $sql = "Delete from kiosk_table where id = '$val1'";
    $result = $mysqli->query($sql);
    if ($result) {
        echo json_encode(['success' => '1']);
    } else {
        echo json_encode(['success' => '0']);
    }
}
