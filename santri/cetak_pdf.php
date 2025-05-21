<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
use Mpdf\Mpdf;

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

$user_id = $_SESSION['id'];

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "db_pesantren");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data user dan nilai
$sql = "SELECT u.nama_lengkap, u.kelas, u.rata_rata, n.akademik, n.non_akademik, n.iq, n.agama
        FROM users u
        JOIN nilai n ON u.id = n.user_id
        WHERE u.id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();



if ($row = $result->fetch_assoc()) {
    // Tentukan status kelulusan
    $status_kelulusan = ($row['rata_rata'] >= 59) ? 'Lulus' : 'Tidak Lulus';
    $html = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            h2, h3 {
                text-align: center;
                margin-bottom: 5px;
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #333;
                padding: 8px 12px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
                width: 30%;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h2>Laporan Nilai Tes Santri</h2>
            <h3>Pondok Pesantren At-Thohiriyah</h3>
            <h4>Tahun Ajaran 2025/2026</h4>
            <hr>
        </div>
        <table>
            <tr><th>Nama Lengkap</th><td>' . htmlspecialchars($row['nama_lengkap']) . '</td></tr>
            <tr><th>Nilai Akademik</th><td>' . htmlspecialchars($row['akademik']) . '</td></tr>
            <tr><th>Nilai Non Akademik</th><td>' . htmlspecialchars($row['non_akademik']) . '</td></tr>
            <tr><th>Nilai Agama</th><td>' . htmlspecialchars($row['agama']) . '</td></tr>
            <tr><th>IQ</th><td>' . htmlspecialchars($row['iq']) . '</td></tr>
            <tr><th>Rata-rata</th><td>' . number_format($row['rata_rata'], 2) . '</td></tr>
            <tr><th>Status Kelulusan</th><td>' . $status_kelulusan . '</td></tr>
            <tr><th>Kelas</th><td>' . htmlspecialchars($row['kelas']) . '</td></tr>
        </table>
        <br><br>
        <p style="text-align:right;">Dicetak pada: ' . date("d-m-Y H:i") . '</p>
    </body>
    </html>
    ';

    $mpdf = new Mpdf([
        'format' => 'A4',
        'margin_top' => 20,
        'margin_bottom' => 20,
    ]);
    $mpdf->WriteHTML($html);
    $mpdf->Output('laporan_nilai_saya.pdf', 'I'); // tampilkan di browser
} else {
    echo "Data tidak ditemukan untuk user ini.";
}
