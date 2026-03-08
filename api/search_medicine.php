<?php
header('Content-Type: application/json');
include "../src/connection.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$prescription = isset($_GET['prescription']) ? trim($_GET['prescription']) : '';

$sql = "
    SELECT 
        m.name AS m_name,
        m.image AS file_path,
        m.brand AS m_brand,
        m.prescription AS m_prescription,
        k.name AS k_name,
        k.address AS k_address,
        a.username AS u_name
    FROM medicines AS m
    JOIN kiosk_table AS k ON m.kiosk_id = k.id
    JOIN accounts AS a ON k.account_id = a.id
    WHERE m.availability = 1
";

$params = [];
$types = '';

if ($search !== '') {
    $sql .= " AND (
        m.name LIKE ? OR
        m.brand LIKE ? OR
        k.name LIKE ? OR
        k.address LIKE ? OR
        a.username LIKE ?
    )";

    $term = "%{$search}%";
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
    $types .= 'sssss';
}

if ($prescription !== '') {
    $sql .= " AND m.prescription = ?";
    $params[] = $prescription;
    $types .= 's';
}

$sql .= " ORDER BY m.name ASC";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode([]);
    exit;
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
