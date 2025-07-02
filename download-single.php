<?php
require 'function.php'; // koneksi database

// Periksa apakah parameter ID dikirimkan
if (!isset($_GET['id'])) {
    die('ID file tidak ditemukan.');
}

$id = intval($_GET['id']); // sanitasi ID

// Ambil data file berdasarkan ID
$query = mysqli_query($conn, "SELECT nama_file FROM file_penelitian WHERE id = $id");
if (mysqli_num_rows($query) == 0) {
    die('File tidak ditemukan di database.');
}

$data = mysqli_fetch_assoc($query);
$filepath = 'uploads/' . $data['nama_file'];

// Cek apakah file ada di direktori uploads
if (!file_exists($filepath)) {
    die('File tidak ditemukan di server.');
}

// Atur header agar browser langsung mengunduh file
header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

// Baca file dan kirim ke browser
readfile($filepath);
exit;
?>
