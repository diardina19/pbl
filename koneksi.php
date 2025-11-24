<?php

$host = "localhost";
$username   = "root";
$password   = "";
$db   = "pbl"; 

$koneksi = mysqli_connect($host, $username, $password, $db);

if (!$koneksi) {
    die("Gagal mengakses Database : " . mysqli_connect_error());
}

?>
