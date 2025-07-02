<?php
require 'function.php'; // koneksi database

// Periksa apakah parameter ID dikirimkan
if (!isset($_GET['id'])) {
    die('ID file tidak ditemukan.'); // Hentikan jika tidak ada ID dikirim
}

$id = intval($_GET['id']); // sanitasi ID agar hanya angka (hindari SQL injection)

// Ambil data file berdasarkan ID
$query = mysqli_query($conn, "SELECT nama_file FROM file_penelitian WHERE id = $id");
if (mysqli_num_rows($query) == 0) {
    die('File tidak ditemukan di database.'); // Jika tidak ada data, tampilkan pesan
}

$data = mysqli_fetch_assoc($query); // Ambil data nama file
$filepath = 'uploads/' . $data['nama_file']; // Buat path lengkap ke file

// Cek apakah file ada di direktori uploads
if (!file_exists($filepath)) {
    die('File tidak ditemukan di server.'); // Jika file tidak ada secara fisik
}

// Atur header agar browser langsung mengunduh file
header('Content-Description: File Transfer'); // Informasi bahwa ini transfer file
header('Content-Type: application/pdf'); // Tipe file PDF
header('Content-Disposition: attachment; filename="' . basename($filepath) . '"'); // Nama file saat didownload
header('Expires: 0'); // Nonaktifkan cache
header('Cache-Control: must-revalidate'); // Validasi ulang cache
header('Pragma: public'); // Kompatibilitas cache
header('Content-Length: ' . filesize($filepath)); // Ukuran file

// Baca file dan kirim ke browser
readfile($filepath); // Kirim file ke browser untuk didownload
exit; // Hentikan eksekusi script
?>
