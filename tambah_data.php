<?php
// Mengimpor file function.php yang berisi koneksi database atau fungsi tambahan
require 'function.php';

// Mengatur header respons agar bertipe JSON
header('Content-Type: application/json');

// Menyiapkan array respons default
$response = array('success' => false, 'message' => '');

// Mengecek apakah request yang diterima adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil input dari form POST dan menghilangkan spasi di awal/akhir string
    $instansi = isset($_POST['instansi']) ? trim($_POST['instansi']) : '';
    $fakultas = isset($_POST['fakultas']) ? trim($_POST['fakultas']) : '';
    $kategori = isset($_POST['kategori']) ? trim($_POST['kategori']) : '';
    $rak = isset($_POST['rak']) ? trim($_POST['rak']) : '';

    // Variabel untuk memeriksa keberhasilan dan menyimpan error jika ada
    $success = true;
    $errors = [];

    // ======================== CEK DAN INSERT INSTANSI ========================
    // Jika field instansi tidak kosong
    if (!empty($instansi)) {
        // Cek apakah instansi sudah ada di database
        $instansi_exists = mysqli_query($conn, "SELECT * FROM instansi WHERE nama_instansi = '$instansi'");
        if (mysqli_num_rows($instansi_exists) == 0) {
            // Jika belum ada, tambahkan instansi ke database
            $instansi_query = "INSERT INTO instansi (nama_instansi) VALUES ('$instansi')";
            if (!mysqli_query($conn, $instansi_query)) {
                // Jika gagal, catat error
                $success = false;
                $errors[] = 'Instansi: ' . mysqli_error($conn);
            }
        }
    }

    // ======================== CEK DAN INSERT FAKULTAS ========================
    if (!empty($fakultas)) {
        $fakultas_exists = mysqli_query($conn, "SELECT * FROM fakultas WHERE nama_fakultas = '$fakultas'");
        if (mysqli_num_rows($fakultas_exists) == 0) {
            $fakultas_query = "INSERT INTO fakultas (nama_fakultas) VALUES ('$fakultas')";
            if (!mysqli_query($conn, $fakultas_query)) {
                $success = false;
                $errors[] = 'Fakultas: ' . mysqli_error($conn);
            }
        }
    }

    // ======================== CEK DAN INSERT KATEGORI ========================
    if (!empty($kategori)) {
        $kategori_exists = mysqli_query($conn, "SELECT * FROM kategori WHERE nama_kategori = '$kategori'");
        if (mysqli_num_rows($kategori_exists) == 0) {
            $kategori_query = "INSERT INTO kategori (nama_kategori) VALUES ('$kategori')";
            if (!mysqli_query($conn, $kategori_query)) {
                $success = false;
                $errors[] = 'Kategori: ' . mysqli_error($conn);
            }
        }
    }

    // ======================== CEK DAN INSERT RAK ========================
    if (!empty($rak)) {
        $rak_exists = mysqli_query($conn, "SELECT * FROM rak WHERE id_rak = '$rak'");
        if (mysqli_num_rows($rak_exists) == 0) {
            $rak_query = "INSERT INTO rak (id_rak) VALUES ('$rak')";
            if (!mysqli_query($conn, $rak_query)) {
                $success = false;
                $errors[] = 'Rak: ' . mysqli_error($conn);
            }
        }
    }

    // Jika semua insert berhasil, update status sukses
    if ($success) {
        $response['success'] = true;
        $response['message'] = 'Data berhasil ditambahkan!';
    } else {
        // Jika ada error, gabungkan semua pesan error ke dalam response
        $response['message'] = implode(', ', $errors);
    }
}

// Mengembalikan data dalam format JSON
echo json_encode($response);
?>
