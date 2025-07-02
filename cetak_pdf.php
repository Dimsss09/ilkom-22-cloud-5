<?php
// Memanggil file koneksi dan fungsi
require 'function.php';
// Memanggil autoload dari Composer untuk menggunakan Dompdf
require 'vendor/autoload.php';

// Menggunakan class Dompdf dari library Dompdf
use Dompdf\Dompdf;

// Membuat objek Dompdf
$dompdf = new Dompdf();

// Menyiapkan HTML awal untuk isi PDF
$html = "<h3>Data Penelitian</h3><table border='1' cellpadding='5' cellspacing='0'>";
$html .= "<tr><th>No</th><th>Judul</th><th>Penulis</th><th>Tahun</th></tr>";

// Mengambil data dari database tabel penelitian
$result = mysqli_query($conn, "SELECT * FROM penelitian");
$no = 1;

// Menambahkan setiap baris data ke dalam HTML
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>$no</td>
                <td>{$row['judul']}</td>
                <td>{$row['nama_penulis']}</td>
                <td>{$row['tahun']}</td>
              </tr>";
    $no++;
}

// Menutup tabel HTML
$html .= "</table>";

// Memuat HTML ke dalam objek Dompdf
$dompdf->loadHtml($html);
// Mengatur ukuran dan orientasi kertas PDF
$dompdf->setPaper('A4', 'portrait');
// Merender HTML menjadi PDF
$dompdf->render();
// Mengirimkan file PDF ke browser, ditampilkan langsung (tidak diunduh otomatis)
$dompdf->stream("data_penelitian.pdf", ["Attachment" => false]);

// Menghentikan eksekusi script
exit;
