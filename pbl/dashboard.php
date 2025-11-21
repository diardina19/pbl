<?php
session_start();
require 'koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ambil data user
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query);

// jika user tidak ditemukan
if (!$user) {
    header("Location: login.php");
    exit();
}

// variabel PHP → Javascript
$nama = $user['username'];
$nim  = $user['nim'];
$contact = $user['contact'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySchedule - Jadwal Kuliah</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        
    </style>
</head>
<body>


<div class="sidebar d-flex flex-column">
    <div class="logo">
        <i class="bi bi-book"></i> MySchedule
    </div>

    <div class="user-info">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle me-2" style="font-size: 24px;"></i>
            <div>
                <div class="fw-bold" id="userName"><?= $nama ?></div>
                <small id="userNim">NIM: <?= $nim ?></small>
            </div>
        </div>
    </div>

    <div class="nav-item active" onclick="showPage('home')">
        <i class="bi bi-house-door"></i> Home
    </div>
    <div class="nav-item" onclick="showPage('jadwal')">
        <i class="bi bi-journal-text"></i> Jadwal
    </div>
    <div class="nav-item" onclick="showPage('kalender')">
        <i class="bi bi-calendar3"></i> Kalender
    </div>
    <div class="nav-item" onclick="showPage('profil')">
        <i class="bi bi-person"></i> Profil
    </div>
    <div class="nav-item" onclick="showPage('about')">
        <i class="bi bi-info-circle"></i> About
    </div>

    <form action="logout.php" method="POST">
        <button class="logout-btn">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>


<!-- ===================== MAIN CONTENT ===================== -->
<div class="main-content">

    <!-- ====== HOME ====== -->
    <div id="homePage" class="page-section active">
        <div class="text-center mb-4">
            <h1 class="display-4 fw-bold text-white">
                Selamat Datang, <span id="welcomeName"><?= explode(" ", $nama)[0] ?></span>! 👋
            </h1>
            <p class="lead text-white">Kelola jadwal kuliah Anda dengan mudah</p>
        </div>

        <!-- Search -->
        <div class="search-box">
            <input type="text" id="searchInput" class="form-control"
                   placeholder="Cari jadwal..." oninput="handleSearch()">
            <i class="bi bi-search search-icon"></i>
        </div>

        <div id="searchResults" style="display:none;"></div>

        <!-- Jadwal hari ini -->
        <div id="todayScheduleSection">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2>Jadwal Hari Ini (<span id="todayName"></span>)</h2>
                    <div id="todaySchedule"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== PROFIL ====== -->
    <div id="profilPage" class="page-section">
        <div class="card shadow-lg" style="max-width:500px;margin:auto;">
            <div class="card-body text-center p-5">
                <div class="rounded-circle bg-success mb-3"
                    style="width:120px;height:120px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-fill text-white" style="font-size:60px;"></i>
                </div>
                <h2><?= $nama ?></h2>

                <div class="text-start mt-4">
                    <p><strong>NIM:</strong> <?= $nim ?></p>
                    <p><strong>Kontak:</strong> <?= $contact ?></p>
                    <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                    <p><strong>Login via PHP Session</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- HALAMAN JADWAL, KALENDER, ABOUT — sama seperti HTML kamu  (tidak perlu diubah) -->
    <!-- Tinggal copy dari file dashboard.html dan paste di sini -->
</div>



<!-- ===================== SCRIPT ===================== -->
<script>
    // semua script jadwalList, renderHome(), renderJadwal(), renderCalendar()
    // tetap sama seperti file HTML asli kamu
</script>

</body>
</html>
