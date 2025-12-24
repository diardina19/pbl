<?php
session_start();
include 'config/koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$totalsiswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users"))['total'];
$akunterbaru = mysqli_query($koneksi, "SELECT username, nim, tanggal_daftar FROM users ORDER BY tanggal_daftar DESC LIMIT 5");

$nama = $_SESSION['nama'];
$nim = $_SESSION['nim'];
$contact = $_SESSION['contact'];
$role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySchedule - Admin Panel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <div class="logo">
            <i class="bi bi-shield-lock"></i> Admin Panel
        </div>

        <div class="admin-info">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle me-2" style="font-size: 24px;"></i>
                <div>
                    <div class="fw-bold" id="adminName"><?= htmlspecialchars($nama) ?></div>
                    <small><?= htmlspecialchars($role) ?></small>
                </div>
            </div>
        </div>

        <div class="nav-item active" onclick="showPage('dashboard')">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </div>
        <a href="process/manajemen.php" class="nav-item">
            <i class="bi bi-people"></i>
            <span>Manajemen Akun</span>
        </a>

        <form action="logout.php" method="POST" class="mt-auto w-100">
            <button type="submit" class="logout-btn w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Page -->
        <div id="dashboardPage" class="page-section active">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-white">Dashboard Admin 👨‍💼</h1>
                <p class="lead text-white">Kelola akun siswa dengan mudah</p>
            </div>
            <div class="row">
                <div class="col-md-10 align-items-center mx-auto mb-4">
                    <div class="stats-card">
                        <div class="d-flex flex-column align-items-center text-center">
                            <div class="icon bg-success text-white mb-2 mx-auto">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h3 class="mb-0" id="totalSiswa"><?= $totalsiswa ?></h3>
                                <small class="text-muted">Total Siswa</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header header-cream text-center">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history"></i> Akun Terdaftar Terbaru
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($akunterbaru)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td><?= htmlspecialchars($row['nim']) ?></td>
                                    <td>
                                        <?= date('d M Y', strtotime($row['tanggal_daftar'])) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>