<aside id="sidebar" class="sidebar">

    <div class="side-inner">

        <div class="side-head">
            <div class="brand-badge">
                <span class="brand-icon">+</span>
            </div>
            <div class="brand-text">
                <div class="brand-title mb-1">MediKiosk</div>
                <div class="brand-subtitle">Kiosk Panel</div>

            </div>
        </div>



        <div class="side-nav mt-1">
            <a class="nav-item active" href="#">
                <span class="nav-ic">▦</span>
                <span class="nav-txt">Dashboard</span>
            </a>

            <a class="nav-item nav-danger" href="logout.php">
                <span class="nav-ic">⎋</span>
                <span class="nav-txt">Logout</span>
            </a>
        </div>

        <div class="side-foot mt-auto">
            <div class="status-row">
                <span class="green-dot"></span>
                <span class="status-text">System Online</span>
            </div>
            <div class="brand-subtitle border border-light m-3 rounded-4 bg-info text-white p-1 text-center"> <span class="text-center  p-0 m-0b  " style="font-size: 12px; font-weight: bold;"><?= $username . "<br>" . $email ?>
                    <span class="w-100 text-center mt-0">______________________</span></span></div>
        </div>

    </div>
</aside>