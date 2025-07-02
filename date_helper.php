<?php
// date_helper.php
// Kumpulan fungsi bantu untuk manipulasi dan format tanggal dengan gaya Indonesia

/**
 * Mengubah format tanggal dari Y-m-d (format database)
 * menjadi format tanggal Indonesia: d [Nama Bulan] Y
 * 
 * Contoh: "2025-06-28" → "28 Juni 2025"
 *
 * @param string $tanggal Format: YYYY-MM-DD
 * @return string Tanggal dalam format lokal
 */
function formatTanggalIndo($tanggal) {
    $bulanIndo = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
        '04' => 'April', '05' => 'Mei', '06' => 'Juni',
        '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
    ];

    // Pecah tanggal menjadi array: [YYYY, MM, DD]
    $pecah = explode('-', $tanggal);
    return $pecah[2] . ' ' . $bulanIndo[$pecah[1]] . ' ' . $pecah[0];
}

/**
 * Mengambil nama hari dari tanggal tertentu
 *
 * Contoh: "2025-06-28" → "Sabtu"
 *
 * @param string $tanggal Format: YYYY-MM-DD
 * @return string Nama hari dalam Bahasa Indonesia
 */
function namaHari($tanggal) {
    $hari = date('N', strtotime($tanggal)); // 1 (Senin) sampai 7 (Minggu)
    $namaHari = [
        1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu',
        4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'
    ];
    return $namaHari[$hari];
}

/**
 * Menghitung selisih jumlah hari antara dua tanggal
 *
 * Contoh: selisihHari("2025-06-01", "2025-06-10") → 9
 *
 * @param string $tanggalAwal Format: YYYY-MM-DD
 * @param string $tanggalAkhir Format: YYYY-MM-DD
 * @return int Jumlah hari antara dua tanggal
 */
function selisihHari($tanggalAwal, $tanggalAkhir) {
    $start = new DateTime($tanggalAwal);
    $end = new DateTime($tanggalAkhir);
    return $start->diff($end)->days;
}

/**
 * Mengambil tanggal hari ini dan menampilkannya dalam format Indonesia
 *
 * Contoh: "2025-07-01" → "1 Juli 2025"
 *
 * @return string Tanggal hari ini dalam format lokal
 */
function tanggalHariIniIndo() {
    return formatTanggalIndo(date('Y-m-d'));
}
