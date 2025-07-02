<?php
require 'function.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_penelitian.xls");

echo "<table border='1'>";
echo "<tr><th>No</th><th>Judul</th><th>Penulis</th><th>Tahun</th></tr>";

$result = mysqli_query($conn, "SELECT * FROM penelitian");
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
