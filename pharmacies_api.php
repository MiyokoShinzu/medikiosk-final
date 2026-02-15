<?php
// pharmacies_api.php
header("Content-Type: application/json; charset=UTF-8");
require_once "src/connection.php";

function out($ok, $extra = [])
{
    echo json_encode(array_merge(["ok" => $ok], $extra));
    exit;
}

$action = isset($_POST["action"]) ? trim($_POST["action"]) : "";

function clean_status($s)
{
    $s = strtolower(trim((string)$s));
    return $s === "inactive" ? "inactive" : "active";
}

if ($action === "list") {
    $sql = "SELECT id, name, address, phone, email, status, created_at FROM pharmacies ORDER BY id DESC";
    $res = $mysqli->query($sql);
    if (!$res) out(false, ["error" => "Query failed."]);

    $items = [];
    while ($row = $res->fetch_assoc()) $items[] = $row;
    out(true, ["items" => $items]);
}

if ($action === "create") {
    $name = trim((string)($_POST["name"] ?? ""));
    $address = trim((string)($_POST["address"] ?? ""));
    $phone = trim((string)($_POST["phone"] ?? ""));
    $email = trim((string)($_POST["email"] ?? ""));
    $status = clean_status($_POST["status"] ?? "active");

    if ($name === "" || $address === "") out(false, ["error" => "Name and address are required."]);

    $stmt = $mysqli->prepare("INSERT INTO pharmacies (name, address, phone, email, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    if (!$stmt) out(false, ["error" => "Prepare failed."]);
    $stmt->bind_param("sssss", $name, $address, $phone, $email, $status);

    if (!$stmt->execute()) out(false, ["error" => "Insert failed."]);
    out(true, ["id" => $mysqli->insert_id]);
}

if ($action === "update") {
    $id = (int)($_POST["id"] ?? 0);
    $name = trim((string)($_POST["name"] ?? ""));
    $address = trim((string)($_POST["address"] ?? ""));
    $phone = trim((string)($_POST["phone"] ?? ""));
    $email = trim((string)($_POST["email"] ?? ""));
    $status = clean_status($_POST["status"] ?? "active");

    if ($id <= 0) out(false, ["error" => "Invalid ID."]);
    if ($name === "" || $address === "") out(false, ["error" => "Name and address are required."]);

    $stmt = $mysqli->prepare("UPDATE pharmacies SET name=?, address=?, phone=?, email=?, status=?, updated_at=NOW() WHERE id=?");
    if (!$stmt) out(false, ["error" => "Prepare failed."]);
    $stmt->bind_param("sssssi", $name, $address, $phone, $email, $status, $id);

    if (!$stmt->execute()) out(false, ["error" => "Update failed."]);
    out(true);
}

if ($action === "set_status") {
    $id = (int)($_POST["id"] ?? 0);
    $status = clean_status($_POST["status"] ?? "active");

    if ($id <= 0) out(false, ["error" => "Invalid ID."]);

    $stmt = $mysqli->prepare("UPDATE pharmacies SET status=?, updated_at=NOW() WHERE id=?");
    if (!$stmt) out(false, ["error" => "Prepare failed."]);
    $stmt->bind_param("si", $status, $id);

    if (!$stmt->execute()) out(false, ["error" => "Status update failed."]);
    out(true);
}

out(false, ["error" => "Unknown action."]);
