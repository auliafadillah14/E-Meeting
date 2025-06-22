<?php
require '../config/db.php';
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$date_time = $_POST['date_time'];
$location = $_POST['location'];

$stmt = $conn->prepare("UPDATE meetings SET title=?, description=?, date_time=?, location=? WHERE id=?");
$stmt->bind_param("ssssi", $title, $description, $date_time, $location, $id);
if ($stmt->execute()) {
  echo "Jadwal berhasil diperbarui!";
} else {
  echo "Gagal memperbarui jadwal.";
}
?>
