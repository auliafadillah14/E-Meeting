<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }
    .btn-google {
      background-color: #db4437;
      color: white;
      transition: background 0.3s ease;
    }
    .btn-google:hover {
      background-color: #c33d2e;
      color: white;
    }
    .form-label {
      font-weight: 500;
    }
    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(38,143,255,.25);
    }
    h2 {
      font-weight: 600;
    }
    .small-text {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h2 class="text-center mb-4 text-primary">Selamat Datang!</h2>
    <form action="login_process.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password:</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
        <label class="form-check-label small-text" for="rememberMe">Ingat saya</label>
      </div>
      <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
    </form>

    <div class="text-center text-muted mb-3 small-text">atau login dengan</div>

    <!-- Tombol Login Google -->
    <?php
      require __DIR__ . '/../config/google-config.php';
      $auth_url = $client->createAuthUrl();
    ?>
    <a href="<?= htmlspecialchars($auth_url) ?>" class="btn btn-google w-100 mb-3">
      <i class="bi bi-google me-2"></i> Login dengan Google
    </a>

    <p class="text-center small-text">
      Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar sekarang</a>
    </p>
  </div>

</body>
</html>