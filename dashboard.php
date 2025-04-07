<?php
require 'function.php';
require 'cek.php';

// Fetch data for Bar Chart (Penelitian per Bulan dan Tahun)
$currentYear = date('Y');
$startYear = $currentYear - 3;

$barChartQuery = "SELECT 
    tahun,
    LPAD(MONTH(tgl_masuk), 2, '0') as bulan,
    COUNT(*) as jumlah 
FROM penelitian 
WHERE tahun BETWEEN $startYear AND $currentYear 
GROUP BY tahun, bulan 
ORDER BY tahun, bulan";

$barChartResult = mysqli_query($conn, $barChartQuery);
$barChartData = [];
while ($row = mysqli_fetch_assoc($barChartResult)) {
    $barChartData[] = $row;
}

// Fetch data for Pie Chart (Penelitian per Kategori)
$pieChartQuery = "SELECT kategori.nama_kategori, COUNT(*) as jumlah 
                  FROM penelitian 
                  INNER JOIN kategori ON penelitian.id_kategori = kategori.id_kategori 
                  GROUP BY kategori.nama_kategori";
$pieChartResult = mysqli_query($conn, $pieChartQuery);
$pieChartData = [];
while ($row = mysqli_fetch_assoc($pieChartResult)) {
    $pieChartData[] = $row;
}

// Fetch total count of all Penelitian
$totalPenelitianQuery = "SELECT COUNT(*) as total FROM penelitian";
$totalPenelitianResult = mysqli_query($conn, $totalPenelitianQuery);
$totalPenelitianData = mysqli_fetch_assoc($totalPenelitianResult);
$totalPenelitian = $totalPenelitianData['total'];

// Fetch data for Bar Chart (Penelitian per Instansi)
$instansiChartQuery = "SELECT instansi.nama_instansi, COUNT(*) as jumlah 
                       FROM penelitian 
                       INNER JOIN instansi ON penelitian.id_instansi = instansi.id_instansi 
                       GROUP BY instansi.nama_instansi 
                       ORDER BY jumlah DESC";
$instansiChartResult = mysqli_query($conn, $instansiChartQuery);
$instansiChartData = [];
while ($row = mysqli_fetch_assoc($instansiChartResult)) {
    $instansiChartData[] = $row;
}
?>