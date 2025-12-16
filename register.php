<?php
include 'config/koneksi.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user    = mysqli_real_escape_string($koneksi, $_POST['user']);
    $nim     = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $contact = mysqli_real_escape_string($koneksi, $_POST['contact']);
    $pass    = mysqli_real_escape_string($koneksi, $_POST['pass']);

    $role = 'user';

    // Cek username sudah digunakan
    $cekUser = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user'");

    if (mysqli_num_rows($cekUser) > 0) {
        $error = "Username sudah digunakan, silakan pilih username lain.";
    } else {

        $simpan = mysqli_query($koneksi, 
            "INSERT INTO users (username, nim, contact, pw, role, tanggal_daftar)
             VALUES ('$user', '$nim', '$contact', '$pass', '$role', NOW())"
        );

        if ($simpan) {
            $success = "Registrasi berhasil. Silakan login.";
        } else {
            $error = "Registrasi gagal. Coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/registrasi.css">
</head>
<body>
<div class="form-container">
    <div class="row justify-content-center">
        <img src="https://upload.wikimedia.org/wikipedia/id/2/2c/Politeknik_Negeri_Batam.png" alt="logo">

            <h3 class="text-center">Registrasi Akun</h3>

            <?php if ($success) : ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php elseif ($error) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="user" class="form-label">Username</label>
                    <input type="text" class="form-control" id="user" name="user" required>
                </div>

                <div class="mb-2">
                    <label for="nim" class="form-label">Nim</label>
                    <input type="text" class="form-control" id="nim" name="nim" required>
                </div>

                <div class="mb-2">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" required>
                </div>

                <div class="mb-2">
                    <label for="pass" class="form-label">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass" required>
                </div>

                <button type="submit" class="btn bg-white w-100">Daftar</button>
                <a href="login.php" class="btn btn-link w-100 mt-2">Sudah punya akun? Login</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

