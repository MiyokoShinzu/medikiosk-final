<?php $title = "MediKiosk Admin"; ?>
<?php include 'globals/kiosk_header.php'; ?>

<body class="bg-light min-vh-100">

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
                            <div class="stat-value"><?php include "src/connection.php"
                                ;
                                $result = $mysqli->query("SELECT COUNT(*) AS count FROM kiosk_table where account_id = $_SESSION[user_id]");
                                $row = $result->fetch_assoc();
                                echo $row['count'];
                            ?></div>
                            <div class="stat-sub">Registered kiosks</div>
                        </div>
                    </div>
                </div>

                <div class="card table-card">
                    <div class="card-body p-3 p-sm-4 p-lg-5">
                        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-3">
                            <div>
                                <h3 class="section-title mb-1">Kiosk Table</h3>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="kioskTable" class="table align-middle mb-0 w-100">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Actions</th>
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

    <!-- ADD KIOSK MODAL (ADDED) -->
    <div class="modal fade" id="add_kiosk_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Kiosk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="addKioskAlert" class="alert alert-danger d-none mb-3"></div>

                    <div class="mb-3">
                        <label class="form-label">Username (must start with K-)</label>
                        <input id="k_username" class="form-control" placeholder="K-0001">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input id="k_password" type="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input id="k_name" class="form-control" placeholder="Kiosk Name">
                    </div>

                  

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input id="k_address" class="form-control" placeholder="Address">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button id="btnAddKiosk" class="btn btn-primary">Save</button>
                </div>

            </div>
        </div>
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
            height: 100vh;
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
        }

        .section-title {
            font-weight: 900;
            letter-spacing: -.03em;
            font-size: clamp(18px, 2.2vw, 24px);
        }

        .soft-table {
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--soft-border);
            background: #fff;
            width: 100%;
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

        body.sidebar-collapsed .sidebar .side-inner {
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

        .dataTables_wrapper .table {
            margin-bottom: 0 !important;
        }

        .dataTables_wrapper .pagination {
            margin-top: 14px;
        }

        .dataTables_scrollHeadInner,
        .dataTables_scrollHeadInner table,
        .dataTables_scrollBody table {
            width: 100% !important;
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
                if (e.target.classList && e.target.classList.contains('app')) {
                    fixDT();
                }
            });

            window.addEventListener('resize', () => {
                fixDT();
            });

            // ---- ADDED: reusable function to reload table without changing your code structure ----
            function reloadKiosks() {
                return fetch('api/select_kiosk.php')
                    .then(res => res.json())
                    .then(data => {
                        var text = "";
                        data.forEach(item => {
                            text += `
                              <tr data-id="${item.id}">
                                <td class="text-center" data-field="username">${item.username}</td>
                                <td class="text-center" data-field="name">${item.name}</td>
                                <td class="text-center" data-field="address">${item.address}</td>
                                <td class="text-center">
                                <button class="btn btn-sm btn-primary btn-edit"><i class="bi bi-pencil-square" title="Edit Kiosk"></i></button>
                                <button class="btn btn-sm btn-success btn-save d-none"><i class="bi bi-check-lg"></i></button>
                                <button class="btn btn-sm btn-secondary btn-cancel d-none ms-1"><i class="bi bi-x-lg"></i></button>
                                <a href="medicine.php?kiosk_id=${item.id}&kiosk_name=${item.name}" class="btn btn-sm btn-warning btn-view ms-1"><i class="bi bi-prescription2" title="Manage Medicines"></i></a>
                                  <button class="btn btn-sm btn-danger btn-delete ms-1"><i class="bi bi-trash" title="Delete Kiosk"></i></button>

                                </td>
                              </tr>
                            `;
                        });

                        $('#kioskTable tbody').html(text);

                        if (dt) dt.destroy();

                        dt = $('#kioskTable').DataTable({
                            dom: 'Bfltip',
                            responsive: true,
                            buttons: [{
                                    text: 'Add Kiosk',
                                    className: 'add_kiosk',
                                    attr: {
                                        'data-bs-toggle': 'modal',
                                        'data-bs-target': '#add_kiosk_modal'
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
                                    extend: 'print',
                                    text: 'Print',
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

                        fixDT();
                    });
            }
            // ---- END ADDED ----

            // ---- CHANGED MINIMALLY: replace your initial fetch with reloadKiosks() call ----
            reloadKiosks().catch(err => console.error(err));
            // ---- END ----

            $('#kioskTable tbody').on('click', '.btn-edit', function() {
                const $tr = $(this).closest('tr');
                $tr.find('td[data-field]').each(function() {
                    const val = $(this).text().trim();
                    $(this).attr('data-old', val);
                    $(this).html(`<input class="form-control form-control-sm" value="${val}">`);
                });
                $tr.find('.btn-edit').addClass('d-none');
                $tr.find('.btn-save, .btn-cancel').removeClass('d-none');
                fixDT();

            });

            $('#kioskTable tbody').on('click', '.btn-cancel', function() {
                const $tr = $(this).closest('tr');
                $tr.find('td[data-field]').each(function() {
                    $(this).text($(this).attr('data-old'));
                });
                $tr.find('.btn-edit').removeClass('d-none');
                $tr.find('.btn-save, .btn-cancel').addClass('d-none');
                fixDT();

            });

            $('#kioskTable tbody').on('click', '.btn-save', function() {
                const $tr = $(this).closest('tr');
                const id = $tr.data('id');

                const payload = {
                    id: id
                };

                $tr.find('td[data-field]').each(function() {
                    const field = $(this).data('field');
                    const value = $(this).find('input').val();
                    payload[field] = value;
                });

                fetch('api/update_kiosk.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (!resp.success) throw new Error(resp.message || 'Update failed');

                        $tr.find('td[data-field]').each(function() {
                            const value = $(this).find('input').val();
                            $(this).text(value);
                        });


                        $tr.find('.btn-edit').removeClass('d-none');
                        $tr.find('.btn-save, .btn-cancel').addClass('d-none');
                        fixDT();
                        alert("Kiosk Updated Successfully");
                        location.reload();
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to update. Check console.');
                    });
            });
            $('#kioskTable tbody').on('click', '.btn-delete', function() {
                const $tr = $(this).closest('tr');
                const id = $tr.data('id');

                if (!confirm('Delete this kiosk?')) return;

                fetch('api/delete_kiosk.php?id=' + encodeURIComponent(id))
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.success !== '1') {
                            alert(resp.message || 'Delete failed');
                            return;
                        }
                        alert('Kiosk deleted');
                        location.reload();
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Delete failed. Check console.');
                    });
            });


            function showAddErr(msg) {
                $('#addKioskAlert').removeClass('d-none').text(msg);
            }

            function clearAddErr() {
                $('#addKioskAlert').addClass('d-none').text('');
            }

            $('#btnAddKiosk').on('click', function() {
                clearAddErr();

                const username = $('#k_username').val().trim();
                const password = $('#k_password').val().trim();
                const name = $('#k_name').val().trim();
                const address = $('#k_address').val().trim();

                if (!username || !password || !name || !address) {
                    showAddErr('Missing required fields');
                    return;
                }

                const params = new URLSearchParams({
                    username,
                    password,
                    name,
                    address
                });

                fetch('api/insert_kiosk.php?' + params.toString())
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.success !== '1') {
                            showAddErr(resp.message || 'Insert failed');
                            return;
                        }

                        $('#k_username').val('');
                        $('#k_password').val('');
                        $('#k_name').val('');
                  
                        $('#k_address').val('');

                        const modalEl = document.getElementById('add_kiosk_modal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                        alert("Kiosk Inserted Successfully");
                        location.reload();
                    })
                    .catch(err => {
                        console.error(err);
                        showAddErr('Insert failed. Check console.');
                    });
            });
          

        });
    </script>

</body>

</html>