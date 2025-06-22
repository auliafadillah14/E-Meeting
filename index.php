<?php
session_start(); // Penting untuk menggunakan session

// Cek apakah user sudah login (misalnya pakai session user_id)
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, redirect ke login.php
    header("Location: login.php");
    exit();
}

echo "<h1>Selamat Datang di Aplikasi E-Meeting</h1>";
echo "<p>Halo, " . htmlspecialchars($_SESSION['user_name']) . "!</p>";
echo "<p>Ini adalah platform untuk mengatur jadwal meeting dengan Google Calendar API.</p>";
echo "<p>Waktu Server: " . date("d F Y, H:i:s") . "</p>";
?>