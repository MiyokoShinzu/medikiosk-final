<?php
$title = "MediKiosk Login";
session_start();

include "src/connection.php";

$mysqli = $mysqli;

if (!($mysqli instanceof mysqli)) {
    http_response_code(500);
    die("Database connection not available. Check src/connection.php");
}

$mysqli->set_charset("utf8mb4");

function h($s)
{
    return htmlspecialchars((string)$s, ENT_QUOTES, "UTF-8");
}

$redirectTo = "dashboard.php";

$alert = "";
$alertType = "info";
$doRedirect = false;

if (isset($_GET["api"]) && $_GET["api"] === "login") {

    $username = trim((string)($_GET["username"] ?? ""));
    $password = (string)($_GET["password"] ?? "");

    if ($username === "" || $password === "") {
        $alertType = "warning";
        $alert = "Please enter both username and password.";
    } else {
        $table = null;

        if (stripos($username, "K-") === 0) {
            $table = "kiosk_table";
        } elseif (stripos($username, "P-") === 0) {
            $table = "accounts";
        } else {
            $alertType = "warning";
            $alert = "Invalid username format. Use K-... or P-...";
        }

        if ($table) {
            $sql = "SELECT * FROM {$table} WHERE username = ? LIMIT 1";
            $stmt = $mysqli->prepare($sql);

            if (!$stmt) {
                $alertType = "danger";
                $alert = "Server error. Please try again.";
            } else {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res ? $res->fetch_assoc() : null;
                $stmt->close();

                if (!$row) {
                    $alertType = "danger";
                    $alert = "Username does not exist.";
                } else {
                    $dbPass = (string)$row["password"];
                    $ok = password_verify($password, $dbPass) || hash_equals($dbPass, $password);

                    if (!$ok) {
                        $alertType = "danger";
                        $alert = "Incorrect password.";
                    } else {
                        $_SESSION["logged_in"] = true;
                        $_SESSION["user_id"] = $row["id"];
                        $_SESSION["username"] = $row["username"];
                        $_SESSION["email"] = $row["email"] ?? "N/A";
                        $_SESSION["source_table"] = $table;
                        $_SESSION["access"] = $row["access"];
                        $_SESSION["kiosk_id"] = $row["id"] ?? "Unknown Kiosk";
                        $_SESSION["kiosk_name"] = $row["name"] ?? "Unknown Kiosk";
                        $_SESSION["address"] = $row["address"] ?? "Unknown Kiosk";

                        $alertType = "success";
                        $alert = "Login successful. Redirecting…". $row["access"];
                        if($row['access']==3){
                            $redirectTo = "kiosk.php";
                        }
                        else if($row['access']==2){
                            $redirectTo = "dashboard.php";
                        }
                        else if($row['access']==0){
                            $redirectTo = "admin.php";
                        }
                        else{
                            $redirectTo = "login.php";
                        }
                        $doRedirect = true;
                    }
                }
            }
        }
    }
}
?>

<?php include 'globals/head.php'; ?>

<body class="bg-light min-vh-100 overflow-hidden d-flex align-items-center">

    <div class="container-fluid px-3 px-sm-4 px-lg-5">
        <div class="row align-items-center justify-content-center g-4">

            <div class="col-12 col-md-10 col-lg-9 col-xl-8">
                <div class="login-shell">

                    <div class="row g-0 align-items-stretch">

                        <div class="col-12 col-lg-5 login-left d-flex align-items-center justify-content-center">
                            <div class="text-center px-4 py-4 py-lg-5">
                                <div class="brand-badge mb-3">
                                    <span class="brand-icon">+</span>
                                </div>
                                <h1 class="brand-title mb-2">MediKiosk</h1>
                                <p class="brand-subtitle mb-0">Secure kiosk sign-in</p>

                                <div class="mt-4 d-none d-lg-block">
                                    <div class="feature-pill mb-2">Fast access</div>
                                    <div class="feature-pill mb-2">Secure Login</div>
                                    <div class="feature-pill">UI-Friendly Design</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-7 login-right d-flex align-items-center">
                            <div class="w-100 px-3 px-sm-4 px-md-5 py-4 py-lg-5">

                                <div class="d-lg-none text-center mb-4">
                                    <div class="brand-badge mb-3">
                                        <span class="brand-icon">+</span>
                                    </div>
                                    <h2 class="brand-title mb-1">MediKiosk</h2>
                                    <p class="brand-subtitle mb-0">Secure kiosk sign-in</p>
                                </div>

                                <?php if ($alert !== ""): ?>
                                    <div class="alert alert-<?php echo h($alertType); ?> mb-3" role="alert">
                                        <?php echo h($alert); ?>
                                    </div>

                                    <?php if ($doRedirect): ?>
                                        <meta http-equiv="refresh" content="1;url=<?php echo h($redirectTo); ?>">
                                        <script>
                                            setTimeout(() => {
                                                window.location.href = <?php echo json_encode($redirectTo); ?>;
                                            }, 1000);
                                        </script>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <form action="" method="GET" class="w-100" autocomplete="off">
                                    <input type="hidden" name="api" value="login">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" for="username">Username</label>
                                        <input type="text" id="username" name="username"
                                            class="form-control form-control-lg input-soft"
                                            placeholder="Enter username"
                                            value="<?php echo h($_GET["username"] ?? ""); ?>"
                                            required>
                                        <div class="form-text">Use <strong>K-</strong> for kiosk, <strong>P-</strong> for individual accounts.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" for="password">Password</label>
                                        <div class="input-group input-group-lg">
                                            <input type="password" id="password" name="password"
                                                class="form-control input-soft input-soft-right"
                                                placeholder="Enter password" required>
                                            <button class="btn btn-outline-primary toggle-btn" type="button"
                                                id="togglePass" aria-label="Show password">
                                                <span id="toggleIcon">Show</span>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 login-btn">
                                        Sign in
                                    </button>

                                    <div class="text-center mt-3">
                                        <small class="text-muted">--------------------</small>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php include 'globals/scripts.php'; ?>

    <style>
        .login-shell {
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 28px 90px rgba(0, 0, 0, 0.12);
        }

        .login-left {
            color: #ffffff;
            background:
                radial-gradient(900px 520px at 25% 25%, rgba(255, 255, 255, 0.18), transparent 60%),
                radial-gradient(820px 520px at 70% 70%, rgba(255, 255, 255, 0.10), transparent 60%),
                linear-gradient(135deg, #0d6efd, #1363d1 55%, #0b5ed7);
            min-height: 220px;
        }

        .login-right {
            background: #ffffff;
        }

        .brand-badge {
            width: clamp(64px, 8vw, 86px);
            height: clamp(64px, 8vw, 86px);
            border-radius: 24px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.18);
            display: grid;
            place-items: center;
            backdrop-filter: blur(10px);
        }

        .brand-icon {
            width: clamp(38px, 5vw, 46px);
            height: clamp(38px, 5vw, 46px);
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-weight: 900;
            font-size: clamp(22px, 2.6vw, 28px);
            background: rgba(255, 255, 255, 0.95);
            color: #0d6efd;
        }

        .brand-title {
            font-weight: 900;
            letter-spacing: -0.03em;
            font-size: clamp(26px, 3.6vw, 42px);
            line-height: 1.1;
        }

        .brand-subtitle {
            opacity: 0.9;
            font-size: clamp(13px, 1.8vw, 16px);
        }

        .feature-pill {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            font-weight: 700;
            font-size: 0.92rem;
        }

        .input-soft {
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.10);
            background: #f8fafc;
            padding-top: 14px;
            padding-bottom: 14px;
        }

        .input-soft:focus {
            background: #ffffff;
            border-color: rgba(13, 110, 253, 0.60);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.14);
        }

        .input-soft-right {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .toggle-btn {
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
            border-left: 0;
            padding-left: 18px;
            padding-right: 18px;
            font-weight: 800;
        }

        .login-btn {
            border-radius: 16px;
            padding-top: 14px;
            padding-bottom: 14px;
            font-weight: 900;
            box-shadow: 0 18px 40px rgba(13, 110, 253, 0.25);
        }

        @media (max-width: 575.98px) {
            body {
                align-items: stretch;
            }

            .login-shell {
                border-radius: 18px;
            }

            .login-left {
                min-height: 200px;
            }
        }
    </style>

    <script>
        const toggleBtn = document.getElementById("togglePass");
        const passInput = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");

        toggleBtn.addEventListener("click", () => {
            const isHidden = passInput.type === "password";
            passInput.type = isHidden ? "text" : "password";
            toggleIcon.textContent = isHidden ? "Hide" : "Show";
            toggleBtn.setAttribute("aria-label", isHidden ? "Hide password" : "Show password");
        });
    </script>

</body>

</html>