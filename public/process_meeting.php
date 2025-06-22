<?php
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date_time = $_POST['date_time'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO meetings (title, description, date_time, location) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $date_time, $location);

    if ($stmt->execute()) {
        echo "Jadwal Meeting berhasil disimpan!";
    } else {
        echo "Gagal menyimpan jadwal.";
    }

    $stmt->close();
    $conn->close();
}
?>
