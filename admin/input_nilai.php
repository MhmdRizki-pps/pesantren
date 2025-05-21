<?php
session_start();
include '../config/koneksi.php';

// Cek role guru
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Ambil semua santri
$santri = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'santri'");

// Proses simpan nilai
if (isset($_POST['simpan'])) {
    $user_id = $_POST['user_id'];
    $nilai_akademik = $_POST['nilai_akademik'];
    $nilai_iq = $_POST['nilai_iq'];
    $nilai_agama = $_POST['nilai_agama'];
    $nilai_non_akademik = $_POST['nilai_non_akademik'];

    // Hitung rata-rata
    $total = ($nilai_akademik + $nilai_iq + $nilai_agama + $nilai_non_akademik) / 4;

    // Tentukan status
    $status = ($total >= 70) ? 'lulus' : 'tidak_lulus';

    // Update nilai dan status ke tabel users
    $query = "UPDATE users SET 
        nilai_akademik = '$nilai_akademik',
        nilai_iq = '$nilai_iq',
        nilai_agama = '$nilai_agama',
        nilai_non_akademik = '$nilai_non_akademik',
        status = '$status'
        WHERE id = '$user_id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Nilai berhasil disimpan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan nilai!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Nilai Santri</title>
    <link href="../sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Input Nilai Santri</h3>
    <form method="post">
        <div class="form-group">
            <label>Nama Santri</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih Santri --</option>
                <?php while($row = mysqli_fetch_assoc($santri)): ?>
                    <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama_lengkap']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nilai Akademik</label>
            <input type="number" name="nilai_akademik" class="form-control" min="0" max="100" required>
        </div>

        <div class="form-group">
            <label>Nilai IQ</label>
            <input type="number" name="nilai_iq" class="form-control" min="0" max="100" required>
        </div>

        <div class="form-group">
            <label>Nilai Agama</label>
            <input type="number" name="nilai_agama" class="form-control" min="0" max="100" required>
        </div>

        <div class="form-group">
            <label>Nilai Non-Akademik</label>
            <input type="number" name="nilai_non_akademik" class="form-control" min="0" max="100" required>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">Simpan Nilai</button>
    </form>
</div>
</body>
</html>
