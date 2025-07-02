<?php
require 'function.php'; // koneksi database

// Proses pencarian
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$query = "SELECT * FROM file_penelitian";

// Jika keyword tidak kosong, tambahkan filter ke query
if (!empty($keyword)) {
    $safeKeyword = mysqli_real_escape_string($conn, $keyword);
    $query .= " WHERE judul LIKE '%$safeKeyword%' OR tahun LIKE '%$safeKeyword%'";
}

$query .= " ORDER BY id DESC";
$result = mysqli_query($conn, $query); // Eksekusi query
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar File PDF</title>
    <!-- Bootstrap untuk styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Daftar File Penelitian (PDF)</h2>

    <!-- Form Pencarian -->
    <form method="GET" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Cari judul atau tahun" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="list-pdf.php" class="btn btn-secondary ml-2">Reset</a>
    </form>

    <!-- Tabel daftar file -->
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
            <?php if (mysqli_num_rows($result) > 0): ?>
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
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="upload.php" class="btn btn-success">Upload File Baru</a>
</body>
</html>
