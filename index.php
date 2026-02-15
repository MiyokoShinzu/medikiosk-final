<?php $title = "MediKiosk Home"; ?>
<?php include 'globals/head.php'; ?>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 overflow-hidden">

    <div id="tapScreen" class="tap-screen">
        <div class="tap-content text-center px-4">
            <div class="brand-badge mb-4">
                <span class="brand-icon">+</span>
            </div>

            <h1 class="brand-title mb-2">MediKiosk</h1>
            <p class="brand-subtitle mb-4">Touchscreen Medical Assistance Kiosk</p>

            <button class="btn btn-lg btn-light tap-btn px-4 px-sm-5 py-3" type="button">
                <span class="me-2">Tap to Start</span>
                <span class="tap-arrow">→</span>
            </button>

            <div class="tap-hint mt-4">
                <span class="hint-dot"></span>
                <small class="opacity-75">This device will enter full-screen kiosk mode</small>
            </div>
        </div>
    </div>

    <div id="loaderScreen" class="loader-wrap d-none">
        <div class="loader-card text-center">
            <div class="mb-4">
                <h2 class="loader-title mb-1">MediKiosk</h2>
                <p id="loadingText" class="loader-subtitle mb-0">Initializing system...</p>
            </div>

            <div class="progress loader-progress">
                <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    style="width: 0%;"></div>
            </div>

            <div class="progress-meta mt-3">
                <span id="progressLabel">0%</span>
                <span>Please wait...</span>
            </div>
        </div>
    </div>

    <?php include 'globals/scripts.php'; ?>

    <style>
        .tap-screen {
            position: fixed;
            inset: 0;
            z-index: 9999;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 24px;
            background:
                radial-gradient(1200px 600px at 30% 20%, rgba(255, 255, 255, 0.20), transparent 60%),
                radial-gradient(900px 500px at 70% 70%, rgba(255, 255, 255, 0.12), transparent 60%),
                linear-gradient(135deg, #0d6efd, #1363d1 55%, #0b5ed7);
        }

        .tap-content {
            width: 100%;
            max-width: 560px;
            user-select: none;
        }

        .brand-badge {
            width: clamp(72px, 9vw, 92px);
            height: clamp(72px, 9vw, 92px);
            border-radius: 24px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            display: grid;
            place-items: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        }

        .brand-icon {
            width: clamp(40px, 5vw, 48px);
            height: clamp(40px, 5vw, 48px);
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-weight: 900;
            font-size: clamp(22px, 2.6vw, 28px);
            background: rgba(255, 255, 255, 0.95);
            color: #0d6efd;
        }

        .brand-title {
            font-weight: 800;
            letter-spacing: -0.02em;
            font-size: clamp(28px, 4vw, 40px);
            margin-bottom: 6px;
        }

        .brand-subtitle {
            opacity: 0.9;
            font-size: clamp(14px, 2vw, 18px);
            margin-bottom: 18px;
        }

        .tap-btn {
            border-radius: 16px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.25);
            font-weight: 700;
            font-size: clamp(16px, 2vw, 18px);
        }

        .tap-arrow {
            display: inline-block;
            transition: transform .25s ease;
        }

        .tap-screen:hover .tap-arrow {
            transform: translateX(4px);
        }

        .tap-hint {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .hint-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.12);
        }

        .loader-wrap {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: clamp(18px, 4vw, 48px) clamp(14px, 4vw, 28px);
        }

        .loader-card {
            width: 100%;
            max-width: 560px;
            background: #ffffff;
            border-radius: 20px;
            padding: clamp(22px, 4vw, 40px) clamp(18px, 4vw, 36px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: opacity .6s ease, transform .6s ease;
        }

        .loader-title {
            font-weight: 800;
            letter-spacing: -0.02em;
            font-size: clamp(22px, 3vw, 30px);
        }

        .loader-subtitle {
            color: #6c757d;
            min-height: 24px;
            font-size: clamp(14px, 2vw, 16px);
        }

        .loader-progress {
            height: clamp(14px, 2.4vw, 18px);
            border-radius: 999px;
            background: #eef2ff;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #0d6efd;
            transition: width .35s ease;
        }

        .progress-bar-striped {
            background-image: linear-gradient(45deg,
                    rgba(255, 255, 255, .25) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, .25) 50%,
                    rgba(255, 255, 255, .25) 75%,
                    transparent 75%,
                    transparent);
            background-size: 1rem 1rem;
        }

        .progress-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: clamp(12px, 1.8vw, 14px);
            color: #6c757d;
            flex-wrap: wrap;
        }
    </style>

    <script>
        const tapScreen = document.getElementById("tapScreen");
        const loaderScreen = document.getElementById("loaderScreen");

        tapScreen.addEventListener("click", async () => {
            if (!document.fullscreenElement) {
                try {
                    await document.documentElement.requestFullscreen();
                } catch (e) {
                    console.warn("Fullscreen request failed:", e);
                }
            }

            tapScreen.classList.add("d-none");
            loaderScreen.classList.remove("d-none");
            startLoader();
        });

        function startLoader() {
            let progress = 0;
            const bar = document.getElementById("progressBar");
            const text = document.getElementById("loadingText");
            const progressLabel = document.getElementById("progressLabel");
            const card = loaderScreen.querySelector(".loader-card");

            const messages = [
                "Initializing system…",
                "Loading medicine database…",
                "Checking services availability…",
                "Starting kiosk interface…",
                "Applying secure session settings…",
                "Preparing user interface…"
            ];

            const loader = setInterval(() => {
                let increment;

                if (progress < 30) {
                    increment = Math.random() * 4 + 2;
                } else if (progress < 80) {
                    increment = Math.random() * 6 + 4;
                } else {
                    increment = Math.random() * 2 + 1;
                }

                progress += increment;

                if (progress >= 100) {
                    progress = 100;
                    bar.style.width = "100%";
                    progressLabel.innerText = "100%";
                    text.innerText = "Ready";

                    clearInterval(loader);

                    setTimeout(() => {
                        card.style.opacity = "0";
                        card.style.transform = "translateY(6px)";
                    }, 400);

                    setTimeout(() => {
                        window.location.href = "login.php";
                    }, 900);
                } else {
                    const p = Math.round(progress);
                    bar.style.width = p + "%";
                    progressLabel.innerText = p + "%";

                    if (Math.random() < 0.22) {
                        text.innerText = messages[Math.floor(Math.random() * messages.length)];
                    }
                }
            }, 280);
        }
    </script>

</body>

</html>