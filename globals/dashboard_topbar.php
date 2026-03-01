<header class="kiosk-topbar">

    <!-- LEFT: Brand -->
    <div class="topbar-left">
        <div class="brand-mini">
            <div class="brand-mini-title">MediKiosk</div>
            <div class="brand-mini-subtitle">
                <?php echo $_SESSION['kiosk_name'] ?? "Medicine Kiosk"; ?>
            </div>
        </div>
    </div>

    <!-- CENTER: Status -->
    <div class="topbar-center d-none d-md-flex">
        <div class="status-pill">
            <i class="bi bi-prescription2 me-2 text-primary"></i>
            Medicine Availability Dashboard
        </div>
    </div>

    <!-- RIGHT: Date + Exit -->
    <div class="topbar-right d-flex align-items-center gap-3">

        <div class="text-end d-none d-sm-block">
            <div class="fw-bold small text-muted">Today</div>
            <div id="dateTime" class="fw-bold"></div>
        </div>

        <a href="logout.php" class="btn btn-outline-danger btn-sm topbar-btn">
            <i class="bi bi-arrow-left-circle me-1"></i> Logout
        </a>

    </div>

</header>
<style>
    .kiosk-topbar {
        background: linear-gradient(90deg, #ffffff, #f8fbff);
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        padding: 14px clamp(16px, 4vw, 32px);
    }

    .brand-mini-title {
        font-weight: 1000;
        font-size: 20px;
        letter-spacing: -0.02em;
        color: #0d6efd;
    }

    .brand-mini-subtitle {
        font-size: 13px;
        color: #6c757d;
        font-weight: 600;
    }

    .status-pill {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.12), rgba(13, 110, 253, 0.05));
        border: 1px solid rgba(13, 110, 253, 0.15);
        font-size: 14px;
    }

    #dateTime {
        font-size: 14px;
        letter-spacing: 0.02em;
    }

    .topbar-btn {
        border-radius: 16px;
        font-weight: 800;
        padding: 6px 14px;
    }
</style>