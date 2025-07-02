<?php
require 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $tahun = $_POST['tahun'];
    $fileName = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if ($fileExt != 'pdf') {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!'); window.history.back();</script>";
        exit;
    }

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uniqueName = uniqid() . '-' . basename($fileName);
    $destination = $uploadDir . $uniqueName;

    if (move_uploaded_file($fileTmp, $destination)) {
        // Simpan ke database
        $query = "INSERT INTO file_penelitian (judul, tahun, nama_file) VALUES ('$judul', '$tahun', '$uniqueName')";
        mysqli_query($conn, $query);

        echo "<script>alert('File berhasil diunggah!'); window.location.href='list-pdf.php';</script>";
    } else {
        echo "<script>alert('Gagal mengunggah file!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload File Penelitian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Upload File PDF Penelitian</h2>
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
