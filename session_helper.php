<?php
// response_helper.php

// 1. Response JSON sederhana
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

// 2. Response HTML sederhana
function kirimResponseHTML($pesan, $kembaliKe = null) {
    echo "<div style='padding:1em;background:#eee;border:1px solid #ccc;margin:2em auto;width:90%;max-width:500px;'>$pesan</div>";
    if ($kembaliKe) {
        echo "<div style='text-align:center;'><a href='$kembaliKe'>Kembali</a></div>";
    }
    exit;
}

// 3. Response HTML dengan redirect otomatis
function kirimResponseRedirect($pesan, $tujuan, $delay = 2) {
    echo "<div style='padding:1em;background:#eef;border:1px solid #99f;margin:2em auto;width:90%;max-width:500px;'>$pesan</div>";
    echo "<meta http-equiv='refresh' content='$delay;url=$tujuan'>";
    exit;
}

// 4. JSON dengan kode HTTP tertentu
function kirimResponseCodeJSON($statusCode, $pesan, $data = null) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    $res = ['status' => $statusCode, 'pesan' => $pesan];
    if ($data !== null) {
        $res['data'] = $data;
    }
    echo json_encode($res);
    exit;
}

// 5. Kirim file untuk didownload
function kirimResponseFile($filePath, $namaFileUnduh = null) {
    if (!file_exists($filePath)) {
        kirimResponseHTML("File tidak ditemukan: $filePath");
    }

    $namaFileUnduh = $namaFileUnduh ?: basename($filePath);

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$namaFileUnduh\"");
    header("Content-Length: " . filesize($filePath));
    readfile($filePath);
    exit;
}
