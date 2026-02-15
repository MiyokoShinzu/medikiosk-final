<?php $title = "MediKiosk Login"; ?>
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
                                    <div class="feature-pill mb-2">Role-based login</div>
                                    <div class="feature-pill">Touch-friendly UI</div>
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

                                <form action="login_process.php" method="POST" class="w-100" autocomplete="off">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold" for="username">Username</label>
                                        <input type="text" id="username" name="username"
                                            class="form-control form-control-lg input-soft"
                                            placeholder="Enter username" required>
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

                                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="remember"
                                                name="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
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