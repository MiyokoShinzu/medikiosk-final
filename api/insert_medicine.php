<?php
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../src/connection.php';

function respond($success, $message = '', $extra = [])
{
    echo json_encode(array_merge([
        'success' => $success ? 1 : 0,
        'message' => $message
    ], $extra));
    exit;
}

function uuidv4(): string
{
    $data = random_bytes(16);
    // set version to 0100
    $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
    // set bits 6-7 to 10
    $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

    $hex = bin2hex($data);
    return sprintf(
        '%s-%s-%s-%s-%s',
        substr($hex, 0, 8),
        substr($hex, 8, 4),
        substr($hex, 12, 4),
        substr($hex, 16, 4),
        substr($hex, 20, 12)
    );
}

$kiosk_id = (int)($_SESSION['kiosk_id'] ?? 0);
if ($kiosk_id <= 0) {
    respond(false, 'Invalid kiosk session. Please open the kiosk page again.');
}

/* Read fields */
$name         = trim($_POST['name'] ?? '');
$brand        = trim($_POST['brand'] ?? '');
$category     = trim($_POST['category'] ?? '');
$unit         = trim($_POST['unit'] ?? '');
$availability = isset($_POST['availability']) ? (int)$_POST['availability'] : 0;
$prescription = trim($_POST['prescription'] ?? 'No');
$notes        = trim($_POST['notes'] ?? '');

/* Validate */
if ($name === '') respond(false, 'Name is required.');
if (!in_array($availability, [0, 1], true)) $availability = 0;
if ($prescription !== 'Yes' && $prescription !== 'No') $prescription = 'No';

/* Optional image upload */
$imagePath = null; // this is what we store in DB (e.g. uploads/uuid.jpg)

if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        respond(false, 'Image upload error.');
    }

    $tmpPath = $_FILES['image']['tmp_name'];
    $origName = $_FILES['image']['name'];
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $allowed, true)) {
        respond(false, 'Invalid image type. Allowed: jpg, jpeg, png, webp, gif.');
    }

    // Optional size limit (5MB)
    $maxBytes = 5 * 1024 * 1024;
    if (!empty($_FILES['image']['size']) && $_FILES['image']['size'] > $maxBytes) {
        respond(false, 'Image too large. Max 5MB.');
    }

    // Ensure uploads folder exists
    $projectRoot = realpath(__DIR__ . '/../');  // one level above /api
    $uploadDir = $projectRoot . '/uploads';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0775, true)) {
            respond(false, 'Failed to create uploads directory.');
        }
    }

    $uuid = uuidv4();
    $fileName = $uuid . '.' . $ext;

    // store relative path in DB
    $imagePath = 'uploads/' . $fileName;

    $destPath = $uploadDir . '/' . $fileName;

    if (!move_uploaded_file($tmpPath, $destPath)) {
        respond(false, 'Failed to save uploaded image.');
    }
}

/* Insert */
$sql = "INSERT INTO medicines
        (kiosk_id, name, brand, category, unit, availability, prescription, notes, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    // rollback uploaded image if any
    if ($imagePath) {
        @unlink(realpath(__DIR__ . '/../') . '/' . $imagePath);
    }
    respond(false, 'DB prepare failed: ' . $mysqli->error);
}

$stmt->bind_param(
    "issssisss",
    $kiosk_id,
    $name,
    $brand,
    $category,
    $unit,
    $availability,
    $prescription,
    $notes,
    $imagePath
);

if (!$stmt->execute()) {
    $errno = $stmt->errno;
    $err = $stmt->error;

    // rollback uploaded image if any
    if ($imagePath) {
        @unlink(realpath(__DIR__ . '/../') . '/' . $imagePath);
    }

    if ($errno == 1452) {
        respond(false, 'Foreign key error: kiosk_id does not exist in kiosk_table.');
    }
    respond(false, 'Insert failed: ' . $err);
}

$newId = $stmt->insert_id;
$stmt->close();

respond(true, 'Medicine inserted successfully.', [
    'id' => $newId,
    'image' => $imagePath
]);
