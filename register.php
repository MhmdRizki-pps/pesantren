<?php
include 'config/koneksi.php';

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

    // Cek apakah email sudah terdaftar
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Email sudah digunakan!";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO users (nama_lengkap, email, password, role) VALUES ('$nama_lengkap', '$email', '$password', 'santri')");
        if ($query) {
            $pesan = "Registrasi berhasil! Silakan login.";
        } else {
            $pesan = "Registrasi gagal: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registrasi Santri</title>
    <link href="sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Form Registrasi Santri</h4>
                </div>
                <div class="card-body">
                    <?php if ($pesan != ""): ?>
                        <div class="alert alert-info"><?= $pesan; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Aktif</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password Akun</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        <a href="login.php" class="btn btn-link btn-block">Sudah punya akun? Login</a>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
