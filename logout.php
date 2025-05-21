<?php
session_start();
session_unset();
session_destroy();

// Setelah logout, arahkan kembali ke login.php dengan pesan
header("Location: login.php?pesan=logout");
exit();
