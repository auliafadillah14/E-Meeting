<!DOCTYPE html>
<html>
<head>
  <title>Registrasi Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">Form Registrasi</h2>
    <form action="register_process.php" method="POST" class="border p-4 bg-white shadow rounded">
      <div class="mb-3">
        <label class="form-label">Nama:</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password:</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Daftar</button>
      <p class="mt-3">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </form>
  </div>
</body>
</html>
