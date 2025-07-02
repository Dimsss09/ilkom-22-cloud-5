<?php
require 'function.php'; // Menghubungkan ke database

// Atur agar hasil diekspor sebagai file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_penelitian_filtered.xls");

// Ambil filter dari URL jika ada
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$instansi = isset($_GET['instansi']) ? $_GET['instansi'] : '';

// Buat query dasar
$query = "SELECT * FROM penelitian WHERE 1=1";

// Tambahkan filter jika tersedia
if (!empty($tahun)) {
    $query .= " AND tahun = '" . mysqli_real_escape_string($conn, $tahun) . "'";
}
if (!empty($kategori)) {
    $query .= " AND id_kategori = '" . mysqli_real_escape_string($conn, $kategori) . "'";
}
if (!empty($instansi)) {
    $query .= " AND id_instansi = '" . mysqli_real_escape_string($conn, $instansi) . "'";
}

// Jalankan query
$result = mysqli_query($conn, $query);

// Tampilkan hasil dalam tabel
echo "<table border='1'>";
echo "<tr><th>No</th><th>Judul</th><th>Penulis</th><th>Tahun</th></tr>";

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>$no</td>
            <td>{$row['judul']}</td>
            <td>{$row['nama_penulis']}</td>
            <td>{$row['tahun']}</td>
          </tr>";
    $no++;
}

echo "</table>";
?>
