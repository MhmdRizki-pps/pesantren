<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kontak Kami - Pondok Pesantren At-Thohiriyah</title>
    <link href="sb_admin_2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet" />
</head>
<body id="page-top">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="lambang ppm.jpeg" alt="Logo"> <span class="font-weight-bold">Pondok Pesantren Moderat At-Thohiriyah</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">Tentang Kami</a></li>
        <li class="nav-item active"><a class="nav-link" href="contact.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Daftar</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Page Content -->
<div class="container mt-5">

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-info">
            <h4 class="m-0 font-weight-bold text-white">Kontak Kami</h4>
        </div>
        <div class="card-body">
            <p>Silakan hubungi kami melalui formulir di bawah ini atau gunakan informasi kontak yang tersedia.</p>
            
            <form action="kirim_pesan.php" method="POST">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea class="form-control" id="pesan" name="pesan" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-info text-white">Kirim Pesan</button>
            </form>

            <hr>

            <h5>Informasi Kontak</h5>
            <ul>
                <li>Alamat: Jl. Serang-Cilegon, Pelamunan, Kec. Kramatwatu, Kabupaten Serang, Banten 42161</li>
                <li>Telepon:  (0254) 232372</li>
                <li>Email: info@atthohiriyah.sch.id</li>
            </ul>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="bg-info text-white text-center py-3 mt-auto">
    &copy; <?= date('Y'); ?> Pondok Pesantren At-Thohiriyah. All Rights Reserved.
</footer>

<script src="sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
