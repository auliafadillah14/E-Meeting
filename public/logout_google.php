<?php
session_start();

// Hapus token akses Google dari session
if (isset($_SESSION['access_token'])) {
    unset($_SESSION['access_token']);
}

// Hapus session lainnya kalau perlu
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>