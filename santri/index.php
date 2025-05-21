<?php
session_start();
include '../config/koneksi.php';

// Cek login & role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'santri') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['id'];

// Ambil data nilai santri
$query = mysqli_query($koneksi, "
    SELECT u.nama_lengkap, u.status, u.kelas,
           n.akademik, n.non_akademik, n.iq, n.agama,
           u.rata_rata
    FROM users u
    LEFT JOIN nilai n ON u.id = n.user_id
    WHERE u.id = '$user_id'
");

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Santri</title>
    <link href="../sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="sidebar-brand-text mx-3">Santri</div>
        </a>

        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="index.php"><i class="fas fa-file-alt"></i> <span>Hasil Ujian</span></a>
        </li>
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
        </li>
    </ul>

    <!-- Content -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
                <span class="h5 mb-0 text-gray-800 ml-2">Selamat datang, <?= htmlspecialchars($_SESSION['nama']); ?></span>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid">
                <h4 class="mb-4 text-gray-800"><i class="fas fa-clipboard-list"></i> Hasil Ujian Anda</h4>

                <?php if ($data['akademik'] === null): ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Nilai belum diinput oleh guru. Silakan cek kembali nanti.
                    </div>
                <?php else: ?>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <tr><th>Nama Lengkap</th><td><?= htmlspecialchars($data['nama_lengkap']); ?></td></tr>
                                <tr><th>Nilai Akademik</th><td><?= $data['akademik']; ?></td></tr>
                                <tr><th>Nilai Non-Akademik</th><td><?= $data['non_akademik']; ?></td></tr>
                                <tr><th>IQ</th><td><?= $data['iq']; ?></td></tr>
                                <tr><th>Keagamaan</th><td><?= $data['agama']; ?></td></tr>
                                <tr><th>Rata-rata</th><td><strong><?= number_format($data['rata_rata'], 2); ?></strong></td></tr>
                                <tr>
                                    <th>Status Kelulusan</th>
                                    <td>
                                        <?php
                                        $status = $data['status'] ?? 'Belum diproses';
                                        $badge = $status == 'Lulus' ? 'success' : ($status == 'Tidak Lulus' ? 'danger' : 'secondary');
                                        echo "<span class='badge badge-$badge p-2'>$status</span>";
                                        ?>
                                    </td>
                                </tr>
                                <tr><th>Jurusan</th><td><strong><?= $data['kelas'] ?? '-'; ?></strong></td></tr>
                            </table>

                            <a href="cetak_pdf.php" class="btn btn-danger mt-3" target="_blank">
                                <i class="fas fa-file-pdf"></i> Cetak Hasil PDF
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<!-- SB Admin 2 Scripts -->
<script src="../sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="../sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../sb_admin_2/js/sb-admin-2.min.js"></script>

</body>
</html>
