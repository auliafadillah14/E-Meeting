<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profil Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        Profil Pengguna
      </div>
      <div class="card-body">
        <p><strong>Nama:</strong> <?= $_SESSION['user_name'] ?></p>
        <p><strong>Email:</strong> (Email bisa ditampilkan dari database jika mau)</p>
        <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
      </div>
    </div>
  </div>
</body>
</html>