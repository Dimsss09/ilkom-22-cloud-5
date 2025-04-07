<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="form.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Form Penelitian
                </a>
                <a class="nav-link" href="grafik.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    Grafik
                </a>
                <a class="nav-link" href="gemini-chat.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-robot"></i></div>
                    Gemini Chat
                </a>
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="panduan.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Panduan
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php echo $_SESSION['username']; ?>
        </div>
    </nav>
</div> 