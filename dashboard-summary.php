<?php
require 'function.php'; // koneksi database

// Hitung jumlah total data dari masing-masing tabel
$totalPenelitian = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM penelitian"))['total'];
$totalInstansi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM instansi"))['total'];
$totalFakultas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM fakultas"))['total'];
$totalKategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kategori"))['total'];
$totalRak = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM rak"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Ringkasan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">📊 Ringkasan Data E-Library</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Penelitian</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalPenelitian ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Instansi</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalInstansi ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Fakultas</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalFakultas ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Kategori</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalKategori ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total Rak</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $totalRak ?></h5>
                </div>
            </div>
        </div>
    </div>
    <a href="index.php" class="btn btn-secondary mt-3">⬅ Kembali ke Dashboard</a>
</div>
</body>
</html>
