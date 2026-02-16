<?php
include '../src/connection.php';
session_start();
header('Content-Type: application/json');

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$remember = isset($_POST['remember']) ? (int)$_POST['remember'] : 0;

if ($username === '' || $password === '') {
    echo json_encode(['success' => '0', 'message' => 'Username and password required']);
    exit;
}

$username = $mysqli->real_escape_string($username);

$sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {

    $row = $result->fetch_assoc();

    if ((int)$row['status'] !== 1) {
        echo json_encode(['success' => '0', 'message' => 'Account disabled']);
        exit;
    }

    if (!password_verify($password, $row['password_hash'])) {
        echo json_encode(['success' => '0', 'message' => 'Invalid credentials']);
        exit;
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['role'];

    if ($remember === 1) {

        $selector = bin2hex(random_bytes(8));
        $token = bin2hex(random_bytes(32));
        $token_hash = hash('sha256', $token);

        date_default_timezone_set('Asia/Manila');
        $expires_at = date('Y-m-d H:i:s', time() + (60 * 60 * 24 * 30));

        $selector = $mysqli->real_escape_string($selector);
        $token_hash = $mysqli->real_escape_string($token_hash);

        $uid = (int)$row['id'];

        $insertToken = "
            INSERT INTO auth_tokens (user_id, selector, token_hash, expires_at)
            VALUES ('$uid', '$selector', '$token_hash', '$expires_at')
        ";
        $mysqli->query($insertToken);

        $cookie_val = $selector . ':' . $token;
        setcookie('remember_me', $cookie_val, time() + (60 * 60 * 24 * 30), "/", "", false, true);
    }

    echo json_encode([
        'success' => '1',
        'message' => 'Login success',
        'data' => [
            'id' => (int)$row['id'],
            'username' => $row['username'],
            'role' => $row['role']
        ]
    ]);
    exit;
}

echo json_encode(['success' => '0', 'message' => 'Invalid credentials']);
exit;
