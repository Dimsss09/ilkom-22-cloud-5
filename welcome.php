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
