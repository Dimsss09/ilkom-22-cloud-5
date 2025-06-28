<?php
// Memulai sesi (penting untuk memastikan session bisa dihancurkan)
session_start();

// Menghapus semua data sesi
session_destroy();

// Mengarahkan pengguna kembali ke halaman utama setelah logout
header("location: home.php");
exit(); // Tambahan opsional agar eksekusi berhenti di sini
?>
