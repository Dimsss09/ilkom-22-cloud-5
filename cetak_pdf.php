<?php
require 'function.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$html = "<h3>Data Penelitian</h3><table border='1' cellpadding='5' cellspacing='0'>";
$html .= "<tr><th>No</th><th>Judul</th><th>Penulis</th><th>Tahun</th></tr>";

$result = mysqli_query($conn, "SELECT * FROM penelitian");
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $html .= "<tr>
                <td>$no</td>
                <td>{$row['judul']}</td>
                <td>{$row['nama_penulis']}</td>
                <td>{$row['tahun']}</td>
              </tr>";
    $no++;
}
$html .= "</table>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("data_penelitian.pdf", ["Attachment" => false]);
exit;
