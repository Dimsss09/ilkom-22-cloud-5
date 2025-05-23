<?php 
session_start(); 
// membuat koneksi ke database 
$conn = mysqli_connect("localhost", "root", "", "db_perpustakaan");
if (!$conn) { 
    echo "Koneksi database gagal!"; 
}

// tambah penelitian 
if(isset($_POST['addpenelitian'])) { 
    $tgl_masuk = $_POST['tgl_masuk']; 
    $instansi = $_POST['instansi']; 
    $fakultas = $_POST['fakultas']; 
    $kategori = $_POST['kategori']; 
    $judul = $_POST['judul']; 
    $tahun = $_POST['tahun']; 
    $rak = $_POST['rak'];

    // Concatenate all author names into a single string separated by commas 
    $nama_penulis = implode(", ", $_POST['nama_penulis']);

    // Escape all user inputs to prevent SQL injection and handle special characters
    $nama_penulis = mysqli_real_escape_string($conn, $nama_penulis);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tahun = mysqli_real_escape_string($conn, $_POST['tahun']);
    $rak = mysqli_real_escape_string($conn, $_POST['rak']);
    $instansi = mysqli_real_escape_string($conn, $_POST['instansi']);
    $fakultas = mysqli_real_escape_string($conn, $_POST['fakultas']);

    // Check if tgl_masuk is empty, if so, use CURRENT_TIMESTAMP
    if (empty($_POST['tgl_masuk'])) {
        $tgl_masuk = "CURRENT_TIMESTAMP";
    } else {
        $tgl_masuk = "'" . mysqli_real_escape_string($conn, $_POST['tgl_masuk']) . "'";
    }

    // Insert data into the database
    $addtotable = mysqli_query($conn, "INSERT INTO penelitian (tgl_masuk, nama_penulis, id_kategori, judul, tahun, id_rak, id_instansi, id_fakultas) 
        VALUES ($tgl_masuk, '$nama_penulis', '$kategori', '$judul', '$tahun', '$rak', '$instansi', '$fakultas')");

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
    }else { 
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