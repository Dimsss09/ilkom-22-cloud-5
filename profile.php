<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Dummy data pengguna (bisa diganti dari DB)
$username = "DhanyR";
$email = "dhany@kece.com";
$role = "Administrator";