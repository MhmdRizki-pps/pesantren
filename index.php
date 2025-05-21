<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Beranda - Pondok Pesantren At-Thohiriyah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="sb_admin_2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="sb_admin_2/css/sb-admin-2.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .hero {
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('img/pondok.jpg') center center/cover no-repeat;
      color: white;
      padding: 130px 0;
      text-align: center;
    }
    .hero h1 {
      font-size: 3.2rem;
      font-weight: 700;
    }
    .hero p {
      font-size: 1.2rem;
    }
    .feature {
      padding: 60px 0;
      background-color: #f8f9fc;
    }
    .feature .card {
      border: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .feature .card i {
      font-size: 2.5rem;
      color: #4e73df;
      margin-bottom: 15px;
    }
    footer {
      background-color: #4e73df;
      color: white;
      padding: 20px 0;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
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
        <li class="nav-item active"><a class="nav-link" href="index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">Tentang Kami</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Daftar</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1 class="display-4">Selamat Datang di Pondok Pesantren Moderat At-Thohiriyah</h1>
    <h2></h2>
    <p class="lead">Pusat pendidikan Islam terpadu untuk membentuk generasi berkarakter dan berprestasi.</p>
  </div>
</section>

<!-- Features -->
<section class="feature">
  <div class="container">
    <h2 class="text-center mb-5 font-weight-bold text-dark">Mengapa Memilih Kami?</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card p-4 text-center">
          <i class="fas fa-book-reader"></i>
          <h5 class="font-weight-bold mt-3">Pendidikan Holistik</h5>
          <p>Pembelajaran terpadu antara ilmu agama dan pengetahuan umum berbasis kurikulum nasional dan pesantren.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card p-4 text-center">
          <i class="fas fa-mosque"></i>
          <h5 class="font-weight-bold mt-3">Lingkungan Religius</h5>
          <p>Menanamkan nilai-nilai Islam dalam kehidupan sehari-hari melalui pembinaan intensif dan keteladanan.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card p-4 text-center">
          <i class="fas fa-chart-line"></i>
          <h5 class="font-weight-bold mt-3">Seleksi Kelas IPA/IPS</h5>
          <p>Penempatan kelas santri berdasarkan potensi akademik dan hasil seleksi menggunakan metode MOORA.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-center">
  <div class="container">
    <p class="mb-0">&copy; <?= date("Y"); ?> Pondok Pesantren At-Thohiriyah. All rights reserved.</p>
  </div>
</footer>

<!-- Scripts -->
<script src="sb_admin_2/vendor/jquery/jquery.min.js"></script>
<script src="sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
