<?php
require '../config/google-config.php'; 
require '../config/db.php';

if (!isset($_SESSION['access_token'])) {
    die("Silakan login ke Google.");
}

$client->setAccessToken($_SESSION['access_token']);
$calendarService = new Google_Service_Calendar($client);

// Ambil data dari form
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$date_time = $_POST['date_time'];
$location = $_POST['location'];

// Ambil event_id Google Calendar dari database
$stmt = $conn->prepare("SELECT event_id FROM meetings WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$eventId = $row['event_id'];

// Ambil event dari Google Calendar
$event = $calendarService->events->get('primary', $eventId);

// Update event
$event->setSummary($title);
$event->setDescription($description);
$event->setLocation($location);
$event->setStart(['dateTime' => date('c', strtotime($date_time)), 'timeZone' => 'Asia/Jakarta']);
$event->setEnd(['dateTime' => date('c', strtotime($date_time . ' +1 hour')), 'timeZone' => 'Asia/Jakarta']);

// Reminder
$event->setReminders([
    'useDefault' => false,
    'overrides' => [
        ['method' => 'popup', 'minutes' => 10],
        ['method' => 'email', 'minutes' => 10],
    ],
]);

$updatedEvent = $calendarService->events->update('primary', $eventId, $event);

echo "✅ Event berhasil diperbarui di Google Calendar: <a href='" . $updatedEvent->htmlLink . "' target='_blank'>Lihat Event</a>";
?>
