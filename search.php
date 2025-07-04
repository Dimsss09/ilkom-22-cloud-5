<?php
// Aktifkan pelaporan error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Tangkap output buffer untuk memastikan tidak ada output lain
ob_start();

require_once 'function.php';

// Pastikan tidak ada output lain sebelum ini
header('Content-Type: application/json');

// Ambil dan Filter Data dari $_POST
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

// Hitung total record untuk pagination
$count_sql = "SELECT COUNT(*) AS total FROM penelitian p
              JOIN instansi i ON p.id_instansi = i.id_instansi
              JOIN kategori k ON p.id_kategori = k.id_kategori
              JOIN fakultas f ON p.id_fakultas = f.id_fakultas";

$count_sql .= " WHERE 1=1";
if ($search != '') {
    $count_sql .= " AND (p.judul LIKE '%$search%' OR p.nama_penulis LIKE '%$search%')";
}
if ($instansi != '') {
    $count_sql .= " AND i.nama_instansi = '$instansi'";
}
if ($fakultas != '') {
    $count_sql .= " AND f.nama_fakultas = '$fakultas'";
}
if ($year != '') {
    $count_sql .= " AND p.tahun = '$year'";
}
if ($category != '') {
    $count_sql .= " AND k.nama_kategori = '$category'";
}
if ($tgl_masuk != '') {
    $count_sql .= " AND p.tgl_masuk = '$tgl_masuk'";
}
if ($location != '') {
    $count_sql .= " AND p.id_rak = '$location'";
}

$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

$pagination = '<ul class="pagination">';

// Tombol "Prev"
if ($page > 1) {
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='" . ($page - 1) . "'>Prev</a></li>";
}

// Tampilkan halaman pertama
if ($page > 3) {
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='1'>1</a></li>";
    $pagination .= "<li class='page-item disabled'><a class='page-link'>...</a></li>";
}

// Menampilkan 3 halaman di sekitar halaman aktif
$start = max(1, $page - 2);
$end = min($total_pages, $page + 2);

for ($i = $start; $i <= $end; $i++) {
    $active = ($i == $page) ? 'active' : '';
    $pagination .= "<li class='page-item $active'><a class='page-link' href='#' data-page='$i'>$i</a></li>";
}

// Tambahkan "..." sebelum halaman terakhir jika masih ada ruang
if ($page < $total_pages - 2) {
    $pagination .= "<li class='page-item disabled'><a class='page-link'>...</a></li>";
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='$total_pages'>$total_pages</a></li>";
}

// Tombol "Next"
if ($page < $total_pages) {
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='" . ($page + 1) . "'>Next</a></li>";
}

$pagination .= '</ul>';

$response = [
    'data' => $data,
    'pagination' => $pagination,
    'info' => "Showing page $page of $total_pages",
    'total_records' =>  "Showing $result->num_rows records out of $total_records"
];

// ✅ Tambahan log aktivitas pencarian
file_put_contents("log_search.txt", date("Y-m-d H:i:s") . " - Search query: '$search', page: $page\n", FILE_APPEND);

// Bersihkan output buffer dan kirim respons JSON
ob_end_clean();
echo json_encode($response);
?>
