<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi | PBL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    * { font-family: 'Poppins', sans-serif; } /* Mengatur font global */
    body { /* Mengatur body */
      min-height: 100vh;
      background: url('https://www.polibatam.ac.id/wp-content/uploads/2022/07/MG_8893-scaled.jpg') center/cover no-repeat;
      display: flex; justify-content: center; align-items: center;
    }
    .form-container { /* kontainer formulir registrasi */
      width: 40%; background: rgba(255, 255, 255, 0.43);
      border-radius: 40px; 
      padding: 30px 40px;
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(10px);
    }
    .form-container img { /* logo */
      display: block; 
      margin: 0 auto 15px; 
      width: 20%;
    }
    .form-container h2 { /* judul formulir */
      text-align: center; 
      font-weight: 600; 
      margin-bottom: 15px; 
      color: #333; 
    }
    .form-label {  /* label formulir */
      font-weight: 600; color: #0e0e0e; 
    }
    .form-control { /* input formulir */
      border-radius: 30px; 
      border: 1px solid #E2C892; 
      transition: all 0.3s ease;
    }
    .form-control:focus { /* fokus input */
      transform: scale(1.05); 
      box-shadow: 0 0 10px #845512; 
      border-color: #E2C892;
    }
    .btn-register { /* tombol registrasi */
      background-color: #E2C892; border: none; color: white; 
      font-weight: 600; border-radius: 30px; padding: 10px; 
      transition: all 0.3s;
    }
    .btn-register:hover { /* hover tombol registrasi */
      box-shadow: 0 0 10px #845512, 0 0 20px #845512, 0 0 60px #845512;
      transform: scale(0.95);
    }
    .registrasi-a { /* link ke halaman login */
      display: block; 
      text-align: center; 
      margin-top: 10px;
      color: #845512; 
      font-weight: 600; 
      text-decoration: none;
    }
    .registrasi-a:hover { /* hover link ke halaman login */
        color: #E2C892; 
        text-decoration: underline; }
    @media (max-width: 768px) 
    { .form-container 
        { width: 90%; 
            padding: 25px; } }
  </style>
</head>
<body>

<div class="form-container"> <!-- kontainer formulir registrasi --->
  <form action="process/proses_register.php" method="POST"> 
    <img src="https://upload.wikimedia.org/wikipedia/id/2/2c/Politeknik_Negeri_Batam.png" alt="logo"> 
    <h2>Form Registrasi</h2>

    <div class="mb-2"> 
      <label class="form-label">Username</label>
      <input type="text" class="form-control" name="username" placeholder="Masukkan Username Anda" required>
    </div>

    <div class="mb-2">
      <label class="form-label">NIM</label>
      <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM Anda" required>
    </div>

    <div class="mb-2">
      <label class="form-label">Contact</label>
      <input type="text" class="form-control" name="contact" placeholder="Masukan Contact Anda" required>
    </div>

    <div class="mb-2">
      <label class="form-label">Password</label>
      <input type="password" class="form-control" name="password" placeholder="Masukkan Password Anda" required>
    </div>

    <div class="mb-2">
      <label class="form-label">Konfirmasi Password</label>
      <input type="password" class="form-control" name="confirmPassword" placeholder="Konfirmasi Password Anda" required>
    </div>

    <button type="submit" class="btn btn-register w-100">Registrasi</button>

    <a href="login.php" class="registrasi-a">Sudah punya akun?</a>
  </form>
</div>

</body>
</html>
