<?php 
session_start(); 
require '../config/google-config.php'; 

if (!isset($_SESSION['access_token'])) { 
    die('Harap login dengan Google!'); 
} 

$client->setAccessToken($_SESSION['access_token']); 
$calendarService = new Google_Service_Calendar($client); 

$calendarId = 'primary'; 

try {
    $events = $calendarService->events->listEvents($calendarId, [
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'maxResults' => 20,
        'timeMin' => date('c')
    ]);

} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Event Google Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: start;
            padding-top: 50px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .event-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 600px;
        }
        h3 {
            font-weight: 600;
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .btn-custom {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px 0;
            border-radius: 8px;
            font-size: 1rem;
        }
        .event-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .event-item h5 {
            font-weight: 600;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="event-card">
    <h3>Daftar Event Google Calendar</h3>
    <a href="add_event.php" class="btn btn-primary btn-custom">
        <i class="bi bi-plus-circle"></i> Tambah Event Baru
    </a>
    <a href="dashboard.php" class="btn btn-secondary btn-custom">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
    </a>

    <?php
    if (count($events->getItems()) == 0) {
        echo "<div class='alert alert-info text-center mt-3'>Tidak ada event ditemukan.</div>";
    } else {
        foreach ($events->getItems() as $event) {
            if ($event->getEventType() === 'birthday') continue;

            $eventId = $event->getId();
            $summary = $event->getSummary();
            $start = $event->start->dateTime ?: $event->start->date;
            $end = $event->end->dateTime ?: $event->end->date;

            echo "<div class='event-item'>";
            echo "<h5>$summary</h5>";
            echo "<p>Mulai: " . date('d M Y H:i', strtotime($start)) . "</p>";
            echo "<p>Selesai: " . date('d M Y H:i', strtotime($end)) . "</p>";
            echo "<a href='edit_event.php?eventId=$eventId' class='btn btn-warning btn-sm'>✏️ Edit</a> ";
            echo "<a href='delete_event.php?eventId=$eventId' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin hapus event ini?\")'>🗑️ Hapus</a>";
            echo "</div>";
        }
    }
    ?>
</div>

</body>
</html>