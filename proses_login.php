<?php
include 'koneksi.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $koneksi->prepare("SELECT username, pw, id, nim, contact, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($db_username, $db_pw, $db_id, $db_nim, $db_contact, $db_role); 
    $stmt->fetch();

    if ($password === $db_pw) {
        $_SESSION['nama'] = $db_username;
        $_SESSION['nim'] = $db_nim;
        $_SESSION['contact'] = $db_contact;
        $_SESSION['user_id'] = $db_id;
        $_SESSION['role'] = $db_role;
        
        if ($_SESSION['role'] === "admin") {

            $_SESSION['login_success_admin'] = "Selamat Datang " . $_SESSION['nama'] ."!";

            header("Location: admin.php");
            exit();
        } else if ($_SESSION["role"] == "user") {
            $_SESSION["login_succes_admin"] = "Selamat Datang ". $_SESSION["nama"] . "!";
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "NIDN atau Password salah.";
        header("Location: login.php");
        exit();
    }

}
$stmt -> close();
$koneksi -> close();

?>
   