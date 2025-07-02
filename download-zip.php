<?php
require 'function.php'; // Menghubungkan ke database

$zip = new ZipArchive(); // Membuat instance dari ZipArchive
$filename = "semua_file_penelitian.zip"; // Nama file ZIP yang akan dibuat

// Membuka file ZIP untuk ditulis (buat baru atau timpa jika sudah ada)
if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    exit("Tidak dapat membuat file ZIP."); // Jika gagal membuat ZIP, keluar
}

// Ambil semua nama file dari database
$result = mysqli_query($conn, "SELECT nama_file FROM file_penelitian");
while ($row = mysqli_fetch_assoc($result)) {
    $filePath = "uploads/" . $row['nama_file']; // Path lengkap ke file
    if (file_exists($filePath)) {
        $zip->addFile($filePath, $row['nama_file']); // Tambahkan file ke ZIP
    }
}

$zip->close(); // Selesai menambahkan file, tutup ZIP

// Atur header agar browser memulai unduhan file ZIP
header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename=$filename");
readfile($filename); // Baca isi file ZIP dan kirim ke browser

unlink($filename); // Hapus file ZIP dari server setelah diunduh
exit;
?>
