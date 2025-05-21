<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$result = mysqli_query($koneksi, "
    SELECT DATE(created_at) AS tanggal, COUNT(*) AS jumlah
    FROM users
    WHERE role = 'santri'
    GROUP BY tanggal
    ORDER BY tanggal
");

$data_tanggal = [];
$data_jumlah = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data_tanggal[] = $row['tanggal'];
    $data_jumlah[] = $row['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grafik Pendaftaran Santri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SB Admin 2 CSS -->
    <link href="../sb_admin_2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Styling -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
        .card-header {
            background: linear-gradient(to right, #36b9cc, #4e73df);
            color: white;
            font-weight: bold;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 18px;
            color: #4e73df;
        }
        .sidebar .nav-item.active .nav-link {
            background-color: #4e73df;
        }
        .chart-container {
            position: relative;
            height: 400px;
        }
    </style>
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-chart-line"></i></div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </a>

        <hr class="sidebar-divider">

        <li class="nav-item active">
            <a class="nav-link" href="grafik_pendaftaran.php"><i class="fas fa-chart-bar"></i><span> Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-pen"></i><span> Input Nilai</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="data_santri.php"><i class="fas fa-users"></i><span> Data Santri</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="grafik_penjurusan_kelulusan.php"><i class="fas fa-chart-pie"></i><span> Grafik Penjurusan</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a>
        </li>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Top Bar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar shadow mb-4">
                <span class="navbar-brand">📈 Grafik Pendaftaran Santri per Tanggal</span>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-calendar-alt"></i> Data Pendaftaran</h1>

                <!-- Chart Card -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-line"></i> Grafik Pendaftaran per Tanggal
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="pendaftaranTanggalChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Container -->

        </div>
    </div>
</div>

<!-- Chart Script -->
<script>
const ctx = document.getElementById('pendaftaranTanggalChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($data_tanggal) ?>,
        datasets: [{
            label: 'Jumlah Pendaftaran',
            data: <?= json_encode($data_jumlah) ?>,
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Jumlah Pendaftaran Santri per Hari',
                font: {
                    size: 18
                }
            },
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Pendaftaran'
                },
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>

<!-- Scripts -->
<script src="../sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="../sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../sb_admin_2/js/sb-admin-2.min.js"></script>

</body>
</html>
