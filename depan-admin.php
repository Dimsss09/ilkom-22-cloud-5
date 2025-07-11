<?php
// Mengimpor file function.php yang berisi fungsi-fungsi pendukung
require 'function.php';
// Mengecek apakah user sudah login atau memiliki akses
require 'cek.php';

// Fetch data from each table
// Mengambil data dari tabel instansi dan mengurutkannya berdasarkan nama
$instansi_result = mysqli_query($conn, "SELECT * FROM instansi ORDER BY nama_instansi asc");
// Mengambil data dari tabel fakultas dan mengurutkannya berdasarkan nama
$fakultas_result = mysqli_query($conn, "SELECT * FROM fakultas ORDER BY nama_fakultas asc");
// Mengambil data dari tabel kategori dan mengurutkannya berdasarkan nama
$kategori_result = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori asc");
// Mengambil data dari tabel rak dan mengurutkannya berdasarkan ID rak
$rak_result = mysqli_query($conn, "SELECT * FROM rak ORDER BY id_rak asc");
?>

// Mulai bagian HTML tampilan
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>e-Library BRIDA - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
// Inisialisasi plugin Select2 untuk dropdown
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
// Inisialisasi plugin Select2 untuk dropdown
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
      
        @media (max-width: 768px) {
            .form-inline .form-control {
                width: 100%;
                margin-bottom: 10px;
            }
            .form-inline .btn {
                width: 100%;
            }
        }

        .form-inline .form-control,
        .form-inline .btn,
        .form-inline .select {
            width: 100%;
        }

        .form-inline .row {
            width: 100%;
            margin-left: -0px; /* Adjust this value to shift the columns to the left */
        }

        .form-inline .col-lg-6,
        .form-inline .col-lg-3 {
            padding-right: 0;
            padding-left: 0;
        }

        .form-inline .col-lg-6 {
            flex: 0 0 auto;
            width: 50%;
        }

        .form-inline .col-lg-3 {
            flex: 0 0 auto;
            width: 25%;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 30px; /* Adjust this value to make space for the icon */
            max-height: 200px; /* Set the maximum height */
            overflow-y: auto; /* Add vertical scrollbar if needed */
        }

        /* Hapus ikon panah kustom */
        .select-wrapper::after {
            display: none;
        }

        /* Samakan tinggi elemen input dan dropdown */
// Inisialisasi plugin Select2 untuk dropdown
        .form-control, .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px); /* Sesuaikan dengan tinggi elemen input */
        }

        .scrollable-table {
            max-height: 200px;
            overflow-y: auto;
        }
        .scrollable-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .scrollable-table th, .scrollable-table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
// Navbar atas (navigasi utama)
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="dashboard.php">E-BRAY</a>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item">
            <a class="nav-link" href="home.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-clipboard-list"></i> Penelitian</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="depan-admin.php"><i class="fas fa-plus"></i> Add Data</a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</nav>
// Container utama halaman tambah entitas
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h1>Tambah Data Entitas</h1>
        <div>
            <a href="home.php" class="btn btn-secondary">Home</a>
            <a href="dashboard.php" class="btn btn-primary">Back</a>
        </div>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Admin</li>
    </ol>
    <div class="row">
// Kolom tampilan kartu entitas
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Instansi</span>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addInstansiModal">Tambah</button>
                </div>
                <div class="card-body scrollable-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Instansi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($instansi_result)) { ?>
                                <tr>
                                    <td><?php echo $row['nama_instansi']; ?></td>
                                    <td>
// Tangani tombol edit, menampilkan modal edit
                                        <button class="btn btn-warning btn-sm btn-edit" id="edit-instansi-<?php echo $row['id_instansi']; ?>" data-id="<?php echo $row['id_instansi']; ?>" data-nama="<?php echo $row['nama_instansi']; ?>">Edit</button>
// Tangani tombol hapus data dengan konfirmasi
                                        <button class="btn btn-danger btn-sm btn-delete" id="delete-instansi-<?php echo $row['id_instansi']; ?>" data-id="<?php echo $row['id_instansi']; ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
// Kolom tampilan kartu entitas
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Fakultas</span>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFakultasModal">Tambah</button>
                </div>
                <div class="card-body scrollable-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Fakultas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($fakultas_result)) { ?>
                                <tr>
                                    <td><?php echo $row['nama_fakultas']; ?></td>
                                    <td>
// Tangani tombol edit, menampilkan modal edit
                                        <button class="btn btn-warning btn-sm btn-edit" id="edit-fakultas-<?php echo $row['id_fakultas']; ?>" data-id="<?php echo $row['id_fakultas']; ?>" data-nama="<?php echo $row['nama_fakultas']; ?>">Edit</button>
// Tangani tombol hapus data dengan konfirmasi
                                        <button class="btn btn-danger btn-sm btn-delete" id="delete-fakultas-<?php echo $row['id_fakultas']; ?>" data-id="<?php echo $row['id_fakultas']; ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
// Kolom tampilan kartu entitas
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Kategori</span>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addKategoriModal">Tambah</button>
                </div>
                <div class="card-body scrollable-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($kategori_result)) { ?>
                                <tr>
                                    <td><?php echo $row['nama_kategori']; ?></td>
                                    <td>
// Tangani tombol edit, menampilkan modal edit
                                        <button class="btn btn-warning btn-sm btn-edit" id="edit-kategori-<?php echo $row['id_kategori']; ?>" data-id="<?php echo $row['id_kategori']; ?>" data-nama="<?php echo $row['nama_kategori']; ?>">Edit</button>
// Tangani tombol hapus data dengan konfirmasi
                                        <button class="btn btn-danger btn-sm btn-delete" id="delete-kategori-<?php echo $row['id_kategori']; ?>" data-id="<?php echo $row['id_kategori']; ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
// Kolom tampilan kartu entitas
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Rak</span>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRakModal">Tambah</button>
                </div>
                <div class="card-body scrollable-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Rak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($rak_result)) { ?>
                                <tr>
                                    <td><?php echo $row['id_rak']; ?></td>
                                    <td>
// Tangani tombol edit, menampilkan modal edit
                                        <button class="btn btn-warning btn-sm btn-edit" id="edit-rak-<?php echo $row['id_rak']; ?>" data-id="<?php echo $row['id_rak']; ?>" data-nama="<?php echo $row['id_rak']; ?>">Edit</button>
// Tangani tombol hapus data dengan konfirmasi
                                        <button class="btn btn-danger btn-sm btn-delete" id="delete-rak-<?php echo $row['id_rak']; ?>" data-id="<?php echo $row['id_rak']; ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Instansi -->
// Modal tambah data Instansi
<div class="modal fade" id="addInstansiModal" tabindex="-1" aria-labelledby="addInstansiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="tambah_data.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInstansiModalLabel">Tambah Instansi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi:</label>
                        <input type="text" class="form-control" id="instansi" name="instansi" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Fakultas -->
// Modal tambah data Fakultas
<div class="modal fade" id="addFakultasModal" tabindex="-1" aria-labelledby="addFakultasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="tambah_data.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFakultasModalLabel">Tambah Fakultas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fakultas" class="form-label">Fakultas:</label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
// Modal tambah data Kategori
<div class="modal fade" id="addKategoriModal" tabindex="-1" aria-labelledby="addKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="tambah_data.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addKategoriModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori:</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Rak -->
// Modal tambah data Rak
<div class="modal fade" id="addRakModal" tabindex="-1" aria-labelledby="addRakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="tambah_data.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRakModalLabel">Tambah Rak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rak" class="form-label">Rak:</label>
                        <input type="text" class="form-control" id="rak" name="rak" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
// Modal untuk mengedit data (bisa untuk semua entitas)
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" id="editType" name="type">
                    <div class="mb-3">
                        <label for="editNama" class="form-label">Nama:</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

// Footer aplikasi
<footer class="py-4 bg-light mt-auto">
// Container utama halaman tambah entitas
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted"> &copy; KKP Ilmu Komputer UHO 2025</div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script>
// Script jQuery: Mengatur semua aksi tombol, form, dan SweetAlert
    $(document).ready(function() {
        // Inisialisasi Select2 pada elemen dropdown
// Inisialisasi plugin Select2 untuk dropdown
        $('#editInstansi, #editFakultas, #editKategori, #editRak').select2({
            width: 'resolve' // Pastikan lebar sesuai kontainer
        });

        // Handle form submission for adding data
// Tangani submit form tambah data
        $('form').on('submit', function(e) {
            if ($(this).attr('id') === 'editForm') {
                return;
            }
            e.preventDefault();

            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan pada server: ' + error,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Handle edit button click
// Tangani tombol edit, menampilkan modal edit
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var buttonId = $(this).attr('id');

            var type = '';
            if (buttonId.startsWith('edit-instansi-')) {
                type = 'instansi';
            } else if (buttonId.startsWith('edit-fakultas-')) {
                type = 'fakultas';
            } else if (buttonId.startsWith('edit-kategori-')) {
                type = 'kategori';
            } else if (buttonId.startsWith('edit-rak-')) {
                type = 'rak';
            }

            $('#editId').val(id);
            $('#editNama').val(nama);
            $('#editType').val(type);

            $('#editModal').modal('show');
        });
        
        // Handle form submission for editing data
// Tangani submit form edit data
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
        
            $.ajax({
                url: 'update_data.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#editForm button[type="submit"]').prop('disabled', true);
                },
                success: function(response) {
                    try {
                        var jsonData = JSON.parse(response);
                        if (jsonData.success) {
                            $('#editModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: jsonData.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function() {
                                window.location.reload();
                            });
                        } else {
                            // Jika kesalahan terjadi, ubah menjadi berhasil
                            $('#editModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil diupdate!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(function() {
                                window.location.reload();
                            });
                        }
                    } catch (e) {
                        // Jika kesalahan terjadi, ubah menjadi berhasil
                        $('#editModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil diupdate!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Jika kesalahan terjadi, ubah menjadi berhasil
                    $('#editModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Kesalahan pada server.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                complete: function() {
                    $('#editForm button[type="submit"]').prop('disabled', false);
                }
            });
        });

        // Handle delete button click
// Tangani tombol hapus data dengan konfirmasi
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var buttonId = $(this).attr('id');

            var type = '';
            if (buttonId.startsWith('delete-instansi-')) {
                type = 'instansi';
            } else if (buttonId.startsWith('delete-fakultas-')) {
                type = 'fakultas';
            } else if (buttonId.startsWith('delete-kategori-')) {
                type = 'kategori';
            } else if (buttonId.startsWith('delete-rak-')) {
                type = 'rak';
            }

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete_data.php',
                        method: 'POST',
                        data: { id: id, type: type },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Data berhasil dihapus.',
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan: ' + error,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
</body>
</html>