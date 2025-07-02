<?php
// Mengimpor file function.php yang kemungkinan besar berisi koneksi ke database dan fungsi lainnya
require 'function.php';

// Tambahan: pastikan koneksi database tersedia
if (!$conn) {
    // Jika koneksi gagal, catat log dan kirim response error JSON
    file_put_contents('log_update.txt', date('Y-m-d H:i:s') . " - ERROR: Koneksi database gagal\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Koneksi database gagal'
    ]);
    exit;
}

// Menghapus output buffer yang mungkin sudah tertulis agar hanya JSON yang dikirim
ob_clean();
header('Content-Type: application/json');

try {
    // Mengecek apakah request method adalah POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validasi apakah semua field POST terisi
    if (empty($_POST['id_penelitian']) || empty($_POST['judul']) || 
        empty($_POST['nama_penulis']) || empty($_POST['tgl_masuk']) || 
        empty($_POST['instansi']) || empty($_POST['fakultas']) || 
        empty($_POST['kategori']) || empty($_POST['tahun']) || 
        empty($_POST['rak'])) {
        throw new Exception('Semua field harus diisi');
    }

    // Escape dan amankan input dari user
    $id = $conn->real_escape_string($_POST['id_penelitian']);
    $judul = $conn->real_escape_string($_POST['judul']);
    $tgl_masuk = $conn->real_escape_string($_POST['tgl_masuk']);
    $instansi = $conn->real_escape_string($_POST['instansi']);
    $fakultas = $conn->real_escape_string($_POST['fakultas']);
    $kategori = $conn->real_escape_string($_POST['kategori']);
    $tahun = $conn->real_escape_string($_POST['tahun']);
    $rak = $conn->real_escape_string($_POST['rak']);
    
    // Jika nama_penulis berupa array, gabungkan dan escape setiap elemen
    $nama_penulis = is_array($_POST['nama_penulis']) 
        ? implode(", ", array_map([$conn, 'real_escape_string'], $_POST['nama_penulis']))
        : $conn->real_escape_string($_POST['nama_penulis']);

    // Query untuk mengupdate data penelitian berdasarkan ID
    $sql = "UPDATE penelitian SET 
            judul = '$judul', 
            nama_penulis = '$nama_penulis', 
            tgl_masuk = '$tgl_masuk', 
            id_instansi = '$instansi', 
            id_fakultas = '$fakultas', 
            id_kategori = '$kategori', 
            tahun = '$tahun', 
            id_rak = '$rak' 
            WHERE id_penelitian = '$id'";

    // Jalankan query dan tangani error jika gagal
    if (!$conn->query($sql)) {
        throw new Exception($conn->error);
    }

    // Tulis log ke file jika berhasil
    file_put_contents('log_update.txt', date('Y-m-d H:i:s') . " - Data penelitian ID $id diperbarui\n", FILE_APPEND);

    // Kirim response sukses dalam bentuk JSON
    echo json_encode([
        'success' => true,
        'message' => 'Data penelitian berhasil diperbarui'
    ]);

} catch (Exception $e) {
    // Tangani semua error dan kirim response JSON dengan status code 400
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Hentikan eksekusi setelah response dikirim
exit;
?>
