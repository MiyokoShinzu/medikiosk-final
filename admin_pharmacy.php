<?php $title = "MediKiosk Admin"; ?>
<?php include 'globals/head.php'; ?>

<body class="bg-light min-vh-100">

    <div class="kiosk-shell">

        <header class="kiosk-topbar">
            <div class="topbar-left">
                <div class="brand-mini">
                    <div class="brand-mini-title">MediKiosk</div>
                    <div class="brand-mini-subtitle">Admin • Pharmacies</div>
                </div>
            </div>

            <div class="topbar-center d-none d-md-flex">
                <div class="status-pill">
                    <span id="dateTime">--</span>
                </div>
            </div>

            <div class="topbar-right">
                <a href="dashboard.php" class="btn btn-sm btn-outline-primary topbar-btn" aria-label="Back" title="Back">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <a href="logout.php" class="btn btn-sm btn-secondary topbar-btn" aria-label="Logout" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </header>

        <main class="kiosk-main container-fluid px-3 px-sm-4 px-lg-5 py-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card kiosk-card">
                        <div class="card-body p-3 p-sm-4 d-flex flex-column">

                            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 mb-3 flex-shrink-0">
                                <div>
                                    <div class="kiosk-kicker mb-1">Management</div>
                                    <div class="kiosk-h2 mb-0">Pharmacies Directory</div>
                                </div>

                                <div class="d-flex flex-column flex-md-row gap-2 w-100 w-lg-auto">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text input-soft-addon">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input id="qSearch" type="text" class="form-control form-control-sm input-soft input-soft-left"
                                            placeholder="Search name, address, phone">
                                    </div>

                                    <div class="select-wrap">
                                        <select id="qStatus" class="form-select form-select-sm input-soft select-soft">
                                            <option value="">All status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <span class="select-ico"><i class="bi bi-chevron-down"></i></span>
                                    </div>

                                    <button id="btnAdd" class="btn btn-primary btn-sm rounded-4 px-3">
                                        <i class="bi bi-plus-lg me-1"></i> Add
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-shrink-0">
                                <div class="small text-muted">
                                    Add, edit, or deactivate pharmacies using AJAX.
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span id="rowCount" class="badge text-bg-light border fw-bold" style="border-color:rgba(0,0,0,.08)!important;">0</span>
                                    <button id="btnRefresh" class="btn btn-outline-secondary btn-sm rounded-4 px-3">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                                    </button>
                                </div>
                            </div>

                            <div class="table-shell flex-grow-1">
                                <div class="table-responsive table-scroll">
                                    <table class="table table-sm align-middle mb-0">
                                        <thead class="table-head sticky-top">
                                            <tr>
                                                <th style="min-width:70px;">ID</th>
                                                <th style="min-width:220px;">Pharmacy</th>
                                                <th style="min-width:260px;">Address</th>
                                                <th style="min-width:160px;">Phone</th>
                                                <th style="min-width:220px;">Email</th>
                                                <th style="min-width:120px;">Status</th>
                                                <th class="text-end" style="min-width:160px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pharmacyTbody"></tbody>
                                    </table>
                                </div>

                                <div id="emptyState" class="d-none p-4 rounded-4 border bg-white mt-3">
                                    <div class="fw-bold">No pharmacies found</div>
                                    <div class="text-muted">Try changing your search or filters.</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="kiosk-footer px-3 px-sm-4 px-lg-5 py-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <small class="text-muted">© <?php echo date("Y"); ?> MediKiosk</small>
                <small class="text-muted">Admin tools • AJAX CRUD</small>
            </div>
        </footer>

    </div>

    <div class="modal fade" id="pharmacyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-soft">
                <div class="modal-header">
                    <div>
                        <div class="text-uppercase small fw-bold text-muted" style="letter-spacing:.12em;">Pharmacy</div>
                        <h5 class="modal-title fw-bold mb-0" id="modalTitle">Add Pharmacy</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="pharmacyForm">
                    <div class="modal-body">
                        <input type="hidden" id="phId" name="id" value="">
                        <div class="row g-3">
                            <div class="col-12 col-md-7">
                                <label class="form-label small fw-bold text-muted">Pharmacy name</label>
                                <input type="text" class="form-control input-soft" id="phName" name="name" required maxlength="150">
                            </div>

                            <div class="col-12 col-md-5">
                                <label class="form-label small fw-bold text-muted">Status</label>
                                <div class="select-wrap">
                                    <select class="form-select input-soft select-soft" id="phStatus" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <span class="select-ico"><i class="bi bi-chevron-down"></i></span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Address</label>
                                <input type="text" class="form-control input-soft" id="phAddress" name="address" required maxlength="255">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-bold text-muted">Phone</label>
                                <input type="text" class="form-control input-soft" id="phPhone" name="phone" maxlength="60">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-bold text-muted">Email</label>
                                <input type="email" class="form-control input-soft" id="phEmail" name="email" maxlength="120">
                            </div>
                        </div>

                        <div id="formAlert" class="d-none alert alert-danger mt-3 mb-0 rounded-4"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-4 px-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-4 px-3" id="btnSave">
                            <span class="spinner-border spinner-border-sm me-2 d-none" id="saveSpin" aria-hidden="true"></span>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-soft">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold mb-0">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="confirmText" class="fw-semibold"></div>
                    <div class="small text-muted mt-1">You can re-activate later by setting status to Active.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-4 px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-4 px-3" id="btnConfirm">Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'globals/scripts.php'; ?>

    <style>
        html,
        body {
            height: 100%;
        }

        .kiosk-shell {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .kiosk-topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 12px clamp(14px, 4vw, 28px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex: 0 0 auto;
        }

        .kiosk-main {
            flex: 1 1 auto;
            overflow: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 24px;
        }

        .kiosk-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            background: #ffffff;
            flex: 0 0 auto;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            min-width: 160px;
        }

        .topbar-center {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex: 1 1 auto;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            min-width: 160px;
        }

        .brand-mini {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-mini-title {
            font-weight: 900;
            letter-spacing: -0.02em;
        }

        .brand-mini-subtitle {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid rgba(0, 0, 0, 0.06);
            font-weight: 900;
            color: #212529;
            min-width: 190px;
            white-space: nowrap;
        }

        .topbar-btn {
            border-radius: 14px;
            font-weight: 900;
            padding: 8px 12px;
        }

        .kiosk-card {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 22px;
            box-shadow: 0 22px 60px rgba(0, 0, 0, 0.08);
            height: calc(100vh - 140px);
        }

        .kiosk-kicker {
            font-weight: 900;
            color: #6c757d;
            letter-spacing: 0.08em;
            font-size: 0.72rem;
            text-transform: uppercase;
        }

        .kiosk-h2 {
            font-weight: 1000;
            letter-spacing: -0.03em;
            font-size: clamp(18px, 2.4vw, 28px);
            line-height: 1.1;
        }

        .input-soft {
            border-radius: 14px;
            border: 1px solid rgba(0, 0, 0, 0.10);
            background: #f8fafc;
        }

        .input-soft:focus {
            background: #ffffff;
            border-color: rgba(13, 110, 253, 0.55);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
        }

        .input-soft-addon {
            border-radius: 14px 0 0 14px;
            border: 1px solid rgba(0, 0, 0, 0.10);
            background: #f8fafc;
        }

        .input-soft-left {
            border-radius: 0 14px 14px 0;
        }

        .select-wrap {
            position: relative;
        }

        .select-soft {
            padding-right: 36px;
        }

        .select-ico {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .table-shell {
            min-height: 0;
        }

        .table-scroll {
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            max-height: 100%;
        }

        .table-head th {
            background: rgba(248, 250, 252, 0.96);
            border-bottom: 1px solid rgba(0, 0, 0, .06);
            font-weight: 900;
        }

        .table td {
            vertical-align: middle;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 900;
            font-size: 0.78rem;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: #f8fafc;
            color: #212529;
            white-space: nowrap;
        }

        .pill-active {
            background: rgba(25, 135, 84, 0.10);
            border-color: rgba(25, 135, 84, 0.16);
            color: #146c43;
        }

        .pill-inactive {
            background: rgba(220, 53, 69, 0.10);
            border-color: rgba(220, 53, 69, 0.16);
            color: #b02a37;
        }

        .action-btn {
            border-radius: 14px;
            font-weight: 900;
            padding: 6px 10px;
        }

        .modal-soft {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        @media (max-width: 767.98px) {
            .kiosk-card {
                height: calc(100vh - 150px);
            }

            .topbar-right {
                min-width: auto;
            }
        }
    </style>

    <script>
        const dateTimeEl = document.getElementById("dateTime");
        const qSearch = document.getElementById("qSearch");
        const qStatus = document.getElementById("qStatus");
        const btnAdd = document.getElementById("btnAdd");
        const btnRefresh = document.getElementById("btnRefresh");
        const rowCount = document.getElementById("rowCount");
        const tbody = document.getElementById("pharmacyTbody");
        const emptyState = document.getElementById("emptyState");

        const modalEl = document.getElementById("pharmacyModal");
        const modalTitle = document.getElementById("modalTitle");
        const form = document.getElementById("pharmacyForm");
        const formAlert = document.getElementById("formAlert");
        const saveSpin = document.getElementById("saveSpin");

        const phId = document.getElementById("phId");
        const phName = document.getElementById("phName");
        const phAddress = document.getElementById("phAddress");
        const phPhone = document.getElementById("phPhone");
        const phEmail = document.getElementById("phEmail");
        const phStatus = document.getElementById("phStatus");

        const confirmEl = document.getElementById("confirmModal");
        const confirmText = document.getElementById("confirmText");
        const btnConfirm = document.getElementById("btnConfirm");

        const pharmacyModal = (window.bootstrap && bootstrap.Modal) ? new bootstrap.Modal(modalEl) : null;
        const confirmModal = (window.bootstrap && bootstrap.Modal) ? new bootstrap.Modal(confirmEl) : null;

        let cache = [];
        let pendingConfirm = null;

        function pad2(n) {
            return String(n).padStart(2, "0");
        }

        function formatDateTime(d) {
            let h = d.getHours();
            const m = d.getMinutes();
            const ampm = h >= 12 ? "PM" : "AM";
            h = h % 12;
            h = h ? h : 12;
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            const dateStr = `${monthNames[d.getMonth()]} ${pad2(d.getDate())}, ${d.getFullYear()}`;
            const timeStr = `${pad2(h)}:${pad2(m)} ${ampm}`;
            return `${dateStr} • ${timeStr}`;
        }

        function tickDateTime() {
            dateTimeEl.textContent = formatDateTime(new Date());
        }

        tickDateTime();
        setInterval(tickDateTime, 1000);

        async function api(action, payload = {}) {
            const fd = new FormData();
            fd.append("action", action);
            Object.keys(payload).forEach(k => fd.append(k, payload[k]));

            const res = await fetch("pharmacies_api.php", {
                method: "POST",
                body: fd
            });
            const data = await res.json().catch(() => null);
            if (!data || data.ok !== true) {
                const msg = data && data.error ? data.error : "Request failed.";
                throw new Error(msg);
            }
            return data;
        }

        function esc(s) {
            return String(s ?? "")
                .replaceAll("&", "&amp;")
                .replaceAll("<", "&lt;")
                .replaceAll(">", "&gt;")
                .replaceAll('"', "&quot;")
                .replaceAll("'", "&#039;");
        }

        function pillStatus(s) {
            const v = (s || "").toLowerCase() === "active" ? "active" : "inactive";
            const cls = v === "active" ? "pill pill-active" : "pill pill-inactive";
            const label = v === "active" ? "Active" : "Inactive";
            return `<span class="${cls}">${label}</span>`;
        }

        function openAdd() {
            modalTitle.textContent = "Add Pharmacy";
            formAlert.classList.add("d-none");
            form.reset();
            phId.value = "";
            phStatus.value = "active";
            if (pharmacyModal) pharmacyModal.show();
        }

        function openEdit(row) {
            modalTitle.textContent = "Edit Pharmacy";
            formAlert.classList.add("d-none");
            phId.value = row.id;
            phName.value = row.name || "";
            phAddress.value = row.address || "";
            phPhone.value = row.phone || "";
            phEmail.value = row.email || "";
            phStatus.value = (row.status || "active").toLowerCase() === "inactive" ? "inactive" : "active";
            if (pharmacyModal) pharmacyModal.show();
        }

        function confirmToggle(row) {
            pendingConfirm = row;
            const isActive = (row.status || "").toLowerCase() === "active";
            confirmText.textContent = isActive ? `Set "${row.name}" to Inactive?` : `Set "${row.name}" to Active?`;
            btnConfirm.classList.toggle("btn-danger", isActive);
            btnConfirm.classList.toggle("btn-success", !isActive);
            btnConfirm.textContent = isActive ? "Deactivate" : "Activate";
            if (confirmModal) confirmModal.show();
        }

        function applyView() {
            const q = (qSearch.value || "").trim().toLowerCase();
            const st = (qStatus.value || "").trim().toLowerCase();

            let list = cache.slice();

            if (q) {
                list = list.filter(r =>
                    (r.name || "").toLowerCase().includes(q) ||
                    (r.address || "").toLowerCase().includes(q) ||
                    (r.phone || "").toLowerCase().includes(q) ||
                    (r.email || "").toLowerCase().includes(q)
                );
            }

            if (st) list = list.filter(r => (r.status || "").toLowerCase() === st);

            tbody.innerHTML = "";
            rowCount.textContent = String(list.length);

            if (!list.length) {
                emptyState.classList.remove("d-none");
                return;
            }

            emptyState.classList.add("d-none");

            list.forEach(r => {
                const isActive = (r.status || "").toLowerCase() === "active";
                const toggleLabel = isActive ? "Deactivate" : "Activate";
                const toggleBtnClass = isActive ? "btn-outline-danger" : "btn-outline-success";
                const toggleIcon = isActive ? "bi bi-slash-circle" : "bi bi-check-circle";

                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td class="fw-bold">${esc(r.id)}</td>
                    <td><div class="fw-bold">${esc(r.name)}</div></td>
                    <td>${esc(r.address)}</td>
                    <td>${esc(r.phone)}</td>
                    <td>${esc(r.email)}</td>
                    <td>${pillStatus(r.status)}</td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm action-btn btn-edit" type="button" data-id="${esc(r.id)}">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </button>
                            <button class="btn ${toggleBtnClass} btn-sm action-btn btn-toggle" type="button" data-id="${esc(r.id)}">
                                <i class="${toggleIcon} me-1"></i> ${toggleLabel}
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            document.querySelectorAll(".btn-edit").forEach(b => {
                b.addEventListener("click", () => {
                    const id = Number(b.getAttribute("data-id"));
                    const row = cache.find(x => Number(x.id) === id);
                    if (row) openEdit(row);
                });
            });

            document.querySelectorAll(".btn-toggle").forEach(b => {
                b.addEventListener("click", () => {
                    const id = Number(b.getAttribute("data-id"));
                    const row = cache.find(x => Number(x.id) === id);
                    if (row) confirmToggle(row);
                });
            });
        }

        async function load() {
            const data = await api("list");
            cache = data.items || [];
            applyView();
        }

        function setSaving(on) {
            if (on) {
                saveSpin.classList.remove("d-none");
                form.querySelectorAll("input,select,button").forEach(x => x.disabled = true);
            } else {
                saveSpin.classList.add("d-none");
                form.querySelectorAll("input,select,button").forEach(x => x.disabled = false);
            }
        }

        btnAdd.addEventListener("click", openAdd);
        btnRefresh.addEventListener("click", load);
        qSearch.addEventListener("input", applyView);
        qStatus.addEventListener("change", applyView);

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            formAlert.classList.add("d-none");

            const payload = {
                id: phId.value.trim(),
                name: phName.value.trim(),
                address: phAddress.value.trim(),
                phone: phPhone.value.trim(),
                email: phEmail.value.trim(),
                status: phStatus.value.trim()
            };

            try {
                setSaving(true);
                if (payload.id) await api("update", payload);
                else await api("create", payload);

                if (pharmacyModal) pharmacyModal.hide();
                await load();
            } catch (err) {
                formAlert.textContent = err.message || "Save failed.";
                formAlert.classList.remove("d-none");
            } finally {
                setSaving(false);
            }
        });

        btnConfirm.addEventListener("click", async () => {
            if (!pendingConfirm) return;
            try {
                const next = (pendingConfirm.status || "").toLowerCase() === "active" ? "inactive" : "active";
                await api("set_status", {
                    id: pendingConfirm.id,
                    status: next
                });
                pendingConfirm = null;
                if (confirmModal) confirmModal.hide();
                await load();
            } catch (err) {
                pendingConfirm = null;
                if (confirmModal) confirmModal.hide();
            }
        });

        load();
    </script>

</body>

</html>