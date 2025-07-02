<?php
require 'function.php'; // Mengimpor koneksi database dari file function.php

// Cek apakah parameter ID tersedia di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file berdasarkan ID dari database
    $get = mysqli_query($conn, "SELECT nama_file FROM file_penelitian WHERE id = $id");
    if ($data = mysqli_fetch_assoc($get)) {
        $file = 'uploads/' . $data['nama_file']; // Path ke file di folder uploads

        // Hapus file dari folder jika file tersebut ada
        if (file_exists($file)) {
            unlink($file); // Menghapus file secara fisik dari server
        }

        // Hapus data file dari tabel file_penelitian di database
        mysqli_query($conn, "DELETE FROM file_penelitian WHERE id = $id");
    }
}

// Redirect kembali ke halaman daftar file setelah penghapusan
header("Location: list-pdf.php");
exit;
?>
