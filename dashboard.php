<?php $title = "PharmaKiosk Dashboard"; ?>
<?php include 'globals/head.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$kiosk_id = (int)($_SESSION['kiosk_id'] ?? 0);
?>
<style>
    .topbar-center {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex: 1 1 auto;
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
</style>

<body class="bg-light min-vh-100">

    <div class="kiosk-shell">
        <?php include "globals/dashboard_header.php"; ?>
        <?php include "globals/dashboard_topbar.php"; ?>

        <main class="kiosk-main container-fluid px-3 px-sm-4 px-lg-5 py-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card kiosk-card">
                        <div class="card-body p-3 p-sm-4 d-flex flex-column">

                            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 mb-3 flex-shrink-0">
                                <div>
                                    <div class="kiosk-kicker mb-1">Medicines</div>
                                    <div class="kiosk-h2 mb-0">Check your meds</div>
                                </div>

                                <div class="filters w-100 w-lg-auto">
                                    <div class="row g-2 align-items-stretch">

                                        <div class="col-12 col-lg-5">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text input-soft-addon">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <input id="qSearch" type="text"
                                                    class="form-control form-control-sm input-soft input-soft-left"
                                                    placeholder="Search medicine name (e.g., Paracetamol)">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-auto">
                                            <div class="select-wrap">
                                                <select id="qCategory" class="form-select form-select-sm input-soft select-soft">
                                                    <option value="">All categories</option>
                                                    <option value="Pain & Fever">Pain & Fever</option>
                                                    <option value="Cough & Cold">Cough & Cold</option>
                                                    <option value="Allergy">Allergy</option>
                                                    <option value="Antibiotic">Antibiotic</option>
                                                    <option value="Stomach & Digestion">Stomach & Digestion</option>
                                                    <option value="Vitamins & Supplements">Vitamins & Supplements</option>
                                                    <option value="Skin Care">Skin Care</option>
                                                    <option value="First Aid">First Aid</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                                <span class="select-ico"><i class="bi bi-chevron-down"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-auto">
                                            <div class="select-wrap">
                                                <select id="qAvailability" class="form-select form-select-sm input-soft select-soft">
                                                    <option value="all">All availability</option>
                                                    <option value="available">Available</option>
                                                    <option value="unavailable">Not available</option>
                                                </select>
                                                <span class="select-ico"><i class="bi bi-chevron-down"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-auto">
                                            <div class="select-wrap">
                                                <select id="qPrescription" class="form-select form-select-sm input-soft select-soft">
                                                    <option value="all">All prescription</option>
                                                    <option value="required">Prescription required</option>
                                                    <option value="not_required">No prescription</option>
                                                </select>
                                                <span class="select-ico"><i class="bi bi-chevron-down"></i></span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-auto">
                                            <button id="btnClear" class="btn btn-outline-secondary btn-sm rounded-4 w-100">
                                                Clear
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="small text-muted mb-3 flex-shrink-0">

                            </div>

                            <div class="kiosk-grid-scroll flex-grow-1">
                                <div class="row g-3" id="medGrid"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="kiosk-footer px-3 px-sm-4 px-lg-5 py-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <small class="text-muted">© <?php echo date("Y"); ?> ets-dev</small>
                <small class="text-muted"><?php echo $_SESSION['address']; ?></small>
            </div>
        </footer>

    </div>

    <div class="modal fade" id="infoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-soft">
                <div class="modal-header">
                    <div>
                        <div class="text-uppercase small fw-bold text-muted" style="letter-spacing:.12em;">Medicine</div>
                        <h5 class="modal-title fw-bold mb-0" id="infoTitle">Medicine Details</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-5">
                            <img id="infoImg" class="w-100 rounded-4 border" style="height:240px;object-fit:cover;" alt="">
                        </div>

                        <div class="col-12 col-md-7">
                            <div class="p-3 rounded-4 bg-light border">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="text-muted small fw-semibold">Brand</div>
                                        <div id="infoBrand" class="fw-bold"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted small fw-semibold">Price</div>
                                        <div id="infoPrice" class="fw-bold"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted small fw-semibold">Category</div>
                                        <div id="infoCat" class="fw-bold"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted small fw-semibold">Unit</div>
                                        <div id="infoUnit" class="fw-bold"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted small fw-semibold">Availability</div>
                                        <div id="infoAvail" class="fw-bold"></div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-muted small fw-semibold">Prescription</div>
                                        <div id="infoPrescription" class="fw-bold"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 p-sm-4 rounded-4 bg-white border">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                    <div class="text-muted small fw-semibold">Notes</div>
                                    <span class="badge rounded-pill text-bg-light border fw-bold" style="border-color:rgba(0,0,0,.08)!important;">
                                        Important
                                    </span>
                                </div>
                                <div id="infoNotes" class="fw-semibold" style="color:#212529;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm rounded-4 px-3" data-bs-dismiss="modal">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- cart -->
    <!-- CART SIDEBAR -->
    <div id="cartSidebar" class="cart-sidebar">
        <div class="cart-header">
            <h5>Cart</h5>
            <button id="closeCart" class="btn-close"></button>
        </div>

        <div id="cartItems" class="cart-body"></div>

        <div class="cart-footer">
            <div class="cart-footer">

    <!-- Discount चयन -->
    <div class="mb-2">
        <label class="fw-bold small">Discount</label>
        <select id="discountSelect" class="form-select form-select-sm">
            <option value="0">No Discount</option>
            <option value="0.05">Senior (5%)</option>
            <option value="0.10">PWD (10%)</option>
            <option value="0.20">Promo (20%)</option>
        </select>
    </div>

    <h6>Total: ₱<span id="cartTotal">0.00</span></h6>
            <h6>Total: ₱<span id="cartTotal">0.00</span></h6>
            <button id="print_btn" class="btn btn-success mb-2 w-100">Print Order</button>
            <button onclick="clearCart()" class="btn btn-outline-danger w-100 mb-2">
                Clear Cart
            </button>
        </div>
    </div>

    <div id="cartOverlay" class="cart-overlay d-none"></div>

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

        .topbar-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
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

        .kiosk-grid-scroll {
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            padding-right: 4px;
            min-height: 0;
        }

        .card-body {
            min-height: 0;
        }

        .med-card {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 20px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.07);
            transition: transform .12s ease, box-shadow .12s ease;
            height: 100%;
        }

        .med-card:active {
            transform: scale(0.99);
        }

        .med-card:hover {
            box-shadow: 0 22px 60px rgba(0, 0, 0, 0.10);
        }

        .med-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            background: #eef2ff;
        }

        .med-body {
            padding: 14px 14px;
        }

        .med-name {
            font-weight: 900;
            letter-spacing: -0.01em;
            margin-bottom: 2px;
        }

        .med-meta {
            color: #6c757d;
            font-weight: 700;
            font-size: 0.92rem;
            margin-bottom: 10px;
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

        .pill-available {
            background: rgba(25, 135, 84, 0.10);
            border-color: rgba(25, 135, 84, 0.16);
            color: #146c43;
        }

        .pill-unavailable {
            background: rgba(220, 53, 69, 0.10);
            border-color: rgba(220, 53, 69, 0.16);
            color: #b02a37;
        }

        .pill-prescription {
            background: rgba(255, 193, 7, 0.16);
            border-color: rgba(255, 193, 7, 0.24);
            color: #8a6d00;
        }

        .pill-no-prescription {
            background: rgba(13, 110, 253, 0.10);
            border-color: rgba(13, 110, 253, 0.16);
            color: #0d6efd;
        }

        .pill-info-btn {
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .modal-soft {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .img-fallback {
            display: grid;
            place-items: center;
            height: 150px;
            width: 100%;
            background: #eef2ff;
            color: #6c757d;
            font-weight: 900;
            padding: 10px;
            text-align: center;
        }

        @media (max-width: 767.98px) {
            .med-img {
                height: 140px;
            }

            .img-fallback {
                height: 140px;
            }

            .kiosk-card {
                height: calc(100vh - 150px);
            }
        }
    </style>

    <script>
        const qSearch = document.getElementById("qSearch");
        const qCategory = document.getElementById("qCategory");
        const qAvailability = document.getElementById("qAvailability");
        const qPrescription = document.getElementById("qPrescription");
        const btnClear = document.getElementById("btnClear");
        const grid = document.getElementById("medGrid");

        const infoModalEl = document.getElementById("infoModal");
        const infoTitle = document.getElementById("infoTitle");
        const infoImg = document.getElementById("infoImg");
        const infoBrand = document.getElementById("infoBrand");
        const infoCat = document.getElementById("infoCat");
        const infoUnit = document.getElementById("infoUnit");
        const infoAvail = document.getElementById("infoAvail");
        const infoPrescription = document.getElementById("infoPrescription");
        const infoNotes = document.getElementById("infoNotes");

        const infoModal = (window.bootstrap && bootstrap.Modal) ? new bootstrap.Modal(infoModalEl) : null;

        let meds = [];

        function loadMedicinesOnce() {

            const url = "api/select_medicine.php";

            return fetch(url, {
                    cache: "no-store"
                })
                .then(res => res.json())
                .then(rows => {

                    meds = (Array.isArray(rows) ? rows : []).map(r => ({
                        id: Number(r.id),
                        name: r.name || "",
                        brand: r.brand || "",
                        category: r.category || "",
                        unit: r.unit || "",
                        available: String(r.availability) === "1",
                        prescription: String(r.prescription).toLowerCase() === "yes", // Yes/No -> boolean
                        notes: r.notes || "",
                        price: Number(r.price) || 0,
                        img: r.image || ""
                    }));


                    applyFilters();
                })
                .catch(err => {
                    console.error(err);
                    meds = [];
                    applyFilters();
                });
        }

        const fallbackImgs = [
            "https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=1200&q=60",
            "https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=1200&q=60",
            "https://images.unsplash.com/photo-1584308667170-6b7980d7c9fd?auto=format&fit=crop&w=1200&q=60",
            "https://images.unsplash.com/photo-1584308666842-54b3c2c8c9f9?auto=format&fit=crop&w=1200&q=60",
            "https://images.unsplash.com/photo-1620916566393-7b36c6b8c0d3?auto=format&fit=crop&w=1200&q=60"
        ];

        function safeImg(url, i) {
            if (!url) return fallbackImgs[i % fallbackImgs.length];
            return url;
        }

        function prescriptionText(required) {
            return required ? "Prescription required" : "No prescription";
        }

        function attachImageFallback(imgEl, label) {
            imgEl.addEventListener("error", () => {
                const wrapper = imgEl.parentElement;
                if (!wrapper) return;
                imgEl.remove();
                const div = document.createElement("div");
                div.className = "img-fallback";
                div.textContent = label || "No image";
                wrapper.prepend(div);
            }, {
                once: true
            });
        }

        function openInfo(m) {
            infoTitle.textContent = m.name;
            infoImg.src = safeImg(m.img, m.id);
            infoImg.alt = m.name;
            infoBrand.textContent = m.brand || "Generic";
            infoCat.textContent = m.category;
            infoUnit.textContent = m.unit;
            infoAvail.textContent = m.available ? "Available" : "Not available";
            infoPrice.textContent = `${m.price.toFixed(2)}`;
            infoPrescription.textContent = prescriptionText(m.prescription);
            infoNotes.textContent = m.notes || "-";
            if (infoModal) infoModal.show();
        }

        function render(list) {
            grid.innerHTML = "";

            if (!list.length) {
                grid.innerHTML = `
                    <div class="col-12">
                        <div class="p-4 rounded-4 border bg-white">
                            <div class="fw-bold">No results</div>
                            <div class="text-muted">Try changing filters or search terms.</div>
                        </div>
                    </div>
                `;
                return;
            }

            list.forEach((m, idx) => {
                const aText = m.available ? "Available" : "Not available";
                const aCls = m.available ? "pill pill-available" : "pill pill-unavailable";
                const aPrice = `Php${m.price.toFixed(2)}`;
                const pText = m.prescription ? "Prescription required" : "No prescription";
                const pCls = m.prescription ? "pill pill-prescription" : "pill pill-no-prescription";
                const price_ls = "pill bg-primary bolder bg-opacity-10 border-success text-success";
                const imgUrl = safeImg(m.img, idx);
                const brand = m.brand;
                console.log(m)
                const col = document.createElement("div");
                col.className = "col-12 col-sm-6 col-lg-4";

                if (aText == "Available") {
                    button = `<button onclick="addToCart({
    id: ${m.id},
    name: '${m.name}',
    price: ${m.price},
    brand: '${m.brand}',
    imgUrl: '${imgUrl.replace(/'/g, "\\'")}'
})" class="btn btn-primary bg-opacity-10 text-white btn-sm rounded-4 p-2 w-75">
    Add to Cart
</button>`
                } else {
                    button = `  `
                }
                col.innerHTML = `
                    <div class="med-card position-relative">
                        <div class="med-img-wrap">
                            <img class="med-img" src="${imgUrl}" alt="${m.name}">
                        </div>
                        <div class="med-body">
                            <div class="med-name">${m.name}</div>
                            <div class="med-meta">${m.brand || "Generic"} • ${m.category} • ${m.unit}</div>

                            <div class="d-flex w-100 flex-wrap gap-2 align-items-end mb-2">
                                <span class="${price_ls}">${aPrice}</span>
                            
                                <span class="${aCls}">${aText}</span>
                                <span class="${pCls}">${pText}</span>
                                <button type="button" class="btn btn-secondary position-absolute me-2 btn-sm pill-info-btn info-btn"
                                    data-id="${m.id}"
                                    style="right: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.12);"
                                    aria-label="More info" title="More info">
                                    <i class="bi bi-info text-white fw-4"></i>
                                </button>
                                <br>
                                
                                ${button}
                            </div>
                        </div>
                    </div>
                `;

                grid.appendChild(col);

                const imgEl = col.querySelector("img.med-img");
                attachImageFallback(imgEl, m.name);
            });

            document.querySelectorAll(".info-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    const id = Number(btn.getAttribute("data-id"));
                    const m = meds.find(x => x.id === id);
                    if (m) openInfo(m);
                });
            });
        }

        function applyFilters() {
            const s = qSearch.value.trim().toLowerCase();
            const cat = qCategory.value;
            const av = qAvailability.value;
            const pr = qPrescription.value;

            let list = meds.slice();

            if (s) list = list.filter(m =>
                (m.name || "").toLowerCase().includes(s) ||
                (m.brand || "").toLowerCase().includes(s) ||
                (m.category || "").toLowerCase().includes(s)
            );

            if (cat) list = list.filter(m => m.category === cat);
            if (av === "available") list = list.filter(m => m.available === true);
            if (av === "unavailable") list = list.filter(m => m.available === false);
            if (pr === "required") list = list.filter(m => m.prescription === true);
            if (pr === "not_required") list = list.filter(m => m.prescription === false);

            render(list);
        }

        qSearch.addEventListener("input", applyFilters);
        qCategory.addEventListener("change", applyFilters);
        qAvailability.addEventListener("change", applyFilters);
        qPrescription.addEventListener("change", applyFilters);

        btnClear.addEventListener("click", () => {
            qSearch.value = "";
            qCategory.value = "";
            qAvailability.value = "all";
            qPrescription.value = "all";
            applyFilters();
        });

        function autoFullscreen() {
            if (document.fullscreenElement) return;

            const tryEnter = async () => {
                try {
                    await document.documentElement.requestFullscreen();
                } catch (e) {}
            };

            tryEnter();

            if (!document.fullscreenElement) {
                const overlay = document.createElement("div");
                overlay.style.position = "fixed";
                overlay.style.inset = "0";
                overlay.style.zIndex = "9999";
                overlay.style.background = "rgba(13, 110, 253, 0.95)";
                overlay.style.display = "flex";
                overlay.style.alignItems = "center";
                overlay.style.justifyContent = "center";
                overlay.style.padding = "24px";
                overlay.style.color = "#fff";
                overlay.style.textAlign = "center";
                overlay.innerHTML = `
                    <div style="max-width:520px">
                        <div style="font-weight:900;font-size:32px;letter-spacing:-0.02em;margin-bottom:10px">PharmaKiosk</div>
                        <div style="font-size:18px;opacity:0.92;margin-bottom:18px">Tap to enter fullscreen kiosk mode</div>
                        <button type="button" class="btn btn-light btn-lg" id="enterFsBtn" style="border-radius:16px;font-weight:900;padding:12px 24px">
                            Enter Fullscreen
                        </button>
                        <div style="margin-top:14px;opacity:0.8;font-size:13px">Fullscreen is required for kiosk mode.</div>
                    </div>
                `;
                document.body.appendChild(overlay);

                overlay.querySelector("#enterFsBtn").addEventListener("click", async () => {
                    await tryEnter();
                    if (document.fullscreenElement) overlay.remove();
                });
            }
        }

        loadMedicinesOnce();
        autoFullscreen();
    </script>

    <script>
        const dateTimeEl = document.getElementById("dateTime");

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
            const d = new Date();
            dateTimeEl.textContent = formatDateTime(d);
        }

        tickDateTime();
        setInterval(tickDateTime, 1000);
    </script>



    <script>
        let cart = [];

        // Load from localStorage
        function loadCart() {
            const saved = localStorage.getItem('cart');
            if (saved) cart = JSON.parse(saved);
            renderCart();
        }

        // Save to localStorage
        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        // Add to cart
        function addToCart(item) {
            const existing = cart.find(i => i.id === item.id);

            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({
                    ...item,
                    qty: 1
                });
            }
            showToast("<i class='bi bi-check-circle-fill'></i> Added to cart");
            // $('#cartSidebar').addClass('open');
            // $('#cartOverlay').removeClass('d-none');
            saveCart();
            renderCart();
        }

        // Remove item
        function removeFromCart(id) {
            cart = cart.filter(i => i.id !== id);
            saveCart();
            renderCart();
        }
        window.updateQty = function(id, change) {
            const item = cart.find(i => i.id === id);
            if (!item) return;

            item.qty += change;

            if (item.qty <= 0) {
                cart = cart.filter(i => i.id !== id);
            }

            saveCart();
            renderCart();
        }
        window.clearCart = function() {

            cart = [];
            saveCart();
            renderCart();
        }
        // Render cart
        function renderCart() {
            let html = "";
            let total = 0;
            let count = 0;

            cart.forEach(item => {
                total += item.price * item.qty;
                count += item.qty;

                html += `
            <div style="
                display: flex;
                flex-direction: row; /* image on the left, details on the right */
                align-items: center;
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 10px;
                gap: 12px;
                background: #fff;
            ">
                <!-- Item image -->
                <img src="${item.imgUrl}" alt="${item.name}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">

                <!-- Item details -->
                <div style="flex: 1; display: flex; flex-direction: column; gap: 6px;">
                    <strong>Name: ${item.name}</strong>
                    <smalls>Brand: ${item.brand}</smalls>

                    <!-- Quantity controls -->
                    <div style="display: flex; align-items: center; gap: 4px;">
                        <button onclick="updateQty(${item.id}, -1)" style="width: 30px;" class="btn btn-danger d-flex align-items-center justify-content-center">-</button>
                        <input class="form-control"
                            type="number" 
                            min="1" 
                            value="${item.qty}" 
                            onchange="setQty(${item.id}, this.value)" 
                            style="width: 100%; text-align: center;">
                        <button onclick="updateQty(${item.id}, 1)" style="width: 30px;" class="btn btn-primary d-flex align-items-center justify-content-center bg-opacity-10s">+</button>
                          <!-- Remove button -->
                    <button onclick="removeFromCart(${item.id})" style="width: fit-content; border: 1px solid #454040; background: #FFF; color: #e61616; border: none; padding: 4px 8px; border-radius: 4px;">
                        <i class="bi bi-trash"></i>
                    </button>
                    </div>

                    <!-- Total price -->
                    <div>₱${(item.price * item.qty).toFixed(2)}</div>

                  
                </div>
            </div>
        `;
            });

            // Vertical container
            const container = document.getElementById('cartItems');
            container.innerHTML = html || "<p>No items</p>";
            container.style.display = "flex";
            container.style.flexDirection = "column"; // vertical stack
            container.style.gap = "12px";
            container.style.padding = "8px";

            document.getElementById('cartTotal').innerText = total.toFixed(2);
            document.getElementById('cartCount').innerText = count;
        }

        // Helper for typing quantity directly
        function setQty(id, value) {
            const qty = parseInt(value);
            if (!isNaN(qty) && qty > 0) {
                const item = cart.find(i => i.id === id);
                if (item) {
                    item.qty = qty;
                    renderCart();
                }
            }
        }

        // Sidebar controls
        document.getElementById('openCart').onclick = () => {
            document.getElementById('cartSidebar').classList.add('open');
            document.getElementById('cartOverlay').classList.remove('d-none');
        };

        document.getElementById('closeCart').onclick = closeCart;
        document.getElementById('cartOverlay').onclick = closeCart;

        function closeCart() {
            document.getElementById('cartSidebar').classList.remove('open');
            document.getElementById('cartOverlay').classList.add('d-none');
        }

        function showToast(msg) {
            const toast = $(`
        <div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 start-0 m-3">
            <div class="d-flex">
                <div class="toast-body">${msg}</div>
            </div>
        </div>
    `);

            $('body').append(toast);
            new bootstrap.Toast(toast[0]).show();

            setTimeout(() => toast.remove(), 3000);
        }

        // Init
        loadCart();


        document.getElementById('print_btn').addEventListener('click', () => {
            closeCart();

            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const cartParam = encodeURIComponent(JSON.stringify(cart));
            localStorage.removeItem('cart'); // Clear cart after sending to print
            saveCart();
            renderCart();
            if (!cart.length) return alert("Cart is empty!");
            clearCart();
            // Send cart data as URL-encoded JSON




            setTimeout(() => {
                window.open(`print.php?cart=${cartParam}`, '_blank');
            }, 1000);


        });
    </script>




    <script>
        setTimeout(() => {
            autoFullscreen();
        }, 1500);
    </script>


</body>

</html>