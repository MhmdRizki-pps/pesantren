<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$total_santri = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE role = 'santri'"))['total'];
$ipa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE kelas = 'IPA' AND role = 'santri'"))['total'];
$ips = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE kelas = 'IPS' AND role = 'santri'"))['total'];
$lulus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE status = 'lulus' AND role = 'santri'"))['total'];
$tidak_lulus = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users WHERE status = 'tidak_lulus' AND role = 'santri'"))['total'];

$santri_tidak_lulus = mysqli_query($koneksi, "SELECT nama_lengkap, kelas, status FROM users WHERE status = 'tidak_lulus' AND role = 'santri' ORDER BY nama_lengkap ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grafik Penjurusan & Kelulusan</title>
    <link href="../sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
</head>
<body id="page-top">

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-chart-bar"></i></div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </a>
        <hr class="sidebar-divider my-0">
         <li class="nav-item">
            <a class="nav-link" href="grafik_pendaftaran.php"><i class="fas fa-chart-bar"></i><span> Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fas fa-pen"></i><span> Input Nilai</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="data_santri.php"><i class="fas fa-users"></i><span> Data Santri</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="grafik_penjurusan_kelulusan.php"><i class="fas fa-chart-pie"></i><span> Grafik Penjurusan</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a>
        </li>
    </ul>

    <!-- Content -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
                <span class="navbar-brand font-weight-bold text-primary">Grafik Penjurusan & Kelulusan</span>
            </nav>

            <div class="container-fluid">
                <!-- Info Cards -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Santri</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_santri ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah IPA</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ipa ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah IPS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ips ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tidak Lulus</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $tidak_lulus ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">Grafik Jurusan Santri</div>
                            <div class="card-body">
                                <canvas id="grafikJurusan"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-success text-white">Grafik Kelulusan</div>
                            <div class="card-body">
                                <canvas id="grafikKelulusan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Santri Tidak Lulus -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-danger text-white"><i class="fas fa-user-times"></i> Daftar Santri Tidak Lulus</div>
                    <div class="card-body">
                        <?php if(mysqli_num_rows($santri_tidak_lulus) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Jurusan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; while($row = mysqli_fetch_assoc($santri_tidak_lulus)) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                            <td><?= htmlspecialchars($row['kelas']); ?></td>
                                            <td><span class="badge badge-danger"><?= htmlspecialchars($row['status']); ?></span></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Tidak ada santri yang tidak lulus.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Scripts -->
<script>
    const ctxJurusan = document.getElementById('grafikJurusan').getContext('2d');
    new Chart(ctxJurusan, {
        type: 'bar',
        data: {
            labels: ['IPA', 'IPS'],
            datasets: [{
                label: 'Jumlah Santri',
                data: [<?= $ipa ?>, <?= $ips ?>],
                backgroundColor: ['#4e73df', '#1cc88a']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#000',
                    anchor: 'end',
                    align: 'top',
                    font: { weight: 'bold' }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const ctxKelulusan = document.getElementById('grafikKelulusan').getContext('2d');
    new Chart(ctxKelulusan, {
        type: 'pie',
        data: {
            labels: ['Lulus', 'Tidak Lulus'],
            datasets: [{
                data: [<?= $lulus ?>, <?= $tidak_lulus ?>],
                backgroundColor: ['#36b9cc', '#e74a3b']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    color: '#fff',
                    formatter: (value, ctx) => {
                        let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        return (value * 100 / sum).toFixed(1) + '%';
                    },
                    font: { weight: 'bold', size: 14 }
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>

</body>
</html>
