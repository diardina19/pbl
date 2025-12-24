<?php
session_start();
include '../config/koneksi.php';

// CEK LOGIN & ROLE ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// PROSES TAMBAH AKUN
if (isset($_POST['tambahAkun'])) {
    $nim      = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $contact  = mysqli_real_escape_string($koneksi, $_POST['contact']);
    $pw       = mysqli_real_escape_string($koneksi, $_POST['password']);
    $status   = 'aktif';
    $role     = 'user';

    $query = "INSERT INTO users (nim, username, contact, pw, role) 
              VALUES ('$nim', '$username', '$contact', '$pw', '$role')";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Akun berhasil ditambahkan!";
    } else {
        $_SESSION['error'] = "Gagal menambahkan akun: " . mysqli_error($koneksi);
    }

    header("Location: process/manajemen.php");
    exit();
}

// PROSES EDIT AKUN
if (isset($_POST['editAkun'])) {
    $id       = intval($_POST['id']);
    $nim      = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $contact  = mysqli_real_escape_string($koneksi, $_POST['contact']);
    
    $query = "UPDATE users SET nim='$nim', username='$username', contact='$contact'";
    
    // Update password jika diisi
    if (!empty($_POST['password'])) {
        $pw = mysqli_real_escape_string($koneksi, $_POST['password']);
        $query .= ", pw='$pw'";
    }
    
    $query .= " WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Akun berhasil diperbarui!";
    } else {
        $_SESSION['error'] = "Gagal memperbarui akun: " . mysqli_error($koneksi);
    }

    header("Location: process/manajemen.php");
    exit();
}

// PROSES HAPUS AKUN
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM users WHERE id=$id";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Akun berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus akun: " . mysqli_error($koneksi);
    }

    header("Location: process/manajemen.php");
    exit();
}

// AMBIL DATA USERS
$users = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id DESC");

$namaAdmin = $_SESSION['username'] ?? 'Admin';
$roleAdmin = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manajemen Akun</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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

    <a href="../admin.php" class="nav-item">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="process/manajemen.php" class="nav-item active">
        <i class="bi bi-people"></i>
        <span>Manajemen Akun</span>
    </a>

    <form action="../logout.php" method="POST" class="mt-auto w-100">
        <button type="submit" class="logout-btn w-100">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container py-4">



        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-white">🔐 Manajemen Akun Siswa</h3>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahAkunModal">
                <i class="bi bi-plus-lg"></i> Tambah Akun
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $no = 1; 
                        while($row = mysqli_fetch_assoc($users)) : 
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nim']) ?></td>
                                <td>
                                    <i class="bi bi-person-circle text-secondary me-2"></i>
                                    <?= htmlspecialchars($row['username']) ?>
                                </td>
                                <td><?= htmlspecialchars($row['contact']) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editAkunModal"
                                            onclick="editAkun(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nim'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['username'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['contact'], ENT_QUOTES) ?>')">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <a href="?aksi=hapus&id=<?= $row['id'] ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus akun ini?')">
                                       <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL TAMBAH AKUN -->
<div class="modal fade" id="tambahAkunModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Tambah Akun Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                    <input type="text" name="nim" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP <span class="text-danger">*</span></label>
                    <input type="text" name="contact" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Batal
                </button>
                <button type="submit" class="btn btn-success" name="tambahAkun">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT AKUN -->
<div class="modal fade" id="editAkunModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Akun Siswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="mb-3">
                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                    <input type="text" name="nim" id="edit_nim" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="username" id="edit_username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">No HP <span class="text-danger">*</span></label>
                    <input type="text" name="contact" id="edit_contact" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password baru">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Batal
                </button>
                <button type="submit" class="btn btn-warning" name="editAkun">
                    <i class="bi bi-check-lg"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editAkun(id, nim, username, contact) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nim').value = nim;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_contact').value = contact;
}


</script>
</body>
</html>