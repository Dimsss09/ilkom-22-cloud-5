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

// Tentukan kolom yang akan ditampilkan berdasarkan halaman yang memanggil
$columns = "p.id_penelitian, p.judul, p.nama_penulis, i.nama_instansi, f.nama_fakultas, p.tahun, k.nama_kategori, p.id_rak";
if (isset($_POST['page_type']) && $_POST['page_type'] == 'index') {
    $columns .= ", p.tgl_masuk";
}

$sql = "SELECT $columns
        FROM penelitian p
        JOIN instansi i ON p.id_instansi = i.id_instansi
        JOIN kategori k ON p.id_kategori = k.id_kategori
        JOIN fakultas f ON p.id_fakultas = f.id_fakultas";
$sql .= " WHERE 1=1";

if ($search != '') {
    $sql .= " AND (p.judul LIKE '%$search%' OR p.nama_penulis LIKE '%$search%')";
}
if ($instansi != '') {
    $sql .= " AND i.nama_instansi = '$instansi'";
}
if ($fakultas != '') {
    $sql .= " AND f.nama_fakultas = '$fakultas'";
}
if ($year != '') {
    $sql .= " AND p.tahun = '$year'";
}
if ($category != '') {
    $sql .= " AND k.nama_kategori = '$category'";
}
if ($tgl_masuk != '') {
    $sql .= " AND p.tgl_masuk = '$tgl_masuk'";
}
if ($location != '') {
    $sql .= " AND p.id_rak = '$location'";
}

$sql .= " ORDER BY p.tgl_masuk DESC, p.id_penelitian DESC"; 
$sql .= " LIMIT $limit OFFSET $offset";


$result = $conn->query($sql);

$data = '';
while ($row = $result->fetch_assoc()) {
    $data .= "<tr><td>" . $row['judul'] . "</td><td>" . $row['nama_penulis'] . "</td><td>" . $row['nama_instansi'] . "</td><td>" . $row['nama_fakultas'] . "</td><td>" . $row['tahun'] . "</td><td>" . $row['nama_kategori'] . "</td><td>" . $row['id_rak'] . "</td>";
    if (isset($_POST['page_type']) && $_POST['page_type'] == 'index') {
        $data .= "<td>" . $row['tgl_masuk'] . "</td>";
        $data .= "<td><button type='button' class='btn btn-primary btn-edit' 
                    data-id='" . $row['id_penelitian'] . "' 
                    data-tgl_masuk='" . $row['tgl_masuk'] . "' 
                    data-judul='" . $row['judul'] . "' 
                    data-nama_penulis='" . $row['nama_penulis'] . "' 
                    data-instansi='" . $row['nama_instansi'] . "' 
                    data-fakultas='" . $row['nama_fakultas'] . "' 
                    data-kategori='" . $row['nama_kategori'] . "' 
                    data-tahun='" . $row['tahun'] . "' 
                    data-rak='" . $row['id_rak'] . "'>Edit</button></td>";
        $data .= "<td><button type='button' class='btn btn-danger btn-delete' 
                    data-id='" . $row['id_penelitian'] . "'>Hapus</button></td>";
    }
    $data .= "</tr>";
}