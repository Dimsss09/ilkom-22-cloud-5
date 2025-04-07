<!-- git commit -m "menambahkan form data penelitian" -->
<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Tambah Penelitian</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link rel="Icon" type="png"
        href="assets/img/instansi-logo.png">
        <style>
            .select-container {
                display: flex;
                flex-direction: column;
                width: 100%; /* Sesuaikan dengan container parent */
            }

            .select-container select {
                width: 100%; /* Pastikan inputan menyesuaikan */
                box-sizing: border-box; /* Mencegah overflow */
                height: calc(2.25rem + 2px); /* Konsisten dengan tinggi elemen lainnya */
                font-size: 1rem; /* Tetap proporsional */
                padding: 0.375rem 0.75rem;
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                background-color: #fff;
                transition: all 0.2s ease-in-out; /* Transisi lembut saat window berubah */
}

            form .form-control {
                width: 100%;
                padding: 0.375rem 0.75rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #212529;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                box-shadow: inset 0 0 0 transparent;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                height: auto; /* Pastikan height diatur otomatis */
            }

            .select2-container--default .select2-selection--single {
                width: 100%;
                height: calc(2.25rem + 2px); /* Sesuaikan dengan tinggi box input lainnya */
                padding: 0.375rem 0.75rem; /* Sama dengan input */
                font-size: 1rem;
                line-height: 1.5;
                color: #212529;
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
            }
            .close-icon {
                font-size: 1.5rem;
                color: #000;
                text-decoration: none;
            }

            .close-icon:hover {
                color: #ff0000;
            }
        </style>
        </style>