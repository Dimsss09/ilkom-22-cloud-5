<?php
require 'function.php';

$zip = new ZipArchive();
$filename = "semua_file_penelitian.zip";

if ($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    exit("Tidak dapat membuat file ZIP.");
}

$result = mysqli_query($conn, "SELECT nama_file FROM file_penelitian");
while ($row = mysqli_fetch_assoc($result)) {
    $filePath = "uploads/" . $row['nama_file'];
    if (file_exists($filePath)) {
        $zip->addFile($filePath, $row['nama_file']);
    }
}

$zip->close();

header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename=$filename");
readfile($filename);
unlink($filename);
exit;
?>
