<?php
// Mengimpor file function.php yang kemungkinan besar berisi koneksi ke database dan fungsi lain
require 'function.php';

// Mengatur header agar response yang dikirim bertipe JSON
header('Content-Type: application/json');

// Mengecek apakah request yang dikirim ke server adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Mengambil data yang dikirim lewat POST
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    // Logging data yang diterima untuk debugging (dapat dicek di error_log server)
    error_log("Received data - ID: $id, Nama: $nama, Type: $type");

    // Jika type kosong, kirim response gagal dan hentikan eksekusi
    if (empty($type)) {
        error_log("Type is empty");
        echo json_encode(['success' => false, 'message' => 'Type is empty']);
        exit;
    }

    // Mengecek jenis data yang ingin diupdate, dan menyusun query berdasarkan tipe
    if ($type == 'instansi') {
        $query = "UPDATE instansi SET nama_instansi = '$nama' WHERE id_instansi = $id";
    } elseif ($type == 'fakultas') {
        $query = "UPDATE fakultas SET nama_fakultas = '$nama' WHERE id_fakultas = $id";
    } elseif ($type == 'kategori') {
        $query = "UPDATE kategori SET nama_kategori = '$nama' WHERE id_kategori = $id";
    } elseif ($type == 'rak') {
        $query = "UPDATE rak SET id_rak = '$nama' WHERE id_rak = '$id'";
    } else {
        // Jika type tidak dikenali, kirim error
        error_log("Invalid type: " . $type);
        echo json_encode(['success' => false, 'message' => 'Invalid type']);
        exit;
    }

    // Menampilkan query di log server untuk keperluan debugging
    error_log("Executing query: " . $query);

    // Menjalankan query
    $result = mysqli_query($conn, $query);

    // Mengirim response berdasarkan hasil query
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Data berhasil diperbarui!']);
    } else {
        // Jika query gagal, tampilkan error MySQL
        error_log("MySQL error: " . mysqli_error($conn)); // Log error-nya
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . mysqli_error($conn)]);
    }
} else {
    // Jika request method bukan POST, kirim pesan error
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
