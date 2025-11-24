<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // cek berdasarkan username ATAU nim
    $query = "SELECT * FROM users WHERE username='$input' OR nim='$input'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

    // Verifikasi password
    if ($password === $user['pw']) {

        if ($user['status'] === 'inactive') {
            echo "<script>alert('Akun Anda dinonaktifkan!'); window.location.href='login.php';</script>";
            exit;
        }

        // Simpan session user
        $_SESSION['user'] = [
            'nama' => $user['username'],
            'nim'  => $user['nim'],
            'role' => $user['role']
        ];

        // Redirect sesuai role
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;

    } else {
        echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
        exit;
    }

} else {
    echo "<script>alert('Akun tidak ditemukan!'); window.location.href='login.php';</script>";
    exit;
}}
