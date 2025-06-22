<?php
session_start();
require '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: list_meeting.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM meetings WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    header("Location: list_meeting.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jadwal Meeting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: start;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
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
    </style>
</head>
<body>

<div class="form-container">
    <h3>Edit Jadwal Meeting</h3>
    <form action="update_meeting.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3">
            <label class="form-label">Judul Meeting</label>
            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($row['title']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu Meeting</label>
            <input type="datetime-local" name="date_time" class="form-control" required value="<?= date('Y-m-d\TH:i', strtotime($row['date_time'])) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi (Opsional)</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($row['location']) ?>">
        </div>
        <button type="submit" class="btn btn-primary btn-custom">
            <i class="bi bi-save"></i> Simpan Perubahan
        </button>
        <a href="list_meeting.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Daftar Meeting
        </a>
    </form>
</div>

</body>
</html>