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
    // Escape input
    $jadwal_id = mysqli_real_escape_string($koneksi, $_POST['jadwal_id']);
    $new_date = mysqli_real_escape_string($koneksi, $_POST['new_date']);
    $old_date = mysqli_real_escape_string($koneksi, $_POST['old_date']);
    
    // Hitung hari dari tanggal baru
    $timestamp = strtotime($new_date);
    $day_index = date('w', $timestamp);
    $hari_map = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $new_hari = $hari_map[$day_index];
    
    // Update tanggal dan hari
    $query = "UPDATE jadwal SET tanggal = '$new_date', hari = '$new_hari' 
              WHERE id = '$jadwal_id' AND user_id = '$user_id'";
    
    if (mysqli_query($koneksi, $query)) {
        if (mysqli_affected_rows($koneksi) > 0) {
            $_SESSION['success'] = "Jadwal berhasil dipindahkan ke " . date('d-m-Y', strtotime($new_date)) . " (" . $new_hari . ")";
        } else {
            $_SESSION['error'] = "Jadwal tidak ditemukan atau tidak ada perubahan!";
        }
    } else {
        $_SESSION['error'] = "Gagal memindahkan jadwal: " . mysqli_error($koneksi);
    }
} else {
    $_SESSION['error'] = "Metode tidak valid!";
}

// Redirect kembali ke kalender
header("Location: ../dashboard.php?page=kalender");
exit();
?>