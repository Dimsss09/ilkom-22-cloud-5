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

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>