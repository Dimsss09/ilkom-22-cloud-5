<?php
require 'function.php'; // Memanggil file function.php untuk koneksi database

// Mengecek apakah form dikirim dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul']; // Menyimpan judul dari form
    $tahun = $_POST['tahun']; // Menyimpan tahun dari form
    $fileName = $_FILES['file']['name']; // Nama file yang diupload
    $fileTmp = $_FILES['file']['tmp_name']; // Lokasi sementara file
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Ekstensi file

    // Validasi bahwa hanya file PDF yang diperbolehkan
    if ($fileExt != 'pdf') {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!'); window.history.back();</script>";
        exit;
    }

    $uploadDir = 'uploads/'; // Direktori tempat menyimpan file
    // Cek jika folder uploads belum ada, maka buat foldernya
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Buat nama file unik untuk menghindari tabrakan
    $uniqueName = uniqid() . '-' . basename($fileName);
    $destination = $uploadDir . $uniqueName; // Lokasi akhir penyimpanan file

    // Proses memindahkan file dari tmp ke folder uploads
    if (move_uploaded_file($fileTmp, $destination)) {
        // Simpan data ke database
        $query = "INSERT INTO file_penelitian (judul, tahun, nama_file) VALUES ('$judul', '$tahun', '$uniqueName')";
        mysqli_query($conn, $query);

        // Tampilkan alert berhasil dan redirect ke halaman daftar PDF
        echo "<script>alert('File berhasil diunggah!'); window.location.href='list-pdf.php';</script>";
    } else {
        // Jika gagal upload, tampilkan pesan
        echo "<script>alert('Gagal mengunggah file!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File Penelitian</title>
    <!-- Menggunakan Bootstrap untuk styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Upload File PDF Penelitian</h2>
    <!-- Form upload file -->
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Judul Penelitian</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tahun</label>
            <input type="text" name="tahun" class="form-control" required>
        </div>
        <div class="form-group">
            <label>File PDF</label>
            <input type="file" name="file" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="list-pdf.php" class="btn btn-secondary">Lihat File</a>
    </form>
</body>
</html>
