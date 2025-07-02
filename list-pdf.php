<?php
require 'function.php';
$result = mysqli_query($conn, "SELECT * FROM file_penelitian ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar File PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Daftar File Penelitian (PDF)</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tahun</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['tahun']) ?></td>
                    <td>
                        <a href="uploads/<?= $row['nama_file'] ?>" target="_blank" class="btn btn-info btn-sm">Lihat PDF</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="upload.php" class="btn btn-primary">Upload File Baru</a>
</body>
</html>
