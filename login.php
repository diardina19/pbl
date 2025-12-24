<?php
include 'config/koneksi.php';
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MySchedule - Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/login.css">
</head>

<body>

  <div class="login-container">
    <form action="process/proses_login.php" method="POST">
      <img src="https://upload.wikimedia.org/wikipedia/id/2/2c/Politeknik_Negeri_Batam.png" class="logo">

      <div class="mb-2">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username anda" required>
      </div>

      <div class="mb-2">
        <label for="password" class="form-label">Kata sandi</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password anda" required>
      </div>

      <button type="submit" class="btn btn-login">Login</button>

      <div class="extra-link">
        <a href="lupa1.php">Lupa password</a>
        <a href="register.php">Register</a>
      </div>
    </form>
  </div>

</body>
</html>
