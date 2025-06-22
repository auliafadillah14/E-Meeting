<?php
session_start();
require '../config/google-config.php';

if (!isset($_SESSION['access_token'])) {
    die("❌ Silakan login ke Google terlebih dahulu.");
}

$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);

if (!isset($_GET['eventId'])) {
    die("❌ ID event tidak ditemukan.");
}

$eventId = $_GET['eventId'];

try {
    $calendarService->events->delete('primary', $eventId);
    echo "<div style='font-family: Arial; padding:20px; background-color:#e0ffe0; color:green; border:1px solid #00aa00;'>✔️ Jadwal meeting berhasil dihapus dari Google Calendar.</div>";
    echo "<br><a href='list_event.php'>⬅️ Kembali ke Daftar Event</a>";
} catch (Exception $e) {
    echo "<div style='font-family: Arial; padding:20px; background-color:#ffe0e0; color:red; border:1px solid #aa0000;'>❌ Gagal menghapus event: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<br><a href='list_event.php'>⬅️ Kembali ke Daftar Event</a>";
}
?>