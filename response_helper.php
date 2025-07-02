<?php
// response_helper.php
// Fungsi bantu untuk mengirimkan response standar
function kirimResponseJSON($status, $pesan, $data = null) {
    header('Content-Type: application/json');
    $res = [
        'status' => $status,
        'pesan' => $pesan
    ];
    if ($data !== null) {
        $res['data'] = $data;
    }
    echo json_encode($res); 
    exit;
}
function kirimResponseHTML($pesan, $kembaliKe = null) {
    echo "<div style='padding:1em;background:#eee;border:1px solid #ccc;margin:2em auto;width:90%;max-width:500px;'>$pesan</div>";
    if ($kembaliKe) {
        echo "<div style='text-align:center;'><a href='$kembaliKe'>Kembali</a></div>";
    }
    exit;
}
?>
