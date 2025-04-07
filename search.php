<?php
// Aktifkan pelaporan error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Tangkap output buffer untuk memastikan tidak ada output lain
ob_start();

require_once 'function.php';

// Pastikan tidak ada output lain sebelum ini
header('Content-Type: application/json');


//  Ambil dan Filter Data dari $_POST

$search = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';
$year = isset($_POST['year']) ? $conn->real_escape_string($_POST['year']) : '';
$category = isset($_POST['category']) ? $conn->real_escape_string($_POST['category']) : '';
$instansi = isset($_POST['instansi']) ? $conn->real_escape_string($_POST['instansi']) : '';
$fakultas = isset($_POST['fakultas']) ? $conn->real_escape_string($_POST['fakultas']) : '';
$tgl_masuk = isset($_POST['tgl_masuk']) ? $conn->real_escape_string($_POST['tgl_masuk']) : '';
$location = isset($_POST['location']) ? $conn->real_escape_string($_POST['location']) : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 10; // Jumlah record per halaman
$offset = ($page - 1) * $limit;