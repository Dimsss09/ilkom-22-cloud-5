<?php
require 'function.php'; // koneksi database

// Proses pencarian
$keyword = isset($_GET['search']) ? trim($_GET['search']) : ''; // Ambil keyword dari form pencarian
$query = "SELECT * FROM file_penelitian"; // Query dasar

// Jika keyword tidak kosong, tambahkan filter pencarian berdasarkan judul atau tahun
if (!empty($keyword)) {
    $safeKeyword = mysqli_real_escape_string($conn, $keyword); // Amankan keyword dari SQL Injection
    $query .= " WHERE judul LIKE '%$safeKeyword%' OR tahun LIKE '%$safeKeyword%'";
}

$query .= " ORDER BY id DESC"; // Urutkan data dari yang terbaru
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
        <!-- Input untuk kata kunci pencarian -->
        <input type="text" name="search" class="form-control mr-2" placeholder="Cari judul atau tahun" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
        <!-- Tombol reset untuk kembali ke daftar semua data -->
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
                        <td><?= $no++ ?></td> <!-- Nomor urut -->
                        <td><?= htmlspecialchars($row['judul']) ?></td> <!-- Judul penelitian -->
                        <td><?= htmlspecialchars($row['tahun']) ?></td> <!-- Tahun penelitian -->
                        <td>
                            <!-- Tombol untuk melihat file PDF -->
                            <a href="uploads/<?= $row['nama_file'] ?>" target="_blank" class="btn btn-info btn-sm">Lihat PDF</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Jika tidak ada hasil -->
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tombol untuk menuju halaman upload -->
    <a href="upload.php" class="btn btn-success">Upload File Baru</a>
</body>
</html>
