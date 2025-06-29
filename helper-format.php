<?php
// helper-format.php

/**
 * Format string ke huruf kapital di awal kata
 */
function formatTitleCase($string) {
    return ucwords(strtolower(trim($string)));
}

/**
 * Format tanggal Indonesia dari YYYY-MM-DD ke DD/MM/YYYY
 */
function formatTanggalIndo($tanggal) {
    $date = date_create($tanggal);
    return date_format($date, 'd/m/Y');
}
?>
 
