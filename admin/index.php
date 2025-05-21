<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$santri = mysqli_query($koneksi, "
    SELECT u.*, n.id as nilai_id, n.akademik, n.non_akademik, n.iq, n.agama
    FROM users u
    LEFT JOIN nilai n ON u.id = n.user_id
    WHERE u.role = 'santri'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai Santri</title>
    <link href="../sb_admin_2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="page-top">

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </a>
        <hr class="sidebar-divider">
        <li class="nav-item"><a class="nav-link" href="grafik_pendaftaran.php"><i class="fas fa-chart-line"></i><span> Dashboard</span></a></li>
        <li class="nav-item active"><a class="nav-link" href="index.php"><i class="fas fa-edit"></i><span> Input Nilai</span></a></li>
        <li class="nav-item"><a class="nav-link" href="data_santri.php"><i class="fas fa-users"></i><span> Data Santri</span></a></li>
        <li class="nav-item"><a class="nav-link" href="grafik_penjurusan_kelulusan.php"><i class="fas fa-chart-pie"></i><span> Grafik Penjurusan</span></a></li>
        <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
                <span class="h5 m-0 font-weight-bold text-primary">Input Nilai Santri</span>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Input Nilai</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Akademik</th>
                                        <th>Non-Akademik</th>
                                        <th>IQ</th>
                                        <th>Agama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; while ($row = mysqli_fetch_assoc($santri)) : ?>
                                    <tr>
                                        <form method="POST" action="simpan_nilai.php">
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                            <td><input type="number" name="akademik" value="<?= $row['akademik'] ?>" required class="form-control" step="0.01"></td>
                                            <td><input type="number" name="non_akademik" value="<?= $row['non_akademik'] ?>" required class="form-control" step="0.01"></td>
                                            <td><input type="number" name="iq" value="<?= $row['iq'] ?>" required class="form-control" step="0.01"></td>
                                            <td><input type="number" name="agama" value="<?= $row['agama'] ?>" required class="form-control" step="0.01"></td>
                                            <td>
                                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn btn-success btn-sm mb-1"><i class="fas fa-save"></i> Simpan</button>
                                                <?php if ($row['nilai_id']) : ?>
                                                    <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['id'] ?>)"><i class="fas fa-trash"></i> Hapus</a>
                                                <?php endif; ?>
                                            </td>
                                        </form>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- SweetAlert untuk notifikasi -->
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Nilai berhasil disimpan!', showConfirmButton: false, timer: 2000 });
</script>
<?php endif; ?>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
<script>
    Swal.fire({ icon: 'success', title: 'Terhapus', text: 'Nilai berhasil dihapus!', showConfirmButton: false, timer: 2000 });
</script>
<?php endif; ?>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data nilai akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'hapus_nilai.php?id=' + id;
        }
    });
}
</script>

<script src="../sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="../sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../sb_admin_2/js/sb-admin-2.min.js"></script>
</body>
</html>
