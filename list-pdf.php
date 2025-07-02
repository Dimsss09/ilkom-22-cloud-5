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

    <!-- Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Preview PDF</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <iframe id="pdfFrame" src="" width="100%" height="600px" style="border:none;"></iframe>
        </div>
        </div>
    </div>
    </div>

    <!-- Tombol untuk menuju halaman upload -->
    <a href="upload.php" class="btn btn-success">Upload File Baru</a>
    <a href="#" class="btn btn-secondary btn-sm" onclick="previewPDF('uploads/<?= $row['nama_file'] ?>')">Preview</a>
    <a href="download-zip.php" class="btn btn-warning mb-3">Download Semua PDF (.zip)</a>

    <script>
    function previewPDF(url) {
        document.getElementById('pdfFrame').src = url;
        var myModal = new bootstrap.Modal(document.getElementById('pdfModal'));
        myModal.show();
    }
    </script>

    <!-- Script bootstrap JS (wajib agar modal jalan) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
