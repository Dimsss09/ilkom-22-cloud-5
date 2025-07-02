<?php
require 'function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file
    $get = mysqli_query($conn, "SELECT nama_file FROM file_penelitian WHERE id = $id");
    if ($data = mysqli_fetch_assoc($get)) {
        $file = 'uploads/' . $data['nama_file'];

        // Hapus dari folder
        if (file_exists($file)) {
            unlink($file);
        }

        // Hapus dari database
        mysqli_query($conn, "DELETE FROM file_penelitian WHERE id = $id");
    }
}

header("Location: list-pdf.php");
exit;
?>
