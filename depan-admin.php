<?php
require 'function.php';
require 'cek.php';

// Fetch data from each table
$instansi_result = mysqli_query($conn, "SELECT * FROM instansi ORDER BY nama_instansi asc");
$fakultas_result = mysqli_query($conn, "SELECT * FROM fakultas ORDER BY nama_fakultas asc");
$kategori_result = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori asc");
$rak_result = mysqli_query($conn, "SELECT * FROM rak ORDER BY id_rak asc");
?>