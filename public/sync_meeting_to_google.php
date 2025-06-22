<?php
session_start();
require '../config/google-config.php';
require '../config/db.php';

if (!isset($_SESSION['google_token'])) {
    die("Error: Silakan login ke Google terlebih dahulu.");
}

$client->setAccessToken($_SESSION['google_token']);
$calendarService = new Google_Service_Calendar($client);

// Cek parameter ID
if (!isset($_GET['id'])) {
    die("Error: ID meeting tidak ditemukan.");
}

$meeting_id = (int)$_GET['id']; // Konversi ke integer untuk keamanan

// Ambil data meeting dari database
$stmt = $conn->prepare("SELECT * FROM meetings WHERE id = ?");
$stmt->bind_param("i", $meeting_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Data meeting tidak ditemukan.");
}

$meeting = $result->fetch_assoc();

// Siapkan event Google Calendar
$event = new Google_Service_Calendar_Event([
    'summary'     => $meeting['title'],
    'description' => $meeting['description'],
    'start'       => [
        'dateTime' => date('c', strtotime($meeting['date_time'])),
        'timeZone' => 'Asia/Jakarta'
    ],
    'end'         => [
        'dateTime' => date('c', strtotime($meeting['date_time'] . ' +1 hour')),
        'timeZone' => 'Asia/Jakarta'
    ],
    'location'    => $meeting['location']
]);

try {
    $calendarId = 'primary'; // Kalender utama
    $event = $calendarService->events->insert($calendarId, $event);

    echo "✅ Jadwal meeting berhasil dikirim ke Google Calendar: ";
    echo "<a href='" . htmlspecialchars($event->htmlLink) . "' target='_blank'>Lihat di Google Calendar</a>";
} catch (Exception $e) {
    echo "❌ Terjadi kesalahan: " . htmlspecialchars($e->getMessage());
}
?>