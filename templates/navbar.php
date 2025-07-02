<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navigasi bagian atas dengan tema gelap -->

    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3" href="index.php">E-Library BRIDA</a>
    <!-- Teks brand yang mengarah ke halaman utama (index.php) -->

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Tombol untuk toggle sidebar, menggunakan ikon hamburger -->

    <!-- Navbar kanan -->
    <ul class="navbar-nav ms-auto me-3">
        <!-- Navigasi item disusun ke kanan dengan margin kiri dan kanan -->

        <li class="nav-item dropdown">
            <!-- Dropdown menu untuk user -->
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <!-- Ikon user dengan toggle dropdown -->

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <!-- Menu dropdown muncul di sisi kanan -->
                <li>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                    <!-- Opsi logout -->
                </li>
            </ul>
        </li>
    </ul>
</nav>
