<?php
session_start();
include 'config/koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    header("Location: login.php");
    exit();
}

// ==================== AMBIL SEMUA JADWAL ====================
$query_jadwal = "SELECT * FROM jadwal WHERE user_id = '$user_id' ORDER BY tanggal ASC, jam_mulai ASC";
$result_jadwal = mysqli_query($koneksi, $query_jadwal);
$jadwal_list = [];
while ($row = mysqli_fetch_assoc($result_jadwal)) {
    $jadwal_list[] = $row;
}

// ==================== AMBIL JADWAL HARI INI ====================
$hari_ini = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date('w')];
$query_today = "SELECT * FROM jadwal WHERE user_id = '$user_id' AND hari = '$hari_ini' ORDER BY jam_mulai ASC";
$result_today = mysqli_query($koneksi, $query_today);
$jadwal_today = [];
while ($row = mysqli_fetch_assoc($result_today)) {
    $jadwal_today[] = $row;
}

// Set active page
$active_page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Jika ada parameter edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $query_edit = "SELECT * FROM jadwal WHERE id = '$edit_id' AND user_id = '$user_id'";
    $result_edit = mysqli_query($koneksi, $query_edit);
    $edit_data = mysqli_fetch_assoc($result_edit);
}

// Include header
include 'includes/header.php';
?>

<!-- Include Sidebar -->
<?php include 'includes/sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <?php
    // Include all pages
    include 'pages/home.php';
    include 'pages/jadwal.php';
    include 'pages/kalender.php';
    include 'pages/profil.php';
    include 'pages/about.php';
    ?>
</div>

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>