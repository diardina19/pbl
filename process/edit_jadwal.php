<?php
session_start();
require '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Cek apakah form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape semua input
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $mata_kuliah = mysqli_real_escape_string($koneksi, $_POST['mata_kuliah']);
    $hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
    $ruangan = mysqli_real_escape_string($koneksi, $_POST['ruangan']);
    $dosen = mysqli_real_escape_string($koneksi, $_POST['dosen']);
    
    // Query UPDATE
    $query = "UPDATE jadwal SET 
              mata_kuliah = '$mata_kuliah',
              hari = '$hari',
              tanggal = '$tanggal',
              jam_mulai = '$jam_mulai',
              jam_selesai = '$jam_selesai',
              ruangan = '$ruangan',
              dosen = '$dosen'
              WHERE id = '$id' AND user_id = '$user_id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Jadwal berhasil diupdate!";
        header("Location: ../dashboard.php?page=jadwal");
    } else {
        $_SESSION['error'] = "Gagal mengupdate jadwal: " . mysqli_error($koneksi);
        header("Location: ../dashboard.php?page=jadwal");
    }
} else {
    header("Location: ../dashboard.php");
}
exit();
?>