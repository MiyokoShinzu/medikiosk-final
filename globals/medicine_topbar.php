<header class="topbar bg-success">
    <div class="top-left">
        <button id="toggleBtn" class="btn btn-light menu-btn" type="button" aria-label="Toggle sidebar">☰</button>

        <div class="top-titlewrap">
            <div class="top-kicker"></div>
            <div class="top-title text-white"><?= $kiosk_name; ?></div>
        </div>
    </div>

    <div class="top-right">
        <div class="status-chip">
            <span class="green-dot"></span>
            <span class="status-label">Online</span>
        </div>
    </div>
</header>
<style>
    .topbar {
        position: sticky;
        top: 0;
        z-index: 1055;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 18px;
        width: 100%;
        background: rgba(248, 249, 250, .92);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--soft-border);
    }

    .top-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
        flex: 1 1 auto;
    }

    .top-titlewrap {
        min-width: 0;
        overflow: hidden;
    }

    .top-kicker {
        letter-spacing: .22em;
        font-weight: 900;
        font-size: .78rem;
        color: var(--muted);
        line-height: 1.1;
        white-space: nowrap;
    }

    .top-title {
        font-weight: 900;
        letter-spacing: -.03em;
        font-size: clamp(18px, 2.3vw, 28px);
        line-height: 1.15;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .top-right {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end;
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

    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid var(--soft-border);
        font-weight: 900;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .06);
        white-space: nowrap;
    }

    @media (max-width: 575.98px) {
        .topbar {
            padding: 10px 12px;
        }

        .status-label {
            display: none;
        }
    }
</style>