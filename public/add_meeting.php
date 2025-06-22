<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $date_time = $_POST['date_time'] ?? '';
    $location = $_POST['location'] ?? '';

    // Validasi sederhana
    if (empty($title) || empty($date_time)) {
        $error = "❌ Semua field harus diisi!";
    } else {
        $stmt = $conn->prepare("INSERT INTO meetings (user_id, title, date_time, location) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $_SESSION['user_id'], $title, $date_time, $location);

        if ($stmt->execute()) {
            $success = "✅ Meeting berhasil ditambahkan!";
        } else {
            $error = "❌ Gagal menambahkan meeting: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal Meeting</title>
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
    <h3>Tambah Jadwal Meeting</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php elseif (isset($success)): ?>
        <div class="alert alert-success text-center"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Judul Meeting</label>
            <input type="text" name="title" class="form-control" required placeholder="Contoh: Rapat Proyek">
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu Meeting</label>
            <input type="datetime-local" name="date_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Lokasi (Opsional)</label>
            <input type="text" name="location" class="form-control" placeholder="Contoh: Ruang Rapat A">
        </div>
        <button type="submit" class="btn btn-primary btn-custom">
            <i class="bi bi-calendar-plus"></i> Tambah Meeting
        </button>
        <a href="list_meeting.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left-circle"></i> Kembali ke Daftar Meeting
        </a>
    </form>
</div>

</body>
</html>