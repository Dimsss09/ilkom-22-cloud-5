<?php
// file_helper.php
// Kumpulan fungsi bantu untuk validasi dan proses upload file

/**
 * Mengecek apakah ekstensi file termasuk yang diizinkan
 *
 * @param string $filename Nama file yang diunggah
 * @param array $allowed Daftar ekstensi yang diperbolehkan
 * @return bool
 */
function ekstensiValid($filename, $allowed = ['jpg', 'png', 'pdf', 'jpeg']) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowed);
}

/**
 * Mengecek apakah ukuran file tidak melebihi batas maksimal
 *
 * @param int $sizeInBytes Ukuran file dalam byte
 * @param int $maxMB Batas ukuran maksimal dalam megabyte (MB)
 * @return bool
 */
function ukuranFileValid($sizeInBytes, $maxMB = 2) {
    $maxBytes = $maxMB * 1024 * 1024;
    return $sizeInBytes <= $maxBytes;
}

/**
 * Menyimpan file yang diunggah ke folder tujuan dengan nama unik
 *
 * @param string $fileInput Nama input file dari $_FILES
 * @param string $targetFolder Folder tujuan upload
 * @param string $prefix Awalan nama file hasil upload
 * @return array Informasi hasil upload (sukses, path, nama)
 */
function uploadFile($fileInput, $targetFolder = 'uploads/', $prefix = 'file_') {
    if (!isset($_FILES[$fileInput])) {
        return ['sukses' => false, 'pesan' => 'File tidak ditemukan'];
    }

    $file = $_FILES[$fileInput];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $newName = $prefix . time() . rand(100, 999) . '.' . $ext;
    $targetPath = rtrim($targetFolder, '/') . '/' . $newName;

    // Memindahkan file dari folder sementara ke folder tujuan
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['sukses' => false, 'pesan' => 'Gagal upload file'];
    }

    return ['sukses' => true, 'path' => $targetPath, 'nama' => $newName];
}
