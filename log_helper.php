<?php
// log_helper.php
// Modul untuk mencatat aktivitas pengguna ke dalam file log

/**
 * Mencatat log umum ke file log umum
 */
function tulisLogUmum($pesan) {
    $waktu = date("Y-m-d H:i:s");
    $log = "[$waktu] $pesan" . PHP_EOL;
    file_put_contents("log_umum.txt", $log, FILE_APPEND);
}
function logLogin($username) {
    tulisLogUmum("Pengguna '$username' melakukan login");
}
function logLogout($username) {
    tulisLogUmum("Pengguna '$username' melakukan logout");
}
function logAksesHalaman($username, $halaman) {
    tulisLogUmum("Pengguna '$username' mengakses halaman '$halaman'");
}
?>
