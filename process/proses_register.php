<?php
include '../config/koneksi.php'; // file koneksi ke database

$username = $_POST['username'];
$nim = $_POST['nim'];
$contact = $_POST['contact'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$role = "user"; // set role default sebagai 'user'

if ($password !== $confirmPassword) {
    echo "<script>alert('Konfirmasi password tidak cocok!'); window.location.href='../register.php';</script>";
    exit;
}


$check = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Username sudah terdaftar!'); window.location.href='../register.php';</script>";
    exit;   
}



$query = "INSERT INTO users (username, nim, contact, pw, role)
          VALUES ('$username', '$nim', '$contact', '$password', '$role')";


if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='../login.php';</script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>