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