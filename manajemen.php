<?php
session_start();
require 'koneksi.php';

// =====================
// CEK LOGIN & ROLE ADMIN
// =====================
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// =====================
// PROSES TAMBAH AKUN
// =====================
if (isset($_POST['tambahAkun'])) {
    $nim      = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $contact  = mysqli_real_escape_string($koneksi, $_POST['contact']);
    $pw       = mysqli_real_escape_string($koneksi, $_POST['password']);
    $status   = 'aktif';
    $role     = 'user';

    mysqli_query($koneksi, "
        INSERT INTO users (nim, username, contact, pw, status, role)
        VALUES ('$nim', '$username', '$contact', '$pw', '$status', '$role')
    ");

    header("Location: manajemen.php");
    exit();
}

// =====================
// PROSES AKTIF / NONAKTIF
// =====================
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($_GET['aksi'] === 'nonaktif') {
        mysqli_query($koneksi, "UPDATE users SET status='nonaktif' WHERE id=$id");
    } elseif ($_GET['aksi'] === 'aktif') {
        mysqli_query($koneksi, "UPDATE users SET status='aktif' WHERE id=$id");
    }

    header("Location: manajemen.php");
    exit();
}

// =====================
// AMBIL DATA USERS
// =====================
$users = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");

$namaAdmin = $_SESSION['username'] ?? 'Admin';
$roleAdmin = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Manajemen Akun</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- CSS Admin -->
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar d-flex flex-column">
    <div class="logo">
        <i class="bi bi-shield-lock"></i> Admin Panel
    </div>

    <div class="admin-info">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle me-2 fs-4"></i>
            <div>
                <div class="fw-bold"><?= htmlspecialchars($namaAdmin) ?></div>
                <small><?= htmlspecialchars($roleAdmin) ?></small>
            </div>
        </div>
    </div>

    <a href="admin.php" class="nav-item">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="manajemen.php" class="nav-item active">
        <i class="bi bi-people"></i>
        <span>Manajemen Akun</span>
    </a>

    <form action="logout.php" method="POST" class="mt-auto">
        <button class="logout-btn">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-white">🔐 Manajemen Akun Siswa</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#akunModal">
                <i class="bi bi-plus-lg"></i> Tambah Akun
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; while($row = mysqli_fetch_assoc($users)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nim']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['contact']) ?></td>
                            <td>
                                <?php if ($row['status'] === 'aktif') : ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else : ?>
                                    <span class="badge bg-danger">Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] === 'aktif') : ?>
                                    <a href="?aksi=nonaktif&id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Nonaktifkan akun ini?')">
                                       Nonaktifkan
                                    </a>
                                <?php else : ?>
                                    <a href="?aksi=aktif&id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-success"
                                       onclick="return confirm('Aktifkan akun ini?')">
                                       Aktifkan
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL TAMBAH AKUN -->
<div class="modal fade" id="akunModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success" name="tambahAkun">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>