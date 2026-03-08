<?php
include "src/connection.php";

$countResult = $mysqli->query("SELECT COUNT(*) AS count FROM medicines WHERE availability = 1");
$countRow = $countResult->fetch_assoc();
$totalMedicines = $countRow['count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Finder</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --radius-2xl: 22px;
            --soft-border: rgba(0, 0, 0, .06);
            --soft-shadow: 0 26px 90px rgba(0, 0, 0, .10);
            --muted: #6c757d;
            --blue-soft: rgba(13, 110, 253, .10);
            --blue-border: rgba(13, 110, 253, .16);
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }

        .main {
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(13, 110, 253, .03), transparent 220px);
            min-height: 100vh;
        }

        .content {
            flex: 1 1 auto;
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
            background: #fff;
        }

        .section-title {
            font-weight: 900;
            letter-spacing: -.03em;
            font-size: clamp(18px, 2.2vw, 24px);
        }

        .section-sub {
            color: var(--muted);
            font-weight: 500;
        }

        .medicine-card {
            border: 1px solid var(--soft-border);
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            height: 100%;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .medicine-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 50px rgba(0, 0, 0, .08);
        }

        .medicine-img-wrap {
            height: 220px;
            background: rgba(13, 110, 253, .04);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--soft-border);
        }

        .medicine-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .medicine-placeholder {
            font-size: 44px;
            color: #94a3b8;
        }

        .medicine-body {
            padding: 18px;
        }

        .medicine-name {
            font-size: 1.15rem;
            font-weight: 900;
            letter-spacing: -.02em;
            margin-bottom: 12px;
        }

        .meta-label {
            color: var(--muted);
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .14em;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .meta-value {
            font-size: .96rem;
            font-weight: 500;
            margin-bottom: 12px;
            word-break: break-word;
        }

        .badge-soft {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 700;
        }

        .badge-rx {
            background: rgba(220, 53, 69, .10);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, .12);
        }

        .badge-otc {
            background: rgba(25, 135, 84, .10);
            color: #198754;
            border: 1px solid rgba(25, 135, 84, .12);
        }

        .empty-state {
            border: 1px dashed rgba(0, 0, 0, .10);
            border-radius: 18px;
            padding: 48px 20px;
            text-align: center;
            color: var(--muted);
            background: #fff;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            min-height: 48px;
        }

        .btn {
            border-radius: 14px;
            font-weight: 700;
            min-height: 48px;
        }
    </style>
</head>

<body>
    <header class="kiosk-topbar">
        <div class="topbar-left">
            <div class="brand-mini">
                <div class="brand-mini-title">MediKiosk</div>
                <div class="brand-mini-subtitle">
                    Medicine Availability Search
                </div>
            </div>
        </div>

        <div class="topbar-center d-none d-md-flex">
            <div class="status-pill">
                <i class="bi bi-capsule-pill me-2 text-primary"></i>
                Search Medicine Availability
            </div>
        </div>

        
    </header>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .kiosk-topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            background: linear-gradient(90deg, #ffffff, #f8fbff);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            padding: 14px clamp(16px, 4vw, 32px);
        }

        .topbar-left,
        .topbar-center,
        .topbar-right {
            display: flex;
            align-items: center;
        }

        .brand-mini-title {
            font-weight: 1000;
            font-size: 20px;
            letter-spacing: -0.02em;
            color: #0d6efd;
            line-height: 1.1;
        }

        .brand-mini-subtitle {
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
            line-height: 1.2;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.12), rgba(13, 110, 253, 0.05));
            border: 1px solid rgba(13, 110, 253, 0.15);
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            white-space: nowrap;
        }

        #dateTime {
            font-size: 14px;
            letter-spacing: 0.02em;
            color: #1f2937;
        }

        .topbar-btn {
            border-radius: 16px;
            font-weight: 800;
            padding: 6px 14px;
        }

        @media (max-width: 767.98px) {
            .kiosk-topbar {
                justify-content: space-between;
            }

            .topbar-right {
                margin-left: auto;
            }
        }
    </style>

    <script>
        function updateDateTime() {
            const now = new Date();

            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit'
            };

            const el = document.getElementById('dateTime');
            if (el) {
                el.textContent = now.toLocaleString('en-US', options);
            }
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
    <main class="main">
        <section class="content container-fluid px-3 px-sm-4 px-lg-5 py-4">



            <div class="card table-card">
                <div class="card-body p-3 p-sm-4 p-lg-5">

                    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
                        <div>
                            <h3 class="section-title mb-1">Medicine Finder</h3>
                            <div class="section-sub">Search available medicines and filter by prescription</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-7">
                            <input
                                type="text"
                                id="searchInput"
                                class="form-control"
                                placeholder="Search medicine name">
                        </div>

                        <div class="col-12 col-md-3">
                            <select id="prescriptionFilter" class="form-select">
                                <option value="">All Medicines</option>
                                <option value="Yes">Prescription Required Only</option>
                                <option value="No">No Prescription Required</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-2">
                            <button id="searchBtn" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                        </div>
                    </div>

                    <div class="row g-4" id="medicineContainer"></div>

                </div>
            </div>

        </section>
    </main>

    <script>
        const medicineContainer = document.getElementById('medicineContainer');
        const searchInput = document.getElementById('searchInput');
        const prescriptionFilter = document.getElementById('prescriptionFilter');
        const searchBtn = document.getElementById('searchBtn');

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.innerText = text ?? '';
            return div.innerHTML;
        }

        function renderMedicines(data) {
            let html = '';

            if (!Array.isArray(data) || data.length === 0) {
                html = `
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-search fs-1 d-block mb-3"></i>
                            <h4 class="mb-2">No medicines found</h4>
                            <p class="mb-0">Try another search keyword or prescription filter.</p>
                        </div>
                    </div>
                `;
                medicineContainer.innerHTML = html;
                return;
            }

            data.forEach(item => {
                const badge =
                    item.m_prescription === "Yes" ?
                    `<span class="badge-soft badge-rx">Prescription Required</span>` :
                    `<span class="badge-soft badge-otc">No Prescription</span>`;

                const imagePart =
                    item.file_path && item.file_path.trim() !== '' ?
                    `<img src="${escapeHtml(item.file_path)}" alt="${escapeHtml(item.m_name)}" class="medicine-img">` :
                    `<div class="medicine-placeholder"><i class="bi bi-capsule-pill"></i></div>`;

                html += `
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="medicine-card">
                            <div class="medicine-img-wrap">
                                ${imagePart}
                            </div>

                            <div class="medicine-body">
                                <div class="medicine-name">${escapeHtml(item.m_name)}</div>

                                <div class="meta-label">Brand</div>
                                <div class="meta-value">${escapeHtml(item.m_brand)}</div>

                                <div class="meta-label">Prescription</div>
                                <div class="meta-value">${badge}</div>

                                <div class="meta-label">Kiosk Name</div>
                                <div class="meta-value">${escapeHtml(item.k_name)}</div>

                                <div class="meta-label">Kiosk Address</div>
                                <div class="meta-value">${escapeHtml(item.k_address)}</div>

                                <div class="meta-label">Pharmacy Username</div>
                                <div class="meta-value mb-0">${escapeHtml(item.u_name)}</div>
                            </div>
                        </div>
                    </div>
                `;
            });

            medicineContainer.innerHTML = html;
        }

        function loadMedicines() {
            const search = searchInput.value.trim();
            const prescription = prescriptionFilter.value;

            fetch('api/search_medicine.php?search=' + encodeURIComponent(search) + '&prescription=' + encodeURIComponent(prescription))
                .then(response => response.json())
                .then(data => {
                    renderMedicines(data);
                })
                .catch(error => {
                    console.error(error);
                    medicineContainer.innerHTML = `
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="bi bi-exclamation-circle fs-1 d-block mb-3"></i>
                                <h4 class="mb-2">Failed to load medicines</h4>
                                <p class="mb-0">Please check your API file and database connection.</p>
                            </div>
                        </div>
                    `;
                });
        }

        searchBtn.addEventListener('click', loadMedicines);

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                loadMedicines();
            }
        });

        prescriptionFilter.addEventListener('change', loadMedicines);

        loadMedicines();
    </script>

</body>

</html>