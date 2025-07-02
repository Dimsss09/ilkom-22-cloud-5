<?php
// Mulai session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Membuat koneksi ke database MySQL dengan mysqli
$conn = mysqli_connect("localhost", "root", "", "db_perpustakaan");

// Cek apakah koneksi berhasil
if (!$conn) { 
    echo "Koneksi database gagal!"; 
}

// Mengecek apakah form dengan name 'addpenelitian' telah dikirim
if(isset($_POST['addpenelitian'])) { 

    // Mengambil data dari form
    $tgl_masuk = $_POST['tgl_masuk']; 
    $instansi = $_POST['instansi']; 
    $fakultas = $_POST['fakultas']; 
    $kategori = $_POST['kategori']; 
    $judul = $_POST['judul']; 
    $tahun = $_POST['tahun']; 
    $rak = $_POST['rak'];

    // Menggabungkan semua nama penulis menjadi satu string dipisahkan koma
    $nama_penulis = implode(", ", $_POST['nama_penulis']);

    // Validasi panjang minimal nama penulis
    if (strlen($nama_penulis) < 5) {
        echo "Nama penulis minimal harus 5 karakter.";
        exit;
    }

    // Membersihkan input pengguna untuk mencegah SQL injection
    $nama_penulis = mysqli_real_escape_string($conn, $nama_penulis);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $rak = mysqli_real_escape_string($conn, $_POST['rak']);
    $instansi = mysqli_real_escape_string($conn, $_POST['instansi']);
    $fakultas = mysqli_real_escape_string($conn, $_POST['fakultas']);

    // Validasi format tahun: harus 4 digit
    if (!preg_match('/^\d{4}$/', $tahun)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Input Tidak Valid',
                    text: 'Tahun harus terdiri dari 4 digit angka!',
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>";
        exit;
    }

    // Cek apakah tgl_masuk kosong, jika kosong gunakan CURRENT_TIMESTAMP
    if (empty($_POST['tgl_masuk'])) {
        $tgl_masuk = "CURRENT_TIMESTAMP";
    } else {
        // Jika tidak kosong, escape input tanggal
        $tgl_masuk = "'" . mysqli_real_escape_string($conn, $_POST['tgl_masuk']) . "'";
    }

    // Menyusun dan menjalankan perintah SQL untuk menyimpan data penelitian
    $addtotable = mysqli_query($conn, "INSERT INTO penelitian (tgl_masuk, nama_penulis, id_kategori, judul, tahun, id_rak, id_instansi, id_fakultas) 
        VALUES ($tgl_masuk, '$nama_penulis', '$kategori', '$judul', '$tahun', '$rak', '$instansi', '$fakultas')");

    // Jika berhasil disimpan, tampilkan notifikasi sukses
    if ($addtotable) { 
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Data penelitian berhasil ditambahkan!',
                    timer: 2000,
                    showConfirmButton: false
                }).then(function() {
                    window.location.href = 'index.php';
                });
            });
        </script>";
    } else { 
        // Jika gagal menyimpan, tampilkan notifikasi error dengan pesan dari database
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan: " . mysqli_error($conn) . "',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>";
    } 
} 
?>
