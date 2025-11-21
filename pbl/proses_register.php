<?php
include 'koneksi.php'; // file koneksi ke database

$username = $_POST['username'];
$nim = $_POST['nim'];
$contact = $_POST['contact'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

if ($password !== $confirmPassword) {
    echo "<script>alert('Konfirmasi password tidak cocok!'); window.location.href='register.php';</script>";
    exit;
}


$check = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Username sudah terdaftar!'); window.location.href='register.php';</script>";
    exit;
}

$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, nim, contact, password)
          VALUES ('$username', '$nim', '$contact', '$passwordHash')";


if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>