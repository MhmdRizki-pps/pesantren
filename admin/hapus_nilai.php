<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_GET['id'];

// Hapus data nilai berdasarkan user_id
mysqli_query($koneksi, "DELETE FROM nilai WHERE user_id = '$user_id'");

header("Location: index.php?success=1");
exit;
