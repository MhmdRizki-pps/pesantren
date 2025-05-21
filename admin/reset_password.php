<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $default_password = password_hash('123456', PASSWORD_DEFAULT);

    $update = mysqli_query($koneksi, "UPDATE users SET password='$default_password' WHERE id='$id'");

    header("Location: data_santri.php?pesan=reset_sukses");
}
