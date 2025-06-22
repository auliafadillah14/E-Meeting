<?php
require '../config/db.php';

// Ambil data dari database
$result = $conn->query("SELECT * FROM meetings");
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id'    => $row['id'], // untuk keperluan edit/detail
        'title' => $row['title'],
        'start' => $row['date_time'],
        'url'   => 'meeting_detail.php?id=' . $row['id'] // opsional: klik ke detail
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kalender Meeting</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%); /* Gradasi biru seperti dashboard */
            min-height: 100vh;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        h2 {
            text-align: center;
            color: #fff;
            margin-top: 30px;
        }
        #calendar {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <h2>Kalender Jadwal Meeting</h2>
    <div id="calendar"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?= json_encode($events) ?>,
            eventClick: function(info) {
                info.jsEvent.preventDefault(); 
                if (info.event.url) {
                    window.location.href = info.event.url;
                }
            }
        });
        calendar.render();
    });
    </script>
</body>
</html>