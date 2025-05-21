<?php
session_start();
include '../config/koneksi.php';

// Cek apakah yang login admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: data_santri.php");
    exit;
}

// Ambil data user santri
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id AND role = 'santri'");
if (mysqli_num_rows($query_user) == 0) {
    header("Location: data_santri.php");
    exit;
}
$user = mysqli_fetch_assoc($query_user);

// Ambil nilai santri
$query_nilai = mysqli_query($koneksi, "SELECT * FROM nilai WHERE user_id = $id");
$nilai = mysqli_fetch_assoc($query_nilai);

// Proses update nilai
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $akademik = floatval($_POST['akademik']);
    $non_akademik = floatval($_POST['non_akademik']);
    $iq = floatval($_POST['iq']);
    $agama = floatval($_POST['agama']);

    if ($nilai) {
        $sql = "UPDATE nilai SET akademik=$akademik, non_akademik=$non_akademik, iq=$iq, agama=$agama WHERE user_id=$id";
    } else {
        $sql = "INSERT INTO nilai (user_id, akademik, non_akademik, iq, agama) VALUES ($id, $akademik, $non_akademik, $iq, $agama)";
    }

    mysqli_query($koneksi, $sql);
    header("Location: data_santri.php?pesan=nilai_terupdate");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Nilai Santri - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- SB Admin 2 CSS -->
    <link href="../sb_admin_2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="../sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet" />
    <style>
        .card {
            border-radius: 10px;
        }
    </style>
</head>
<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="data_santri.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </a>

        <hr class="sidebar-divider my-0" />

        <li class="nav-item">
            <a class="nav-link" href="data_santri.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Data Santri</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="proses_moora.php">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Proses MOORA</span>
            </a>
        </li>

        <hr class="sidebar-divider" />

        <li class="nav-item">
            <a class="nav-link" href="../logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" class="p-4">

            <h1 class="h3 mb-4 text-gray-800">Edit Nilai Santri</h1>

            <div class="card shadow mb-4 p-4">
                <form action="" method="POST">
                    <div class="form-group">
                        <label>Nama Santri:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Nilai Akademik</label>
                        <input type="number" step="0.01" name="akademik" class="form-control" required value="<?= $nilai ? htmlspecialchars($nilai['akademik']) : '' ?>" />
                    </div>
                    <div class="form-group">
                        <label>Nilai Non Akademik</label>
                        <input type="number" step="0.01" name="non_akademik" class="form-control" required value="<?= $nilai ? htmlspecialchars($nilai['non_akademik']) : '' ?>" />
                    </div>
                    <div class="form-group">
                        <label>Nilai IQ</label>
                        <input type="number" step="0.01" name="iq" class="form-control" required value="<?= $nilai ? htmlspecialchars($nilai['iq']) : '' ?>" />
                    </div>
                    <div class="form-group">
                        <label>Nilai Agama</label>
                        <input type="number" step="0.01" name="agama" class="form-control" required value="<?= $nilai ? htmlspecialchars($nilai['agama']) : '' ?>" />
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan Nilai</button>
                    <a href="data_santri.php" class="btn btn-secondary mt-3">Batal</a>
                </form>
            </div>

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Bootstrap core JavaScript-->
<script src="../sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="../sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../sb_admin_2/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../sb_admin_2/js/sb-admin-2.min.js"></script>

</body>
</html>
