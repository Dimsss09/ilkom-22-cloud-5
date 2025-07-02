<?php
// string_helper.php
// Kumpulan fungsi bantu untuk manipulasi string dalam aplikasi

/**
 * Membuat slug dari teks, cocok untuk URL SEO friendly.
 * Contoh: "Judul Artikel Baru!" → "judul-artikel-baru"
 */
function slugify($text) {
    // Ganti karakter non-huruf/angka dengan tanda -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Ubah karakter khusus menjadi ASCII
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Hapus karakter selain huruf, angka, dan strip
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Hapus tanda - di awal/akhir
    $text = trim($text, '-');
    // Ganti beberapa tanda - yang berurutan jadi satu
    $text = preg_replace('~-+~', '-', $text);
    return strtolower($text);
}

/**
 * Mengubah semua kata menjadi kapital di awal hurufnya.
 * Contoh: "hello world" → "Hello World"
 */
function capitalizeWords($text) {
    return ucwords(strtolower($text));
}

/**
 * Memotong string jika melebihi panjang maksimal.
 * Contoh: "Ini adalah kalimat yang sangat panjang..." → "Ini adalah kalimat..."
 */
function truncateText($text, $max = 100) {
    return strlen($text) > $max ? substr($text, 0, $max) . '...' : $text;
}

/**
 * Menghasilkan string acak sepanjang n karakter.
 * Cocok untuk kode token, password sementara, dll.
 */
function randomString($length = 10) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
}
