<div id="layoutSidenav_nav">
    <!-- Sidebar navigasi utama -->
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <!-- Navigasi dengan efek accordion dan tema gelap -->

        <div class="sb-sidenav-menu">
            <!-- Bagian menu sidebar -->
            <div class="nav">
                <!-- Kumpulan link navigasi -->

                <div class="sb-sidenav-menu-heading">Core</div>
                <!-- Heading untuk bagian menu utama -->

                <a class="nav-link" href="index.php">
                    <!-- Link ke halaman Dashboard -->
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    <!-- Ikon dashboard -->
                    Dashboard
                </a>

                <a class="nav-link" href="form.php">
                    <!-- Link ke halaman Form Penelitian -->
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    <!-- Ikon file/form -->
                    Form Penelitian
                </a>

                <a class="nav-link" href="grafik.php">
                    <!-- Link ke halaman Grafik -->
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    <!-- Ikon grafik -->
                    Grafik
                </a>

                <a class="nav-link" href="gemini-chat.php">
                    <!-- Link ke halaman Gemini Chat -->
                    <div class="sb-nav-link-icon"><i class="fas fa-robot"></i></div>
                    <!-- Ikon chatbot -->
                    Gemini Chat
                </a>

                <div class="sb-sidenav-menu-heading">Addons</div>
                <!-- Heading untuk bagian tambahan -->

                <a class="nav-link" href="panduan.php">
                    <!-- Link ke halaman Panduan -->
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    <!-- Ikon buku -->
                    Panduan
                </a>
            </div>
        </div>

        <div class="sb-sidenav-footer">
            <!-- Bagian footer sidebar -->
            <div class="small">Logged in as:</div>
            <?php echo $_SESSION['username']; ?>
            <!-- Menampilkan nama user yang sedang login dari session -->
        </div>
    </nav>
</div>
