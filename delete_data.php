<?php
require 'function.php'; // Mengimpor koneksi atau fungsi dari file eksternal

// Mengecek apakah request menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Mengambil ID dari data POST
    $type = $_POST['type']; // Mengambil tipe data (instansi/fakultas/kategori/rak)

    // Menyusun query DELETE berdasarkan jenis data
    if ($type == 'instansi') {
        $query = "DELETE FROM instansi WHERE id_instansi = $id";
    } elseif ($type == 'fakultas') {
        $query = "DELETE FROM fakultas WHERE id_fakultas = $id";
    } elseif ($type == 'kategori') {
        $query = "DELETE FROM kategori WHERE id_kategori = $id";
    } elseif ($type == 'rak') {
        $query = "DELETE FROM rak WHERE id_rak = '$id'";
    }

    $result = mysqli_query($conn, $query); // Menjalankan query penghapusan

    // ✅ Logging aktivitas penghapusan
    $log_status = $result ? "BERHASIL" : "GAGAL"; // Status keberhasilan query
    $log_msg = date("Y-m-d H:i:s") . " - [$log_status] Hapus $type dengan ID: $id\n"; // Format log
    file_put_contents("log_hapus.txt", $log_msg, FILE_APPEND); // Menyimpan log ke file

    // Memberikan response JSON ke client (biasanya dipakai di AJAX)
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . mysqli_error($conn)]);
    }
}
?>
