<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Escape input agar aman dari SQL injection dasar
    $user = mysqli_real_escape_string($koneksi, $_POST['username']);
    $pass = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query sederhana
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user'");
    $row   = mysqli_fetch_assoc($query);

    // Cek kecocokan password (plain text)
    if ($row && $pass === $row['pw']) {

        // Set session
        $_SESSION['nama']    = $row['username'];
        $_SESSION['nim']     = $row['nim'];
        $_SESSION['contact'] = $row['contact'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role']    = $row['role'];

        // Redirect sesuai role
        if ($row['role'] === 'admin') {
            $_SESSION['login_success_admin'] = "Selamat Datang " . $row['username'] . "!";
            header("Location: ../admin.php");
        } else {
            $_SESSION['login_success_user'] = "Selamat Datang " . $row['username'] . "!";
            header("Location: ../dashboard.php");
        }
        exit();

    } else {
        $_SESSION['login_error'] = "Username atau Password salah.";
        header("Location: ../login.php");
        exit();
    }
}
?>