<?php
// helper-validasi.php
// Kumpulan fungsi validasi input form

/**
 * Validasi apakah input tidak kosong
 */
function validasiTidakKosong($input, $nama_field) {
    if (empty(trim($input))) {
        return "$nama_field tidak boleh kosong.";
    }
    return true;
}
/**
 * Validasi panjang minimal karakter
 */
function validasiPanjangMinimal($input, $min, $nama_field) {
    if (strlen(trim($input)) < $min) {
        return "$nama_field minimal $min karakter.";
    }
    return true;
}
/**
 * Validasi format tahun (4 digit)
 */
function validasiTahun($tahun) {
    if (!preg_match("/^\d{4}$/", $tahun)) {
        return "Tahun harus 4 digit angka.";
    }
    return true;
}
/**
 * Validasi tanggal format YYYY-MM-DD
 */
function validasiTanggal($tanggal) {
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!($d && $d->format('Y-m-d') === $tanggal)) {
        return "Format tanggal tidak valid (gunakan YYYY-MM-DD)";
    }
    return true;
}
/**
 * Validasi email (jika diperlukan)
 */
function validasiEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid.";
    }
    return true;
}
function validasiHanyaHuruf($input, $nama_field) {
    if (!preg_match("/^[a-zA-Z\s]+$/", $input)) {
        return "$nama_field hanya boleh berisi huruf dan spasi.";
    }
    return true;
}
function validasiPanjangMaksimal($input, $maks, $nama_field) {
    if (strlen(trim($input)) > $maks) {
        return "$nama_field maksimal $maks karakter.";
    }
    return true;
}
function validasiNomorInduk($nomor, $panjang, $nama_field) {
    if (!preg_match("/^\d{{$panjang}}$/", $nomor)) {
        return "$nama_field harus berupa $panjang digit angka.";
    }
    return true;
}
function validasiAlamat($input, $nama_field) {
    if (!preg_match("/^[a-zA-Z0-9\s,.-]+$/", $input)) {
        return "$nama_field mengandung karakter tidak valid.";
    }
    return true;
}

?>

