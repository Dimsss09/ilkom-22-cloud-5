<?php
function validasiTidakKosong($input, $nama_field) {
    if (empty(trim($input))) {
        return "$nama_field tidak boleh kosong.";
    }
    return true;
}
function validasiPanjangMinimal($input, $min, $nama_field) {
    if (strlen(trim($input)) < $min) {
        return "$nama_field minimal $min karakter.";
    }
    return true;
}
function validasiTahun($tahun) {
    if (!preg_match("/^\d{4}$/", $tahun)) {
        return "Tahun harus 4 digit angka.";
    }
    return true;
}
function validasiTanggal($tanggal) {
    $d = DateTime::createFromFormat('Y-m-d', $tanggal);
    if (!($d && $d->format('Y-m-d') === $tanggal)) {
        return "Format tanggal tidak valid (gunakan YYYY-MM-DD)";
    }
    return true;
}

function validasiEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid.";
    }
    return true;
}
?>

