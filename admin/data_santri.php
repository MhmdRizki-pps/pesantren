<?php
session_start();
include '../config/koneksi.php';

// Cek login & role
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil data santri
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$where = $cari ? "AND u.nama_lengkap LIKE '%$cari%'" : "";

$query = mysqli_query($koneksi, "
    SELECT u.*, n.akademik, n.non_akademik, n.iq, n.agama
    FROM users u
    LEFT JOIN nilai n ON u.id = n.user_id
    WHERE u.role = 'santri' $where
    ORDER BY u.nama_lengkap ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Santri - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SB Admin 2 -->
    <link href="../sb_admin_2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .badge-lulus {
            background-color: #28a745;
            color: white;
        }
        .badge-tidak-lulus {
            background-color: #dc3545;
            color: white;
        }
        .card {
            border-radius: 10px;
        }
        .form-inline .form-control {
            border-radius: 20px;
        }
    </style>
</head>
<body id="page-top">

<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'moora_sukses'): ?>
    <div class="alert alert-success text-center">Perhitungan selesai! Hasil kelas dan kelulusan sudah diperbarui.</div>
<?php endif; ?>
<?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'reset_sukses') : ?>
    <div class="alert alert-success text-center">Password berhasil direset ke default: 123456</div>
<?php endif; ?>

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item"><a class="nav-link" href="grafik_pendaftaran.php"><i class="fas fa-fw fa-chart-bar"></i><span>Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-fw fa-pen"></i><span>Input Nilai</span></a></li>
        <li class="nav-item active"><a class="nav-link" href="data_santri.php"><i class="fas fa-fw fa-users"></i><span>Data Santri</span></a></li>
        <li class="nav-item"><a class="nav-link" href="grafik_penjurusan_kelulusan.php"><i class="fas fa-fw fa-chart-pie"></i><span>Grafik Penjurusan & Kelulusan</span></a></li>
        <hr class="sidebar-divider">
        <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>
    </ul>

    <!-- Content -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow"></nav>

            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-user-graduate"></i> Data Santri Terdaftar</h1>

                <div class="mb-3">
                    <a href="proses_moora.php" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50"><i class="fas fa-cogs"></i></span>
                        <span class="text">Proses Penjurusan</span>
                    </a>
                </div>

                <form method="GET" class="form-inline mb-4">
                    <input type="text" name="cari" class="form-control mr-2" placeholder="Cari nama santri..." value="<?= htmlspecialchars($cari) ?>">
                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Cari</button>
                </form>

                <!-- Legend -->
                <div class="mb-3">
                    <strong>Keterangan Jurusan:</strong>
                    <span class="badge badge-success">IPA</span> Kelas IPA
                    <span class="badge badge-info">IPS</span> Kelas IPS
                    <span class="badge badge-secondary">-</span> Belum Ditentukan
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">Tabel Santri</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Status Kelulusan</th>
                                        <th>Jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_assoc($query)) :
                                        $status = strtolower($data['status'] ?? 'tidak lulus');
                                        $kelas = ($status === 'lulus') ? ($data['kelas'] ?? '-') : '-';

                                        $statusBadge = ($status === 'lulus') 
                                            ? '<span class="badge badge-lulus">Lulus</span>' 
                                            : '<span class="badge badge-tidak-lulus">Tidak Lulus</span>';

                                        if ($status === 'lulus' && $kelas !== '-') {
                                            if ($kelas == 'IPA') {
                                                $kelasBadge = "<span class='badge badge-success'>IPA</span>";
                                            } elseif ($kelas == 'IPS') {
                                                $kelasBadge = "<span class='badge badge-info'>IPS</span>";
                                            } else {
                                                $kelasBadge = "<span class='badge badge-secondary'>$kelas</span>";
                                            }
                                        } else {
                                            $kelasBadge = "<span class='badge badge-secondary'>-</span>";
                                        }
                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($data['nama_lengkap']) ?></td>
                                        <td><?= htmlspecialchars($data['email']) ?></td>
                                        <td><?= $statusBadge ?></td>
                                        <td><?= $kelasBadge ?></td>
                                        <td>
                                            <a href="edit_nilai.php?id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div> <!-- End Container -->
        </div>
    </div>
</div>

<!-- Script -->
<script src="../sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="../sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../sb_admin_2/js/sb-admin-2.min.js"></script>

</body>
</html>
