<?php $title = "MediKiosk Admin"; ?>
<?php include 'globals/kiosk_header.php'; ?>


<body class="bg-light min-vh-100 overflow-hidden">

    <div class="app">

        <?php include "globals/kiosk_sidebar.php"; ?>

        <div id="overlay" class="overlay d-none"></div>

        <main id="main" class="main">

            <?php include "globals/kiosk_topbar.php"; ?>

            <section class="content container-fluid px-3 px-sm-4 px-lg-5 py-4">

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-12">
                        <div class="stat-card">
                            <div class="stat-label">Total Kiosks</div>
                            <div class="stat-value">3</div>
                            <div class="stat-sub">Registered kiosks</div>
                        </div>
                    </div>
                   
                </div>

                <div class="card table-card">
                    <div class="card-body p-3 p-sm-4 p-lg-5">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
                            <div>
                                <h3 class="section-title mb-1">Kiosk Table</h3>
                                <p class="section-subtitle mb-0">Sample data (no API)</p>
                            </div>
                            <div class="search-wrap">
                                <input class="form-control input-soft search-input" placeholder="Search kiosks...">
                                <span class="search-icon">⌕</span>
                            </div>
                        </div>

                        <div class="table-responsive soft-table">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Account ID</th>
                                        <th>Address</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">K-001</td>
                                        <td>Lobby Kiosk</td>
                                        <td>1</td>
                                        <td>City Center</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger ms-1">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">K-002</td>
                                        <td>ER Kiosk</td>
                                        <td>1</td>
                                        <td>Emergency Wing</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger ms-1">Delete</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">K-003</td>
                                        <td>Pharmacy Kiosk</td>
                                        <td>2</td>
                                        <td>Main Pharmacy</td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger ms-1">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </section>

        </main>

    </div>

    <?php include 'globals/scripts.php'; ?>

    <style>
        :root {
            --side-w: 280px;
            --radius-2xl: 22px;
            --soft-border: rgba(0, 0, 0, .06);
            --soft-shadow: 0 26px 90px rgba(0, 0, 0, .10);
            --muted: #6c757d;
            --bg-soft: #f8fafc;
            --blue-soft: rgba(13, 110, 253, .10);
            --blue-border: rgba(13, 110, 253, .16);
            --green: #22c55e;
        }

        .app {
            min-height: 100vh;
            display: grid;
            grid-template-columns: var(--side-w) 1fr;
            transition: grid-template-columns .28s ease;
        }

        .sidebar {
            background: #fff;
            border-right: 1px solid var(--soft-border);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }

        .side-inner {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 18px;
            gap: 14px;
        }

        .side-head {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 18px;
            background: rgba(13, 110, 253, .06);
            border: 1px solid rgba(13, 110, 253, .10);
        }

        .brand-badge {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: rgba(13, 110, 253, .12);
            border: 1px solid rgba(13, 110, 253, .18);
            display: grid;
            place-items: center;
            flex: 0 0 auto;
        }

        .brand-icon {
            width: 26px;
            height: 26px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-weight: 900;
            background: #0d6efd;
            color: #fff;
            line-height: 1;
        }

        .brand-title {
            font-weight: 900;
            letter-spacing: -.02em;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: .88rem;
            color: var(--muted);
            line-height: 1.1;
        }

        .side-nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 12px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 900;
            color: #111827;
            border: 1px solid var(--soft-border);
            background: #fff;
            transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
        }

        .nav-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 50px rgba(0, 0, 0, .08);
        }

        .nav-item.active {
            background: var(--blue-soft);
            border-color: var(--blue-border);
            color: #0d6efd;
        }

        .nav-danger {
            color: #dc3545;
            background: rgba(220, 53, 69, .06);
            border-color: rgba(220, 53, 69, .14);
        }

        .nav-ic {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(0, 0, 0, .04);
            border: 1px solid rgba(0, 0, 0, .06);
            font-weight: 900;
            flex: 0 0 auto;
        }

        .nav-item.active .nav-ic {
            background: rgba(13, 110, 253, .12);
            border-color: rgba(13, 110, 253, .18);
            color: #0d6efd;
        }

        .side-foot {
            margin-top: auto;
            padding: 12px;
            border-radius: 18px;
            background: rgba(0, 0, 0, .04);
            border: 1px solid var(--soft-border);
        }

        .status-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            color: #111827;
        }

        .status-text {
            color: var(--muted);
            font-weight: 800;
        }

        .green-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: var(--green);
            box-shadow: 0 0 0 7px rgba(34, 197, 94, .16);
            display: inline-block;
        }

        .main {
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(13, 110, 253, .03), transparent 220px);
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: rgba(248, 249, 250, .92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--soft-border);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .top-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .menu-btn {
            border-radius: 14px;
            font-weight: 900;
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border: 1px solid var(--soft-border);
            box-shadow: 0 12px 40px rgba(0, 0, 0, .06);
        }

        .top-titlewrap {
            min-width: 0;
        }

        .top-kicker {
            letter-spacing: .22em;
            font-weight: 900;
            font-size: .78rem;
            color: var(--muted);
            margin-bottom: 2px;
        }

        .top-title {
            font-weight: 900;
            letter-spacing: -.03em;
            font-size: clamp(18px, 2.3vw, 28px);
            line-height: 1.1;
        }

        .status-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--soft-border);
            font-weight: 900;
            box-shadow: 0 12px 40px rgba(0, 0, 0, .06);
        }

        .content {
            overflow: auto;
        }

        .stat-card {
            background: #fff;
            border: 1px solid var(--soft-border);
            border-radius: var(--radius-2xl);
            box-shadow: var(--soft-shadow);
            padding: 18px;
        }

        .stat-label {
            color: var(--muted);
            font-weight: 900;
            letter-spacing: .18em;
            font-size: .72rem;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-value {
            font-weight: 900;
            letter-spacing: -.03em;
            font-size: clamp(30px, 4vw, 44px);
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .stat-sub {
            color: var(--muted);
            font-weight: 700;
        }

        .table-card {
            border-radius: var(--radius-2xl);
            border: 1px solid var(--soft-border);
            box-shadow: var(--soft-shadow);
            overflow: hidden;
        }

        .section-title {
            font-weight: 900;
            letter-spacing: -.03em;
            font-size: clamp(18px, 2.2vw, 24px);
        }

        .section-subtitle {
            color: var(--muted);
            font-weight: 700;
        }

        .input-soft {
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, .10);
            background: var(--bg-soft);
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .input-soft:focus {
            background: #fff;
            border-color: rgba(13, 110, 253, .60);
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .14);
        }

        .search-wrap {
            position: relative;
            min-width: min(420px, 78vw);
        }

        .search-input {
            padding-left: 46px;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            opacity: .6;
            font-weight: 900;
        }

        .soft-table {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--soft-border);
            background: #fff;
        }

        .table thead th {
            background: rgba(13, 110, 253, .06);
            border-bottom: 1px solid var(--soft-border);
            font-weight: 900;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            z-index: 1040;
        }

        /* Collapsed: desktop behaves like Hostinger (content spans full width) */
        body.sidebar-collapsed .app {
            grid-template-columns: 0 1fr;
        }

        body.sidebar-collapsed .sidebar {
            width: 0;
            border-right: 0;
        }

        body.sidebar-collapsed .sidebar .side-inner {
            opacity: 0;
            pointer-events: none;
        }

        /* Mobile: sidebar overlays, main always full width */
        @media (max-width: 991.98px) {
            .app {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                width: min(var(--side-w), 88vw);
                z-index: 1050;
                transform: translateX(-102%);
                transition: transform .28s ease;
                box-shadow: 0 40px 120px rgba(0, 0, 0, .18);
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .search-wrap {
                min-width: 100%;
            }
        }
    </style>

    <script>
        const toggleBtn = document.getElementById("toggleBtn");
        const overlay = document.getElementById("overlay");

        function isMobile() {
            return window.matchMedia("(max-width: 991.98px)").matches;
        }

        function openMobileSidebar() {
            document.body.classList.add("sidebar-open");
            overlay.classList.remove("d-none");
        }

        function closeMobileSidebar() {
            document.body.classList.remove("sidebar-open");
            overlay.classList.add("d-none");
        }

        function toggleSidebar() {
            if (isMobile()) {
                if (document.body.classList.contains("sidebar-open")) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            } else {
                document.body.classList.toggle("sidebar-collapsed");
            }
        }

        toggleBtn.addEventListener("click", toggleSidebar);
        overlay.addEventListener("click", closeMobileSidebar);

        window.addEventListener("resize", () => {
            if (!isMobile()) closeMobileSidebar();
        });
    </script>

</body>

</html>