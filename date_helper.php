<?php
// date_helper.php
// Kumpulan fungsi bantu untuk manipulasi dan format tanggal

/**
 * Mengubah format tanggal Y-m-d menjadi format Indonesia (d M Y)
 * Contoh: 2025-06-28 → 28 Juni 2025
 */
function formatTanggalIndo($tanggal) {
    $bulanIndo = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulanIndo[$pecah[1]] . ' ' . $pecah[0];
}

/**
 * Mendapatkan nama hari dari tanggal
 * Contoh: 2025-06-28 → Sabtu
 */
function namaHari($tanggal) {
    $hari = date('N', strtotime($tanggal));
    $namaHari = [
        1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
        4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'
    ];
    return $namaHari[$hari];
}

/**
 * Menghitung jumlah hari antara dua tanggal
 */
function selisihHari($tanggalAwal, $tanggalAkhir) {
    $start = new DateTime($tanggalAwal);
    $end = new DateTime($tanggalAkhir);
    return $start->diff($end)->days;
}

/**
 * Mendapatkan tanggal hari ini dalam format Indonesia
 */
function tanggalHariIniIndo() {
    return formatTanggalIndo(date('Y-m-d'));
}
