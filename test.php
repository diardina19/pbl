<?php
include 'koneksi.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $koneksi->prepare("SELECT username, pw, id, nim, contact FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($db_username, $db_pw, $db_id, $db_nim, $db_contact); 
    $stmt->fetch();

    if ($password === $db_pw) {
        $_SESSION['nama'] = $db_username;
        $_SESSION['nim'] = $db_nim;
        $_SESSION['contact'] = $db_contact;
        $_SESSION['user_id'] = $db_id;
      

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
$koneksi -> close();

?>
   