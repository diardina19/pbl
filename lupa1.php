<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - Step 1</title>
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
    .back-link {
      color: #845512;
      text-decoration: none;
      font-weight: 600;
    }
    .back-link:hover {
      color: #E2C892;
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
          
          <h2 class="card-title text-center mb-4">Lupa Password</h2>
          
          <form id="step1Form">
            <div class="mb-3">
              <label for="nim" class="form-label">NIM</label>
              <input type="text" class="form-control" id="nim" placeholder="Masukkan NIM anda" required>
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">No. Telepon</label>
              <input type="tel" class="form-control" id="phone" placeholder="Masukkan nomor telepon anda" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Selanjutnya</button>

            <div class="text-center mt-3">
              <a href="login.html" class="back-link">← Kembali ke Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('step1Form').addEventListener('submit', function(e) {
    e.preventDefault();

    const nim = document.getElementById('nim').value.trim();
    const phone = document.getElementById('phone').value.trim();

    if (nim === '' || phone === '') {
      alert('Semua kolom harus diisi!');
      return;
    }

    if (phone.length < 10 || phone.length > 13) {
      alert('Nomor telepon harus 10–13 digit!');
      return;
    }

    // Simpan data sementara (misalnya di sessionStorage)
    const resetData = { nim, phone, code: "123456" }; 
    sessionStorage.setItem('resetData', JSON.stringify(resetData));

    // Lanjut ke halaman berikut
    window.location.href = 'regis2.html';
  });
</script>


</body>
</html>