<?php
require 'function.php'; // Mengimpor file function.php untuk koneksi ke database

// Mengatur header agar browser mengenali konten sebagai file Excel
header("Content-type: application/vnd-ms-excel");

// Mengatur nama file yang akan diunduh pengguna
header("Content-Disposition: attachment; filename=data_penelitian.xls");

// Memulai tabel HTML sebagai isi file Excel
echo "<table border='1'>";
echo "<tr><th>No</th><th>Judul</th><th>Penulis</th><th>Tahun</th></tr>";

// Menjalankan query untuk mengambil semua data dari tabel 'penelitian'
$result = mysqli_query($conn, "SELECT * FROM penelitian");

// Inisialisasi nomor urut
$no = 1;

// Menampilkan setiap baris data dalam format tabel
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>$no</td>
            <td>{$row['judul']}</td>
            <td>{$row['nama_penulis']}</td>
            <td>{$row['tahun']}</td>
          </tr>";
    $no++; // Menambahkan nomor urut
}

// Menutup tag tabel
echo "</table>";
?>
