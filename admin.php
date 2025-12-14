<?php
session_start();
require 'koneksi.php';

// cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$nama = $_SESSION['nama'];
$nim  = $_SESSION['nim'];
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
        <div class="nav-item" onclick="showPage('manajemen')">
            <i class="bi bi-people"></i>
            <span>Manajemen Akun</span>
        </div>

        <button class="logout-btn" onclick="logout()">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </button>
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
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-success text-white me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h3 class="mb-0" id="totalSiswa">0</h3>
                                <small class="text-muted">Total Siswa</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-primary text-white me-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h3 class="mb-0" id="siswaAktif">0</h3>
                                <small class="text-muted">Siswa Aktif</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-danger text-white me-3">
                                <i class="bi bi-x-circle-fill"></i>
                            </div>
                            <div>
                                <h3 class="mb-0" id="siswaNonAktif">0</h3>
                                <small class="text-muted">Siswa Non-Aktif</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg mt-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">Akun Terdaftar Terbaru</h4>
                    <div id="recentAccounts"></div>
                </div>
            </div>
        </div>

        <!-- Manajemen Akun Page -->
        <div id="manajemenPage" class="page-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-white">Manajemen Akun Siswa</h1>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#akunModal" onclick="openAddForm()">
                    <i class="bi bi-plus-lg"></i> Tambah Akun Siswa
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="akunTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form Akun -->
    <div class="modal fade" id="akunModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Akun Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="akunForm">
                        <input type="hidden" id="editId">
                        
                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nim" placeholder="Contoh: 2023010001" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" placeholder="Contoh: Ahmad Fauzi" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="noHp" placeholder="Contoh: 081234567890" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="passwordInput" placeholder="Minimal 6 karakter" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordModal()">
                                    <i class="bi bi-eye" id="toggleIconModal"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="saveAkun()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>