<?php
// Cek session dan redirect jika belum login
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="mb-3">Halo, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>!</h1>
        <p class="lead">Selamat datang di sistem informasi perpustakaan BRIDA.</p>
        <a href="logout.php" class="btn btn-warning mt-3">Logout</a>
    </div>
</body>
</html>
