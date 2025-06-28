<?php
require 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    if ($type == 'instansi') {
        $query = "DELETE FROM instansi WHERE id_instansi = $id";
    } elseif ($type == 'fakultas') {
        $query = "DELETE FROM fakultas WHERE id_fakultas = $id";
    } elseif ($type == 'kategori') {
        $query = "DELETE FROM kategori WHERE id_kategori = $id";
    } elseif ($type == 'rak') {
        $query = "DELETE FROM rak WHERE id_rak = '$id'";
    }

    $result = mysqli_query($conn, $query);

    // ✅ Logging aktivitas penghapusan
    $log_status = $result ? "BERHASIL" : "GAGAL";
    $log_msg = date("Y-m-d H:i:s") . " - [$log_status] Hapus $type dengan ID: $id\n";
    file_put_contents("log_hapus.txt", $log_msg, FILE_APPEND);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . mysqli_error($conn)]);
    }
}
?>
