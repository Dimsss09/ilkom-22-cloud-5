<?php
require 'function.php';
require 'cek.php';

// Fetch data for Bar Chart (Penelitian per Bulan dan Tahun)
$currentYear = date('Y');
$startYear = $currentYear - 3;

$barChartQuery = "SELECT 
    tahun,
    LPAD(MONTH(tgl_masuk), 2, '0') as bulan,
    COUNT(*) as jumlah 
FROM penelitian 
WHERE tahun BETWEEN $startYear AND $currentYear 
GROUP BY tahun, bulan 
ORDER BY tahun, bulan";

$barChartResult = mysqli_query($conn, $barChartQuery);
$barChartData = [];
while ($row = mysqli_fetch_assoc($barChartResult)) {
    $barChartData[] = $row;
}

// Fetch data for Pie Chart (Penelitian per Kategori)
$pieChartQuery = "SELECT kategori.nama_kategori, COUNT(*) as jumlah 
                  FROM penelitian 
                  INNER JOIN kategori ON penelitian.id_kategori = kategori.id_kategori 
                  GROUP BY kategori.nama_kategori";
$pieChartResult = mysqli_query($conn, $pieChartQuery);
$pieChartData = [];
while ($row = mysqli_fetch_assoc($pieChartResult)) {
    $pieChartData[] = $row;
}

// Fetch total count of all Penelitian
$totalPenelitianQuery = "SELECT COUNT(*) as total FROM penelitian";
$totalPenelitianResult = mysqli_query($conn, $totalPenelitianQuery);
$totalPenelitianData = mysqli_fetch_assoc($totalPenelitianResult);
$totalPenelitian = $totalPenelitianData['total'];

// Fetch data for Bar Chart (Penelitian per Instansi)
$instansiChartQuery = "SELECT instansi.nama_instansi, COUNT(*) as jumlah 
                       FROM penelitian 
                       INNER JOIN instansi ON penelitian.id_instansi = instansi.id_instansi 
                       GROUP BY instansi.nama_instansi 
                       ORDER BY jumlah DESC";
$instansiChartResult = mysqli_query($conn, $instansiChartQuery);
$instansiChartData = [];
while ($row = mysqli_fetch_assoc($instansiChartResult)) {
    $instansiChartData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Ebray - ADMIN</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="Icon" type="png"
        href="assets/img/instansi-logo.png">
        <style>
            .table-responsive {
                overflow-x: auto;
            }

            table.table {
                min-width: 1000px; 
            }
            .navbar-dark .navbar-nav .nav-link {
                color: rgba(255, 255, 255, 0.9);
            }
            .navbar-dark .navbar-nav .nav-link:hover {
                color: rgba(255, 255, 255, 1);
            }

            .navbar-collapse {
                background-color: #212529; /* Same as navbar background */
            }

            .navbar-collapse .navbar-nav {
                margin-left: 0;
            }

            /* Garis horizontal hanya muncul saat window diperkecil */
            @media (max-width: 992px) { /* Untuk tablet & mobile */
                .navbar-brand {
                    display: block;
                    padding-bottom: 12px;
                    margin-bottom: 12px;
                    border-bottom: 1.5px solid rgba(255, 255, 255, 0.1); /* Garis horizontal */
                }
            }
            #pdfModal .modal-dialog {
                max-width: 80vw; /* Sesuaikan lebar modal */
                max-height: 80vh; /* Batasi tinggi modal */
                margin: 10vh auto; /* Beri jarak atas dan bawah */
            }

            #pdfModal .modal-content {
                height: 80vh; /* Batasi tinggi modal agar tidak melebihi layar */
                overflow: hidden; /* Hilangkan overflow agar modal tidak tembus ke bawah */
            }

            #pdfModal .modal-body {
                height: calc(80vh - 56px - 10px); /* 80% tinggi layar dikurangi tinggi header */
                overflow-y: auto; /* Tambahkan scroll jika konten lebih besar */
            }
        </style>
        </head>
        <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="dashboard.php">E-BRAY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"><i class="fas fa-book"></i> Panduan</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div style="margin-top: 56px;"></div>
        <div id="layoutSidenav_content">
        <script>
            $(document).ready(function() {
                var isNavbarOpen = false;
                
                $('.navbar-toggler').click(function(e) {
                    e.preventDefault();
                    isNavbarOpen = !isNavbarOpen;
                    
                    if (isNavbarOpen) {
                        $('.navbar-collapse').collapse('show');
                    } else {
                        $('.navbar-collapse').collapse('hide');
                    }
                    
                    // Tambahkan class active ke tombol toggler
                    $(this).toggleClass('active');
                });

                // Tutup navbar saat mengklik link
                $('.nav-link').click(function() {
                    if (isNavbarOpen) {
                        isNavbarOpen = false;
                        $('.navbar-collapse').collapse('hide');
                        $('.navbar-toggler').removeClass('active');
                    }
                });

                // Tutup navbar saat mengklik di luar
                $(document).click(function(event) {
                    var clickover = $(event.target);
                    var _opened = $(".navbar-collapse").hasClass("show");
                    
                    if (_opened === true && !clickover.hasClass("navbar-toggler") && 
                        !clickover.hasClass("navbar-toggler-icon") && 
                        !clickover.closest('.navbar-collapse').length) {
                        
                        isNavbarOpen = false;
                        $('.navbar-collapse').collapse('hide');
                        $('.navbar-toggler').removeClass('active');
                    }
                });
            });
            </script>
        <!-- Modal -->
        <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Panduan PDF</h5>
                        <a href="gemini-chat.php" class="btn btn-success ms-3">
                            <i class="bi bi-robot"></i> Tanya AI
                        </a>
                        <a href="panduan.php?download=1" class="btn btn-primary ms-3">
                            <i class="bi bi-cloud-download"></i> Unduh
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="pdfImagesContainer"></div>
                    </div>
                </div>
            </div>
        </div>
        <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                    <div class="row">
                        <!-- Stats Cards -->
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    JUMLAH KESELURUHAN PENELITIAN
                                    <h2><?= $totalPenelitian; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body">
                                    JUMLAH PENELITIAN BRIDA
                                    <h2>
                                        <?php
                                        $bridaCount = 0;
                                        foreach ($pieChartData as $data) {
                                            if ($data['nama_kategori'] === 'BRIDA') {
                                                $bridaCount = $data['jumlah'];
                                                break;
                                            }
                                        }
                                        echo $bridaCount;
                                        ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    JUMLAH PENELITIAN NON-BRIDA
                                    <h2>
                                        <?php
                                        $nonBridaCount = 0;
                                        foreach ($pieChartData as $data) {
                                            if ($data['nama_kategori'] !== 'BRIDA') {
                                                $nonBridaCount += $data['jumlah'];
                                            }
                                        }
                                        echo $nonBridaCount;
                                        ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4 h-100">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Jumlah Penelitian per Kategori
                                </div>
                                <div class="card-body"><canvas id="pieChart" style="max-height: 300px;"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4 h-100">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Tren Penelitian per Bulan dan Tahun
                                </div>
                                <div class="card-body"><canvas id="barChart" style="max-height: 300px;"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4 h-100">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Jumlah Penelitian per Instansi
                                </div>
                                <div class="card-body"><canvas id="instansiChart" style="max-height: 300px;"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <!-- Rest of your dashboard content -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Latest Data
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped table-bordered" id="data-table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Nama Penulis</th>
                                        <th>Instansi</th>
                                        <th>Fakultas</th>
                                        <th>Tahun</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; KKP Ilmu Komputer UHO 2025</div>
                    </div>
                </div>
            </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                fetchTableData();

                function fetchTableData() {
                    $.ajax({
                        url: 'search.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            page_type: 'depan'
                        },
                        success: function(data) {
                            try {
                                $('#data-table tbody').html(data.data);
                                $('#pagination').html(data.pagination);
                                $('#data-info').html(data.info);
                            } catch (e) {
                                console.error("Parsing error:", e);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX error:", status, error);
                        }
                    });
                }
                
                // Process bar chart data
                const rawData = <?= json_encode($barChartData) ?>;
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                
                // Ambil tahun saat ini
                const currentYear = new Date().getFullYear();
                const minYear = currentYear - 2; // Ambil 3 tahun terakhir

                // Pastikan setiap tahun memiliki array kosong (diisi 0)
                const processedData = {};

                // Inisialisasi semua tahun dengan array 12 bulan berisi 0
                for (let year = minYear; year <= currentYear; year++) {
                    processedData[year] = Array(12).fill(0);
                }

                // Proses data dari rawData
                rawData.forEach(item => {
                    const year = parseInt(item.tahun);
                    const month = parseInt(item.bulan) - 1; // Convert ke index 0-based
                    const count = parseInt(item.jumlah);
                    
                    if (year >= minYear && year <= currentYear) {
                        processedData[year][month] = count;
                    }
                });


                // Create datasets for each year
                const datasets = Object.entries(processedData).map(([year, counts]) => ({
                    label: `Tahun ${year}`,
                    data: counts,
                    borderColor: `hsl(${Math.random() * 360}, 70%, 50%)`,
                    fill: false,
                    tension: 0.4
                }));

                // Create bar chart
                const barCtx = document.getElementById('barChart').getContext('2d');
                new Chart(barCtx, {
                    type: 'line',
                    data: {
                        labels: monthNames,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Tren Penelitian per Bulan dan Tahun'
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Penelitian'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            }
                        }
                    }
                });

                // Process instansi chart data
                const instansiLabels = <?= json_encode(array_column($instansiChartData, 'nama_instansi')); ?>;
                const instansiData = <?= json_encode(array_column($instansiChartData, 'jumlah')); ?>;

                // Create bar chart for instansi data
                const instansiCtx = document.getElementById('instansiChart').getContext('2d');
                new Chart(instansiCtx, {
                    type: 'bar',
                    data: {
                        labels: instansiLabels,
                        datasets: [{
                            label: 'Jumlah Penelitian',
                            data: instansiData,
                            backgroundColor: 'rgba(75, 192, 192, 1)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis : 'y',
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Jumlah Penelitian per Instansi'
                            },
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Penelitian'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Instansi'
                                }
                            }
                        }
                    }
                });

                // Create pie chart
                const pieChartLabels = <?= json_encode(array_column($pieChartData, 'nama_kategori')); ?>;
                const pieChartData = <?= json_encode(array_column($pieChartData, 'jumlah')); ?>;

                const pieCtx = document.getElementById('pieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: pieChartLabels,
                        datasets: [{
                            data: pieChartData,
                            backgroundColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let pdfUrl = "panduan.php"; // Ambil PDF dari server privat

                let loadingTask = pdfjsLib.getDocument(pdfUrl);
                loadingTask.promise.then(function (pdf) {
                    console.log("PDF loaded");

                    let container = document.getElementById("pdfImagesContainer");
                    container.innerHTML = ""; // Kosongkan sebelum menambahkan gambar baru

                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        pdf.getPage(pageNum).then(function (page) {
                            let scale = 5; // Ubah skala untuk resolusi lebih tinggi
                            let viewport = page.getViewport({ scale: scale });

                            let canvas = document.createElement("canvas");
                            let context = canvas.getContext("2d");
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;

                            let renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };

                            page.render(renderContext).promise.then(function () {
                                let img = document.createElement("img");
                                img.src = canvas.toDataURL("image/png"); // Ubah canvas ke gambar PNG
                                img.style.width = "100%"; // Sesuaikan lebar
                                container.appendChild(img);
                            });
                        });
                    }
                });
            });
        </script>
    </body>
</html>