<?php
include 'koneksi.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT username, pw FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($db_username, $db_pw); 
    $stmt->fetch();

    if ($password === $db_pw) {
        $_SESSION['nidn'] = $db_nidn;
        $_SESSION['nama'] = $db_nama;

        $_SESSION['login_success'] = "Selamat Datang " . $_SESSION['nama'] ."!";

        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['login_error'] = "NIDN atau Password salah.";
        header("Location: login.php");
        exit();
    }

}
$stmt -> close();
$conn -> close();

?>
   