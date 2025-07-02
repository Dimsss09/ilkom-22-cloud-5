<?php
// healthcheck.php

require_once 'function.php'; // memastikan koneksi $conn tersedia

header('Content-Type: application/json');

// Cek koneksi database
if (!$conn) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Koneksi database gagal'
    ]);
    exit;
}

// Tes query sederhana
$result = mysqli_query($conn, "SHOW TABLES");
if (!$result) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Query database gagal dijalankan'
    ]);
    exit;
}

echo json_encode([
    'status' => 'ok',
    'message' => 'Sistem berjalan normal',
    'tables_found' => mysqli_num_rows($result)
]);
?>