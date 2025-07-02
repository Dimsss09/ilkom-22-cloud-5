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
<body>
<div class="container mt-5">
    <h2>Profil Pengguna</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($role); ?></p>
        </div>
    </div>
    <a href="dashboard.php" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
</div>

</body>
</html>