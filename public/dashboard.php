<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .dashboard-card {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }
    .nav-btn {
      display: flex;
      align-items: center;
      justify-content: flex-start; /* ikon dan teks ke kiri */
      font-size: 1.1rem;
      border-radius: 10px;
      color: white !important;
      padding-left: 20px;
    }
    .nav-btn i {
      margin-right: 15px;
      font-size: 1.3rem;
    }
    h4 {
      font-weight: 600;
      text-align: center;
      margin-bottom: 5px;
    }
    h5 {
      text-align: center;
      margin-top: 0;
      color: #555;
    }
    .btn-home { background-color: #4A90E2; }
    .btn-event { background-color: #4A90E2; }
    .btn-meeting { background-color: #4A90E2; }
    .btn-calendar { background-color: #4A90E2; }
    .btn-logout { background-color: #d9534f; } /* Logout tetap merah */
    .btn-home:hover,
    .btn-event:hover,
    .btn-meeting:hover,
    .btn-calendar:hover {
      background-color: #357ABD;
    }
    .profile-btn {
      margin-top: 15px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="dashboard-card">
    <div class="alert alert-primary text-center">
      <h4>Selamat Datang,</h4>
      <h5><?= htmlspecialchars($_SESSION['user_name']); ?>!</h5>
    </div>

    <div class="d-grid gap-3 mt-4">
      <a href="dashboard.php" class="btn btn-home btn-lg nav-btn">
        <i class="bi bi-house-door-fill"></i> Home
      </a>
      <a href="list_event.php" class="btn btn-event btn-lg nav-btn">
        <i class="bi bi-calendar-plus-fill"></i> Event
      </a>
      <a href="list_meeting.php" class="btn btn-meeting btn-lg nav-btn">
        <i class="bi bi-list-ul"></i> Meeting
      </a>
      <a href="calendar.php" class="btn btn-calendar btn-lg nav-btn">
        <i class="bi bi-calendar3"></i> Kalender 
      </a>
      <a href="logout.php" class="btn btn-logout btn-lg nav-btn">
        <i class="bi bi-box-arrow-right"></i> Logout
      </a>
    </div>

    <div class="profile-btn">
      <a href="profile.php" class="btn btn-outline-primary">
        <i class="bi bi-person-circle"></i> Lihat Profil
      </a>
    </div>
  </div>

</body>
</html>