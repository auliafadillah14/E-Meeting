<?php
session_start();
require '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list_meeting.php?msg=error");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM meetings WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: list_meeting.php?msg=deleted");
} else {
    header("Location: list_meeting.php?msg=fail");
}
exit();
?>