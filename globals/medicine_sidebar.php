<aside id="sidebar" class="sidebar">

    <div class="side-inner">

        <div class="side-head">
            <div class="brand-badge">
                <span class="brand-icon">+</span>
            </div>
            <div class="brand-text">
                <div class="brand-title mb-1">MediKiosk</div>
                <div class="brand-subtitle">Medicine Panel</div>

            </div>
        </div>



        <div class="side-nav mt-1">
            <a class="nav-item active" href="#">
                <span class="nav-ic">▦</span>
                <span class="nav-txt">Dashboard</span>
            </a>

            <a class="nav-item nav-light" href="kiosk.php">
                <span class="nav-ic"><i class="bi bi-arrow-left-circle"></i></span>
                <span class="nav-txt">Back to Kiosk</span>
            </a>
            <a class="nav-item nav-danger" href="logout.php">
                <span class="nav-ic">⎋</span>
                <span class="nav-txt">Logout</span>
            </a>
        </div>

        <div class="side-foot mt-auto" style="background: #023062ff; overflow-x: hidden;">
            
           
            <div class="brand-subtitle  m-3 rounded-4 text-white p-1 text-center fw-bold" > <?= $username . "<br>" . $email ?>

            </div>




        </div>
</aside>