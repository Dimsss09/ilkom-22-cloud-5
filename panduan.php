<?php
session_start();
require_once 'cek.php'; // Pastikan ini berisi validasi login

$pdfFile = './panduan/panduan.pdf';

// Tangkap nama pengguna jika tersedia
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'unknown user';

if (!file_exists($pdfFile)) {
    http_response_code(404);
    die("File tidak ditemukan.");
}

if (isset($_GET['download'])) {
    // Logging aktivitas unduhan
    file_put_contents("log_download.txt", date("Y-m-d H:i:s") . " - $username mengunduh file panduan\n", FILE_APPEND);

    // Set header agar file dikirim sebagai unduhan
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=panduan.pdf");
    header("Content-Length: " . filesize($pdfFile));

    readfile($pdfFile);
    exit;
}

// ✅ Logging untuk preview file panduan
file_put_contents("log_download.txt", date("Y-m-d H:i:s") . " - $username membuka file panduan (preview)\n", FILE_APPEND);

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=panduan.pdf");
header("Content-Length: " . filesize($pdfFile));
header("Accept-Ranges: bytes");

readfile($pdfFile);
exit;
?>
