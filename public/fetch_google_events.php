<?php
session_start();
require '../config/google-config.php';

if (!isset($_SESSION['google_token'])) {
    die("❌ Silakan login ke Google terlebih dahulu.");
}

$client->setAccessToken($_SESSION['google_token']);
$calendarService = new Google_Service_Calendar($client);

try {
    $events = $calendarService->events->listEvents('primary', [
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'), // hanya event dari waktu sekarang ke depan
        'maxResults' => 10
    ]);
} catch (Exception $e) {
    die("Terjadi kesalahan saat mengambil event: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Event Google Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 700px;">
    <h3 class="text-center mb-4">Jadwal Meeting di Google Calendar</h3>
    <a href="dashboard.php" class="btn btn-secondary mb-3">⬅️ Kembali ke Dashboard</a>

    <?php
    if (count($events->getItems()) == 0) {
        echo "<div class='alert alert-info'>Tidak ada event ditemukan.</div>";
    } else {
        foreach ($events->getItems() as $event) {
            // Skip event ulang tahun
            if ($event->getEventType() === 'birthday') continue;

            $summary = $event->getSummary() ?: '(Tanpa Judul)';
            $start = $event->start->dateTime ?: $event->start->date;
            $end = $event->end->dateTime ?: $event->end->date;

            echo "<div class='card p-3 mb-3'>";
            echo "<h5>$summary</h5>";
            echo "<p><strong>Mulai:</strong> " . date('d M Y H:i', strtotime($start)) . "</p>";
            echo "<p><strong>Selesai:</strong> " . date('d M Y H:i', strtotime($end)) . "</p>";
            echo "</div>";
        }
    }
    ?>
</div>
</body>
</html>