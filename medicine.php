<?php
$title = "MediKiosk Admin";

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $kiosk_id = $_GET['kiosk_id'] ?? '';
    $kiosk_name = $_GET['kiosk_name'] ?? '';

    $_SESSION['kiosk_id'] = $kiosk_id;

    if (!$kiosk_id || !$kiosk_name) {
        echo "Invalid Kiosk";
        exit;
    }
}

$kiosk_id = (int)($_SESSION['kiosk_id'] ?? 0);
?>
<?php include 'globals/medicine_header.php'; ?>

<body class="bg-light min-vh-100">
    <div class="app">

        <?php include "globals/medicine_sidebar.php"; ?>

        <div id="overlay" class="overlay d-none"></div>

        <main id="main" class="main">

            <?php include "globals/medicine_topbar.php"; ?>

            <section class="content container-fluid px-3 px-sm-4 px-lg-5 py-4">

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <div class="stat-card">
                            <div class="stat-label">Total Medicines</div>
                            <div class="stat-value">
                                <?php
                                include "src/connection.php";
                                $result = $mysqli->query("SELECT COUNT(*) AS count FROM medicines WHERE kiosk_id = $kiosk_id");
                                $row = $result->fetch_assoc();
                                echo (int)$row['count'];
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="stat-card">
                            <div class="stat-label">Available Medicines</div>
                            <div class="stat-value">
                                <?php
                                include "src/connection.php";
                                $result = $mysqli->query("SELECT COUNT(*) AS count FROM medicines WHERE kiosk_id = $kiosk_id AND availability = 1");
                                $row = $result->fetch_assoc();
                                echo (int)$row['count'];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card table-card">
                    <div class="card-body p-3 p-sm-4 p-lg-5">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
                            <div>
                                <h3 class="section-title mb-1">Medicines</h3>
                                <div class="text-muted">Kiosk ID: <?php echo htmlspecialchars((string)$kiosk_id); ?></div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="medicineTable" class="table table-striped table-bordered align-middle mb-0 w-100">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th style="width:80px;">Image</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Unit</th>
                                        <th style="width:130px;">Availability</th>
                                        <th style="width:140px;">Prescription</th>
                                        <th>Notes</th>
                                        <th style="width:160px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </section>

        </main>
    </div>

    <!-- ✅ ADD MEDICINE MODAL -->
    <div class="modal fade" id="add_medicine_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="addMedicineForm" class="modal-content" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Medicine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div id="addMedicineAlert" class="alert alert-danger d-none mb-3"></div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Name *</label>
                            <input name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Brand</label>
                            <input name="brand" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category" class="form-select">
                                <option value="">-- Select Category --</option>
                                <option value="Pain &amp; Fever">Pain &amp; Fever</option>
                                <option value="Cough &amp; Cold">Cough &amp; Cold</option>
                                <option value="Allergy">Allergy</option>
                                <option value="Antibiotic">Antibiotic</option>
                                <option value="Stomach &amp; Digestion">Stomach &amp; Digestion</option>
                                <option value="Vitamins &amp; Supplements">Vitamins &amp; Supplements</option>
                                <option value="Skin Care">Skin Care</option>
                                <option value="First Aid">First Aid</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Unit</label>
                            <input name="unit" class="form-control" placeholder="Tablet / Capsule / Syrup">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Availability *</label>
                            <select name="availability" class="form-select" required>
                                <option value="1">Available</option>
                                <option value="0">Out of Stock</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Prescription *</label>
                            <select name="prescription" class="form-select" required>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Notes</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Image (optional)</label>
                            <input name="image" type="file" class="form-control" accept="image/*">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button id="btnSaveMedicine" type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ VIEW MEDICINE MODAL (Click image to open) -->
    <div class="modal fade" id="view_medicine_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Medicine Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            <img id="vm_image" src="assets/img/no-image.png"
                                style="width:160px;height:160px;object-fit:cover;border-radius:12px;border:1px solid rgba(0,0,0,.08);">
                        </div>

                        <div class="col-md-8">
                            <div class="mb-2"><strong>Name:</strong> <span id="vm_name"></span></div>
                            <div class="mb-2"><strong>Brand:</strong> <span id="vm_brand"></span></div>
                            <div class="mb-2"><strong>Category:</strong> <span id="vm_category"></span></div>
                            <div class="mb-2"><strong>Unit:</strong> <span id="vm_unit"></span></div>
                            <div class="mb-2"><strong>Availability:</strong> <span id="vm_availability"></span></div>
                            <div class="mb-2"><strong>Prescription:</strong> <span id="vm_prescription"></span></div>

                            <div class="mt-3">
                                <strong>Notes:</strong>
                                <div id="vm_notes" class="p-2 rounded-3"
                                    style="background: rgba(0,0,0,.04); border:1px solid rgba(0,0,0,.06); white-space:pre-wrap;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <?php include 'globals/scripts.php'; ?>

    <style>
        /* your CSS unchanged */
        :root {
            --side-w: 280px;
            --radius-2xl: 22px;
            --soft-border: rgba(0, 0, 0, .06);
            --soft-shadow: 0 26px 90px rgba(0, 0, 0, .10);
            --muted: #6c757d;
            --blue-soft: rgba(13, 110, 253, .10);
            --blue-border: rgba(13, 110, 253, .16);
            --green: #22c55e;
        }

        html,
        body {
            height: 100%;
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

        /* Sidebar components */
        .side-inner {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 18px;
            gap: 14px;
            overflow-x: hidden;
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
            overflow: hidden;
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

        .main {
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(13, 110, 253, .03), transparent 220px);
            height: 100vh;
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

        body.sidebar-collapsed .app {
            grid-template-columns: 0 1fr;
        }

        body.sidebar-collapsed .sidebar {
            width: 0;
            border-right: 0;
        }

        body.sidebar-collapsed .sidebar * {
            opacity: 0;
            pointer-events: none;
        }

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
        }

        .dataTables_wrapper {
            width: 100%;
        }

        .dataTables_scrollHeadInner,
        .dataTables_scrollHeadInner table,
        .dataTables_scrollBody table {
            width: 100% !important;
        }

        /* ✅ Ellipsis for table cells (single-line) */
        #medicineTable td {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Keep image + actions not truncated */
        #medicineTable td:first-child,
        #medicineTable td:last-child {
            max-width: none;
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
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
                document.body.classList.contains("sidebar-open") ? closeMobileSidebar() : openMobileSidebar();
            } else {
                document.body.classList.toggle("sidebar-collapsed");
            }
        }
        if (toggleBtn) toggleBtn.addEventListener("click", toggleSidebar);
        overlay.addEventListener("click", closeMobileSidebar);
        window.addEventListener("resize", () => {
            if (!isMobile()) closeMobileSidebar();
        });
    </script>

    <script>
        $(document).ready(function() {
            let dt;

            function fixDT() {
                dt.columns.adjust().draw(false);
                if (!dt) return;
                dt.columns.adjust();
                if (dt.responsive) dt.responsive.recalc();
                setTimeout(() => {
                    dt.columns.adjust();
                    if (dt.responsive) dt.responsive.recalc();
                    dt.draw(false);
                }, 0);
            }

            document.addEventListener('transitionend', (e) => {
                if (e.target.classList && e.target.classList.contains('app')) fixDT();
            });
            window.addEventListener('resize', () => fixDT());

            function availabilityBadge(val) {
                return (String(val) === "1") ?
                    '<span class="badge bg-success">Available</span>' :
                    '<span class="badge bg-danger">Out of Stock</span>';
            }

            function initTooltips() {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    if (el._tooltipInstance) return;
                    el._tooltipInstance = new bootstrap.Tooltip(el);
                });
            }

            function showAddErr(msg) {
                $('#addMedicineAlert').removeClass('d-none').text(msg);
            }

            function clearAddErr() {
                $('#addMedicineAlert').addClass('d-none').text('');
            }

            function reloadMedicines() {
                return fetch('api/select_medicine.php')
                    .then(res => res.json())
                    .then(data => {
                        let text = "";

                        data.forEach(item => {
                            const imgSrc = item.image ? item.image : "assets/img/no-image.png";
                            text += `
<tr data-id="${item.id}">
  <td class="text-center" data-field="image">
    <img
      src="${imgSrc}"
      alt="medicine"
      class="med-img-click"
      style="width:45px;height:45px;object-fit:cover;border-radius:6px;cursor:pointer;"
      data-img="${imgSrc}"
      data-name="${(item.name ?? '').replace(/"/g,'&quot;')}"
      data-brand="${(item.brand ?? '').replace(/"/g,'&quot;')}"
      data-category="${(item.category ?? '').replace(/"/g,'&quot;')}"
      data-unit="${(item.unit ?? '').replace(/"/g,'&quot;')}"
      data-availability="${item.availability ?? 0}"
      data-prescription="${(item.prescription ?? 'No').replace(/"/g,'&quot;')}"
      data-notes="${(item.notes ?? '').replace(/"/g,'&quot;')}"
    >
  </td>

  <td class="text-center" data-field="name">${item.name ?? ""}</td>
  <td class="text-center" data-field="brand">${item.brand ?? ""}</td>
  <td class="text-center" data-field="category">${item.category ?? ""}</td>
  <td class="text-center" data-field="unit">${item.unit ?? ""}</td>

  <td class="text-center" data-field="availability" data-value="${item.availability ?? 0}">
    ${availabilityBadge(item.availability)}
  </td>

  <td class="text-center" data-field="prescription" data-value="${item.prescription ?? "No"}">
    ${item.prescription ?? ""}
  </td>

  <td class="text-center" data-field="notes">${item.notes ?? ""}</td>

  <td class="text-center">
    <button class="btn btn-sm btn-outline-primary btn-edit" data-bs-toggle="tooltip" title="Edit">
      <i class="bi bi-pencil-square"></i>
    </button>
    <button class="btn btn-sm btn-outline-success btn-save d-none" data-bs-toggle="tooltip"><i class="bi bi-check-lg"></i></button>
    <button class="btn btn-sm btn-outline-secondary btn-cancel d-none ms-1" data-bs-toggle="tooltip" title="Cancel"><i class="bi bi-x-lg"></i></button>
    <button class="btn btn-sm btn-outline-danger btn-delete ms-1" data-bs-toggle="tooltip" title="Delete">
      <i class="bi bi-trash"></i>
    </button>
  </td>
</tr>`;
                        });

                        $('#medicineTable tbody').html(text);

                        if (dt) dt.destroy();

                        dt = $('#medicineTable').DataTable({
                            dom: 'Bfltip',
                            responsive: false,
                            buttons: [{
                                    text: 'Add Medicine',
                                    className: 'add_medicine btn btn-primary',
                                    action: function() {
                                        const modal = new bootstrap.Modal(document.getElementById('add_medicine_modal'));
                                        modal.show();
                                    }
                                },
                                {
                                    extend: 'excel',
                                    text: 'Excel',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: 'PDF',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'colvis',
                                    text: 'Show/Hide Columns'
                                }
                            ],
                            fixedHeader: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            scrollY: '300px',
                            colReorder: true,
                            scrollCollapse: true,
                            language: {
                                search: 'Search:'
                            }
                        });

                        initTooltips();
                        fixDT();
                    });
            }

            // Initial load
            reloadMedicines().catch(console.error);

            // ADD medicine
            $('#addMedicineForm').on('submit', function(e) {
                e.preventDefault();
                clearAddErr();

                const form = document.getElementById('addMedicineForm');
                const fd = new FormData(form);

                fetch('api/insert_medicine.php', {
                        method: 'POST',
                        body: fd
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (!(resp.success == 1 || resp.success === "1" || resp.success === true)) {
                            showAddErr(resp.message || "Insert failed");
                            return;
                        }
                        form.reset();
                        const modalEl = document.getElementById('add_medicine_modal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();

                        reloadMedicines();
                        alert("Medicine added successfully");
                        location.reload();
                    })
                    .catch(err => {
                        console.error(err);
                        showAddErr("Insert failed. Check console.");
                    });
            });

            // EDIT (✅ category dropdown, ✅ prescription dropdown, ✅ notes textarea)
            $('#medicineTable tbody').on('click', '.btn-edit', function() {
                const $tr = $(this).closest('tr');

                $tr.find('td[data-field]').each(function() {
                    const field = $(this).data('field');

                    if (field === 'image') return;

                    if (field === 'availability') {
                        const oldVal = $(this).attr('data-value') ?? "0";
                        $(this).attr('data-old', oldVal);
                        $(this).html(`
<select class="form-select form-select-sm">
  <option value="1" ${oldVal=="1" ? "selected" : ""}>Available</option>
  <option value="0" ${oldVal=="0" ? "selected" : ""}>Out of Stock</option>
</select>`);
                        return;
                    }

                    if (field === 'prescription') {
                        const oldVal = ($(this).attr('data-value') ?? $(this).text().trim() ?? "No");
                        $(this).attr('data-old', oldVal);
                        $(this).html(`
<select class="form-select form-select-sm">
  <option value="No" ${oldVal==="No" ? "selected" : ""}>No</option>
  <option value="Yes" ${oldVal==="Yes" ? "selected" : ""}>Yes</option>
</select>`);
                        return;
                    }

                    if (field === 'notes') {
                        const val = $(this).text().trim();
                        $(this).attr('data-old', val);
                        $(this).html(`<textarea class="form-control form-control-sm" rows="2">${val}</textarea>`);
                        return;
                    }

                    if (field === 'category') {
                        const oldVal = ($(this).text().trim() || "");
                        $(this).attr('data-old', oldVal);
                        $(this).html(`
<select class="form-select form-select-sm">
  <option value="" ${oldVal==="" ? "selected" : ""}>-- Select Category --</option>
  <option value="Pain &amp; Fever" ${oldVal==="Pain & Fever" || oldVal==="Pain &amp; Fever" ? "selected" : ""}>Pain &amp; Fever</option>
  <option value="Cough &amp; Cold" ${oldVal==="Cough & Cold" || oldVal==="Cough &amp; Cold" ? "selected" : ""}>Cough &amp; Cold</option>
  <option value="Allergy" ${oldVal==="Allergy" ? "selected" : ""}>Allergy</option>
  <option value="Antibiotic" ${oldVal==="Antibiotic" ? "selected" : ""}>Antibiotic</option>
  <option value="Stomach &amp; Digestion" ${oldVal==="Stomach & Digestion" || oldVal==="Stomach &amp; Digestion" ? "selected" : ""}>Stomach &amp; Digestion</option>
  <option value="Vitamins &amp; Supplements" ${oldVal==="Vitamins & Supplements" || oldVal==="Vitamins &amp; Supplements" ? "selected" : ""}>Vitamins &amp; Supplements</option>
  <option value="Skin Care" ${oldVal==="Skin Care" ? "selected" : ""}>Skin Care</option>
  <option value="First Aid" ${oldVal==="First Aid" ? "selected" : ""}>First Aid</option>
</select>`);
                        return;
                    }

                    const val = $(this).text().trim();
                    $(this).attr('data-old', val);
                    $(this).html(`<input class="form-control form-control-sm" value="${val}">`);
                });

                $tr.find('.btn-edit').addClass('d-none');
                $tr.find('.btn-save, .btn-cancel').removeClass('d-none');
                fixDT();
            });

            // CANCEL
            $('#medicineTable tbody').on('click', '.btn-cancel', function() {
                const $tr = $(this).closest('tr');

                $tr.find('td[data-field]').each(function() {
                    const field = $(this).data('field');
                    if (field === 'image') return;

                    if (field === 'availability') {
                        const oldVal = $(this).attr('data-old') ?? "0";
                        $(this).attr('data-value', oldVal);
                        $(this).html(availabilityBadge(oldVal));
                        return;
                    }

                    if (field === 'prescription') {
                        const oldVal = $(this).attr('data-old') ?? "No";
                        $(this).attr('data-value', oldVal);
                        $(this).text(oldVal);
                        return;
                    }

                    $(this).text($(this).attr('data-old') ?? "");
                });

                $tr.find('.btn-edit').removeClass('d-none');
                $tr.find('.btn-save, .btn-cancel').addClass('d-none');
                fixDT();
            });

            // SAVE (✅ reads input/select/textarea correctly)
            $('#medicineTable tbody').on('click', '.btn-save', function() {
                const $tr = $(this).closest('tr');
                const id = $tr.data('id');

                const payload = {
                    id
                };

                $tr.find('td[data-field]').each(function() {
                    const field = $(this).data('field');
                    if (field === 'image') return;

                    if (field === 'availability') payload[field] = $(this).find('select').val();
                    else if (field === 'prescription') payload[field] = $(this).find('select').val();
                    else if (field === 'category') payload[field] = $(this).find('select').val();
                    else if (field === 'notes') payload[field] = $(this).find('textarea').val();
                    else payload[field] = $(this).find('input').val();
                });

                fetch('api/update_medicine.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (!(resp.success == 1 || resp.success === "1" || resp.success === true)) {
                            throw new Error(resp.message || "Update failed");
                        }

                        $tr.find('td[data-field]').each(function() {
                            const field = $(this).data('field');
                            if (field === 'image') return;

                            if (field === 'availability') {
                                const v = payload.availability ?? "0";
                                $(this).attr('data-value', v);
                                $(this).html(availabilityBadge(v));
                            } else if (field === 'prescription') {
                                const v = payload.prescription ?? "No";
                                $(this).attr('data-value', v);
                                $(this).text(v);
                            } else {
                                $(this).text(payload[field] ?? "");
                            }
                        });

                        $tr.find('.btn-edit').removeClass('d-none');
                        $tr.find('.btn-save, .btn-cancel').addClass('d-none');
                        fixDT();
                        alert("Medicine Updated Successfully");
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Failed to update medicine. Check console.");
                    });
            });

            // DELETE
            $('#medicineTable tbody').on('click', '.btn-delete', function() {
                const $tr = $(this).closest('tr');
                const id = $tr.data('id');

                if (!confirm("Delete this medicine?")) return;

                fetch('api/delete_medicine.php?id=' + encodeURIComponent(id))
                    .then(res => res.json())
                    .then(resp => {
                        if (!(resp.success == 1 || resp.success === "1" || resp.success === true)) {
                            alert(resp.message || "Delete failed");
                            return;
                        }
                        if (dt) dt.row($tr).remove().draw(false);
                        alert("Medicine deleted");
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Delete failed. Check console.");
                    });
            });

            // ✅ CLICK IMAGE -> OPEN DETAILS MODAL
            $('#medicineTable tbody').on('click', '.med-img-click', function() {
                const img = $(this);

                const imgSrc = img.data('img') || "assets/img/no-image.png";
                const name = img.data('name') || "";
                const brand = img.data('brand') || "";
                const category = img.data('category') || "";
                const unit = img.data('unit') || "";
                const availability = String(img.data('availability') ?? "0");
                const prescription = img.data('prescription') || "No";
                const notes = img.data('notes') || "";

                $('#vm_image').attr('src', imgSrc);
                $('#vm_name').text(name);
                $('#vm_brand').text(brand);
                $('#vm_category').text(category);
                $('#vm_unit').text(unit);

                $('#vm_availability').html(
                    availability === "1" ?
                    '<span class="badge bg-success">Available</span>' :
                    '<span class="badge bg-danger">Out of Stock</span>'
                );

                $('#vm_prescription').html(
                    prescription === "Yes" ?
                    '<span class="badge bg-warning text-dark">Yes</span>' :
                    '<span class="badge bg-secondary">No</span>'
                );

                $('#vm_notes').text(notes);

                const modal = new bootstrap.Modal(document.getElementById('view_medicine_modal'));
                modal.show();
            });

        });
    </script>

</body>

</html>