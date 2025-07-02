<?php
// welcome.php - Halaman sambutan sederhana

session_start();
require_once 'function.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Ini adalah halaman sambutan setelah Anda berhasil login.</p>
