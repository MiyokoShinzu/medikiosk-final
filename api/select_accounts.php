<?php
header('Content-Type: application/json');
include "../src/connection.php";

$sql = "SELECT id, username, access, email FROM accounts ORDER BY id DESC";
$result = $mysqli->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
