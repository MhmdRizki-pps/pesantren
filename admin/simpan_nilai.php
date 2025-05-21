<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $akademik = $_POST['akademik'];
    $non_akademik = $_POST['non_akademik'];
    $iq = $_POST['iq'];
    $agama = $_POST['agama'];

    // Cek apakah nilai sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM nilai WHERE user_id = '$user_id'");
    if (mysqli_num_rows($cek) > 0) {
        // Update
        mysqli_query($koneksi, "UPDATE nilai SET akademik='$akademik', non_akademik='$non_akademik', iq='$iq', agama='$agama' WHERE user_id='$user_id'");
    } else {
        // Insert
        mysqli_query($koneksi, "INSERT INTO nilai (user_id, akademik, non_akademik, iq, agama) VALUES ('$user_id', '$akademik', '$non_akademik', '$iq', '$agama')");
    }

    header("Location: index.php?success=1");
    exit;
} else {
    header("Location: index.php");
    exit;
}
