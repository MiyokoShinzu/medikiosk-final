<?php
$servername = "localhost";
$username = "u148988291_med"; // Change username
$password = "c6ehxV57"; // Change password
$dbname = "u148988291_medikiosk"; // Change database name

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
