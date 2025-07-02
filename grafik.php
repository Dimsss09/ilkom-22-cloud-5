<?php
// Memanggil file function.php untuk koneksi database
require 'function.php';

// Ambil data untuk Bar Chart (Penelitian per Tahun)
$barChartQuery = "SELECT tahun, COUNT(*) as jumlah FROM penelitian GROUP BY tahun";
$barChartResult = mysqli_query($conn, $barChartQuery);
$barChartData = [];
while ($row = mysqli_fetch_assoc($barChartResult)) {
    $barChartData[] = $row; // Menyimpan hasil query ke array
}

// Ambil data untuk Pie Chart (Penelitian per Kategori)
$pieChartQuery = "SELECT kategori.nama_kategori, COUNT(*) as jumlah FROM penelitian 
                  JOIN kategori ON penelitian.id_kategori = kategori.id_kategori 
                  GROUP BY penelitian.id_kategori";
$pieChartResult = mysqli_query($conn, $pieChartQuery);
$pieChartData = [];
while ($row = mysqli_fetch_assoc($pieChartResult)) {
    $pieChartData[] = $row; // Menyimpan hasil query ke array
}

// Ambil data untuk Line Chart (Penelitian per Fakultas)
$lineChartQuery = "SELECT fakultas.nama_fakultas, COUNT(*) as jumlah FROM penelitian 
                   JOIN fakultas ON penelitian.id_fakultas = fakultas.id_fakultas 
                   GROUP BY penelitian.id_fakultas";
$lineChartResult = mysqli_query($conn, $lineChartQuery);
$lineChartData = [];
while ($row = mysqli_fetch_assoc($lineChartResult)) {
    $lineChartData[] = $row; // Menyimpan hasil query ke array
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Bar Chart menggunakan Chart.js
    var ctxBar = document.getElementById('myBarChart').getContext('2d');
    var barChart = new Chart(ctxBar, {
        type: 'bar', // Jenis chart
        data: {
            labels: <?php echo json_encode(array_column($barChartData, 'tahun')); ?>, // Label sumbu X
            datasets: [{
                label: 'Jumlah Penelitian', // Label dataset
                data: <?php echo json_encode(array_column($barChartData, 'jumlah')); ?>, // Data jumlah penelitian per tahun
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna batang
                borderColor: 'rgba(75, 192, 192, 1)', // Warna garis batang
                borderWidth: 1 // Ketebalan garis
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true // Mulai dari nol pada sumbu Y
                }
            }
        }
    });

    // Inisialisasi Pie Chart menggunakan Chart.js
    var ctxPie = document.getElementById('myPieChart').getContext('2d');
    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_column($pieChartData, 'nama_kategori')); ?>, // Label kategori
            datasets: [{
                data: <?php echo json_encode(array_column($pieChartData, 'jumlah')); ?>, // Jumlah penelitian per kategori
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Warna masing-masing irisan pie
            }]
        }
    });

    // Inisialisasi Line Chart menggunakan Chart.js
    var ctxLine = document.getElementById('myAreaChart').getContext('2d');
    var lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($lineChartData, 'nama_fakultas')); ?>, // Label fakultas
            datasets: [{
                label: 'Jumlah Penelitian',
                data: <?php echo json_encode(array_column($lineChartData, 'jumlah')); ?>, // Jumlah penelitian per fakultas
                backgroundColor: 'rgba(153, 102, 255, 0.2)', // Warna isi grafik
                borderColor: 'rgba(153, 102, 255, 1)', // Warna garis
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true // Mulai dari 0 pada sumbu Y
                }
            }
        }
    });
});
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadata dasar HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Penelitian</title>
    <!-- CSS Bootstrap untuk styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chart-container {
            margin: 20px 0; /* Spasi atas dan bawah setiap chart */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Container untuk Bar Chart -->
        <div class="chart-container">
            <h2 class="text-center">Bar Chart - Penelitian per Tahun</h2>
            <canvas id="myBarChart"></canvas>
        </div>
        <!-- Container untuk Pie Chart -->
        <div class="chart-container">
            <h2 class="text-center">Pie Chart - Penelitian per Kategori</h2>
            <canvas id="myPieChart"></canvas>
        </div>
        <!-- Container untuk Line Chart -->
        <div class="chart-container">
            <h2 class="text-center">Line Chart - Penelitian per Fakultas</h2>
            <canvas id="myAreaChart"></canvas>
        </div>
    </div>

    <!-- Script tambahan: jQuery, Popper.js, Bootstrap JS, dan Chart.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
