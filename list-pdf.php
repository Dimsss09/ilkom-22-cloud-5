<?php
require 'function.php'; // Memanggil file function.php untuk koneksi database
$result = mysqli_query($conn, "SELECT * FROM file_penelitian ORDER BY id DESC"); // Mengambil semua data file dari tabel file_penelitian, urutkan dari yang terbaru
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar File PDF</title>
    <!-- Menyertakan Bootstrap untuk styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Daftar File Penelitian (PDF)</h2>
    <!-- Tabel untuk menampilkan daftar file -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th> <!-- Kolom Nomor Urut -->
                <th>Judul</th> <!-- Kolom Judul Penelitian -->
                <th>Tahun</th> <!-- Kolom Tahun -->
                <th>File</th> <!-- Kolom Aksi untuk melihat file PDF -->
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $no++ ?></td> <!-- Menampilkan nomor urut -->
                    <td><?= htmlspecialchars($row['judul']) ?></td> <!-- Menampilkan judul penelitian dengan perlindungan terhadap XSS -->
                    <td><?= htmlspecialchars($row['tahun']) ?></td> <!-- Menampilkan tahun penelitian -->
                    <td>
                        <!-- Tombol untuk melihat file PDF dalam tab baru -->
                        <a href="uploads/<?= $row['nama_file'] ?>" target="_blank" class="btn btn-info btn-sm">Lihat PDF</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Tombol untuk kembali ke halaman upload file -->
    <a href="upload.php" class="btn btn-primary">Upload File Baru</a>
</body>
</html>
