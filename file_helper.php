<?php
// file_helper.php
// Fungsi bantu untuk validasi dan upload file

/**
 * Cek ekstensi file apakah valid
 */
function ekstensiValid($filename, $allowed = ['jpg', 'png', 'pdf', 'jpeg']) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowed);
}

/**
 * Cek apakah ukuran file melebihi batas (dalam MB)
 */
function ukuranFileValid($sizeInBytes, $maxMB = 2) {
    $maxBytes = $maxMB * 1024 * 1024;
    return $sizeInBytes <= $maxBytes;
}

/**
 * Upload file ke direktori tertentu
 */
function uploadFile($fileInput, $targetFolder = 'uploads/', $prefix = 'file_') {
    if (!isset($_FILES[$fileInput])) {
        return ['sukses' => false, 'pesan' => 'File tidak ditemukan'];
    }

    $file = $_FILES[$fileInput];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $newName = $prefix . time() . rand(100, 999) . '.' . $ext;
    $targetPath = rtrim($targetFolder, '/') . '/' . $newName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['sukses' => false, 'pesan' => 'Gagal upload file'];
    }

    return ['sukses' => true, 'path' => $targetPath, 'nama' => $newName];
}
