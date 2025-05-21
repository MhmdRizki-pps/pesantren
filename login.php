<?php
if (isset($_GET['pesan']) && $_GET['pesan'] == 'logout') {
    echo "<div class='alert alert-success'>Anda berhasil logout.</div>";
}
?>

<?php
session_start();
include 'config/koneksi.php';

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $data = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        // Simpan session
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        // Redirect berdasarkan role
        if ($data['role'] == 'admin') {
            header("Location: admin/grafik_pendaftaran.php");
        } elseif ($data['role'] == 'guru') {
            header("Location: guru/index.php");
        } elseif ($data['role'] == 'santri') {
            header("Location: santri/index.php");
        }
        exit;
    } else {
        $pesan = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Akun</title>
    <link href="sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-success">

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Login Akun</h4>
                </div>
                <div class="card-body">
                    <?php if ($pesan != ""): ?>
                        <div class="alert alert-danger"><?= $pesan; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Login</button>
                        <a href="register.php" class="btn btn-link btn-block">Belum punya akun? Daftar</a>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
