<?php
require 'function.php'; // Koneksi ke database dan fungsi umum

// Hapus data berdasarkan ID dari form POST
$id = $_POST['id'];

// Query untuk menghapus data dari tabel penelitian
$sql = "DELETE FROM penelitian WHERE id_penelitian = '$id'";
if (mysqli_query($conn, $sql)) {
    echo "Data berhasil dihapus";
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}

// Periksa ulang apakah data masih ada di database
$query = "SELECT * FROM penelitian WHERE id_penelitian = '$id'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    echo "Data masih ada di database"; // Berarti delete gagal
} else {
    echo "Data berhasil dihapus"; // Konfirmasi akhir
}

// Tutup koneksi
mysqli_close($conn);
?>
