<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require '../config/db.php';

$result = $conn->query("SELECT * FROM meetings ORDER BY date_time ASC");
$meetings = [];
while ($row = $result->fetch_assoc()) {
    $meetings[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Jadwal Meeting</title>
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
        .meeting-container {
            background: #fff;
            padding: 30px;
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
        .meeting-card {
            background: #f8f9fa;
            border: none;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .meeting-card h5 {
            margin-bottom: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="meeting-container">
    <h3>Daftar Jadwal Meeting</h3>
    <a href="add_meeting.php" class="btn btn-primary btn-custom">
        <i class="bi bi-calendar-plus"></i> Tambah Meeting Baru
    </a>
    <a href="dashboard.php" class="btn btn-secondary btn-custom">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
    </a>

    <?php if (count($meetings) === 0): ?>
        <div class="alert alert-info mt-3 text-center">Belum ada meeting yang dijadwalkan.</div>
    <?php else: ?>
        <?php foreach ($meetings as $meeting): ?>
            <div class="meeting-card">
                <h5><?= htmlspecialchars($meeting['title']) ?></h5>
                <p><i class="bi bi-clock"></i> Waktu: <?= date('d M Y H:i', strtotime($meeting['date_time'])) ?></p>
                <p><i class="bi bi-geo-alt"></i> Lokasi: <?= htmlspecialchars($meeting['location']) ?></p>
                <a href="edit_meeting.php?id=<?= $meeting['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="delete_meeting.php?id=<?= $meeting['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus meeting ini?')">
                    <i class="bi bi-trash"></i> Hapus
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>