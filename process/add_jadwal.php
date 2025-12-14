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
    $mata_kuliah = mysqli_real_escape_string($koneksi, $_POST['mata_kuliah']);
    $hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
    $ruangan = mysqli_real_escape_string($koneksi, $_POST['ruangan']);
    $dosen = mysqli_real_escape_string($koneksi, $_POST['dosen']);
    
    // Query INSERT
    $query = "INSERT INTO jadwal (user_id, mata_kuliah, hari, tanggal, jam_mulai, jam_selesai, ruangan, dosen, catatan) 
              VALUES ('$user_id', '$mata_kuliah', '$hari', '$tanggal', '$jam_mulai', '$jam_selesai', '$ruangan', '$dosen', '')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Jadwal berhasil ditambahkan!";
        header("Location: ../dashboard.php?page=home");
    } else {
        $_SESSION['error'] = "Gagal menambahkan jadwal: " . mysqli_error($koneksi);
        header("Location: ../dashboard.php?page=jadwal");
    }
} else {
    header("Location: ../dashboard.php");
}
exit();
?>