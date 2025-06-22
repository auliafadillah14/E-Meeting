<?php 
session_start(); 
require '../config/google-config.php'; 

if (!isset($_SESSION['access_token'])) { 
    die('Harap login dengan Google!'); 
} 

$client->setAccessToken($_SESSION['access_token']); 
$calendarService = new Google_Service_Calendar($client); 

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit'])) {
    $summary = $_GET['summary'] ?? '';
    $start_time = $_GET['start_time'] ?? '';
    $end_time = $_GET['end_time'] ?? '';
    $location = $_GET['location'] ?? '';

    if (empty($summary) || empty($start_time) || empty($end_time)) {
        die('❌ Data tidak lengkap! Semua field harus diisi.');
    }

    $event = new Google_Service_Calendar_Event([ 
        'summary' => $summary, 
        'location' => $location,
        'start' => [ 
            'dateTime' => date('c', strtotime($start_time)),
            'timeZone' => 'Asia/Jakarta' 
        ], 
        'end' => [ 
            'dateTime' => date('c', strtotime($end_time)),
            'timeZone' => 'Asia/Jakarta' 
        ], 
        'reminders' => [
            'useDefault' => false,
            'overrides' => [
                ['method' => 'email', 'minutes' => 10],
                ['method' => 'popup', 'minutes' => 10],
            ],
        ],
    ]); 

    $calendarId = 'primary'; 

    try {
        $event = $calendarService->events->insert($calendarId, $event); 
        echo "<div class='alert alert-success mt-3 text-center'>✅ Acara berhasil ditambahkan: <a href='" . $event->htmlLink . "' target='_blank'>Lihat di Google Calendar</a></div>"; 
    } catch (Exception $e) {
        echo "<div class='alert alert-danger mt-3 text-center'>❌ Gagal menambahkan acara: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Event Google Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .event-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
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
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="event-card">
    <h3>Tambah Event ke Google Calendar</h3>
    <form method="GET" action="">
        <div class="mb-3">
            <label class="form-label">Judul Event</label>
            <input type="text" name="summary" class="form-control" required placeholder="Contoh: Rapat Proyek">
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu Mulai</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu Selesai</label>
            <input type="datetime-local" name="end_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi (Opsional)</label>
            <input type="text" name="location" class="form-control" placeholder="Contoh: Ruang Rapat A">
        </div>
        <button type="submit" name="submit" value="1" class="btn btn-primary btn-custom">
            <i class="bi bi-calendar-plus"></i> Tambah ke Google Calendar
        </button>
        <a href="list_event.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Daftar Event
        </a>
    </form>
</div>

</body>
</html>