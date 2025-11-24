<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - Step 3</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: url('https://www.polibatam.ac.id/wp-content/uploads/2022/07/MG_8893-scaled.jpg') center/cover no-repeat;
    }
    .card {
      background: rgba(255, 255, 255, 0.43);
      backdrop-filter: blur(10px);
      border-radius: 40px;
      border: none;
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
    }
    .logo {
      width: 100px;
      margin: 0 auto 20px;
      display: block;
    }
    .card-title {
      color: #845512;
      font-weight: 600;
    }
    .form-control {
      border-radius: 30px;
      border: 1px solid #E2C892;
      padding: 10px 20px;
    }
    .form-control:focus {
      border-color: #845512;
      box-shadow: 0 0 10px rgba(132, 85, 18, 0.3);
      transform: scale(1.02);
    }
    .btn-primary {
      background-color: #E2C892;
      border: none;
      border-radius: 30px;
      padding: 10px;
      font-weight: 600;
      width: 100%;
    }
    .btn-primary:hover {
      background-color: #845512;
      transform: scale(0.98);
    }
    label {
      font-weight: 600;
      color: #0e0e0e;
      margin-bottom: 8px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card p-4">
        <div class="card-body">
          <img src="https://upload.wikimedia.org/wikipedia/id/2/2c/Politeknik_Negeri_Batam.png" alt="logo" class="logo">
          
          <h2 class="card-title text-center mb-4">Password Baru</h2>
          
          <form id="step3Form">
            <div class="mb-3">
              <label for="newPassword" class="form-label">Password Baru</label>
              <input type="password" class="form-control" id="newPassword" placeholder="Masukkan password baru" required>
            </div>

            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
              <input type="password" class="form-control" id="confirmPassword" placeholder="Konfirmasi password baru" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('step3Form').addEventListener('submit', function(e) {
    e.preventDefault();

    const newPassword = document.getElementById('newPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    // Validasi kosong
    if (newPassword === '' || confirmPassword === '') {
      alert('Kolom password tidak boleh kosong!');
      return;
    }

    // Minimal 8 karakter
    if (newPassword.length < 8) {
      alert('Password minimal 8 karakter!');
      return;
    }

    // Minimal 6 karakter harus huruf atau angka
    if (!/[A-Za-z0-9]{6,}/.test(newPassword)) {
      alert('Password harus mengandung minimal 6 huruf atau angka!');
      return;
    }

    // Harus ada huruf besar
    if (!/[A-Z]/.test(newPassword)) {
      alert('Password harus mengandung huruf besar!');
      return;
    }

    // Harus ada huruf kecil
    if (!/[a-z]/.test(newPassword)) {
      alert('Password harus mengandung huruf kecil!');
      return;
    }

    // Harus ada angka
    if (!/[0-9]/.test(newPassword)) {
      alert('Password harus mengandung angka!');
      return;
    }

    // Konfirmasi harus sama
    if (newPassword !== confirmPassword) {
      alert('Konfirmasi password tidak cocok!');
      return;
    }

    // Kalau semua validasi lolos
    alert('Password berhasil direset!');
    window.location.href = 'login.html';
  });
</script>


</body>
</html>