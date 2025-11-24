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
    <link rel="stylesheet" href="css/dashboard.css">


</head>
<body>


<div class="sidebar d-flex flex-column">
    <div class="logo">
        <i class="bi bi-book"></i> MySchedule
    </div>

    <div class="menu-wrapper">
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
                    
                </div>
            </div>
        </div>
    </div>
    <!-- ====== JADWAL ====== -->
<div id="jadwalPage" class="page-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">Jadwal Kuliah</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#jadwalModal" onclick="openAddForm()">
            <i class="bi bi-plus-lg"></i> Tambah Jadwal
        </button>
    </div>

    <div id="jadwalList"></div>
</div>
<!-- ====== KALENDER ====== -->
<div id="kalenderPage" class="page-section">
    <div class="card shadow-lg">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <button class="btn btn-outline-secondary" onclick="changeMonth(-1)">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <h2 class="mb-0" id="calendarTitle"></h2>
                <button class="btn btn-outline-secondary" onclick="changeMonth(1)">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <div class="calendar-grid mb-3">
                <div class="text-center fw-bold py-2">Min</div>
                <div class="text-center fw-bold py-2">Sen</div>
                <div class="text-center fw-bold py-2">Sel</div>
                <div class="text-center fw-bold py-2">Rab</div>
                <div class="text-center fw-bold py-2">Kam</div>
                <div class="text-center fw-bold py-2">Jum</div>
                <div class="text-center fw-bold py-2">Sab</div>
            </div>

            <div id="calendarBody" class="calendar-grid"></div>
        </div>
    </div>
</div>
<!-- ====== ABOUT ====== -->
<div id="aboutPage" class="page-section">
    <div class="card shadow-lg mb-4">
        <div class="card-body p-5">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary mb-3">
                    <i class="bi bi-book"></i> Tentang MySchedule
                </h1>
                <p class="lead text-muted">
                    Aplikasi pengelola jadwal kuliah yang membantu mahasiswa mengatur waktu belajar dengan mudah dan efisien
                </p>
            </div>

            <!-- fitur -->
            <div class="row mb-5">
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-calendar-check text-primary" style="font-size: 40px;"></i>
                    </div>
                    <h5 class="fw-bold">Kelola Jadwal</h5>
                    <p class="text-muted">Atur jadwal kuliah dengan mudah dan praktis</p>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-clock-history text-success" style="font-size: 40px;"></i>
                    </div>
                    <h5 class="fw-bold">Pengingat Otomatis</h5>
                    <p class="text-muted">Lihat jadwal hari ini secara otomatis</p>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-grid-3x3 text-warning" style="font-size: 40px;"></i>
                    </div>
                    <h5 class="fw-bold">Tampilan Kalender</h5>
                    <p class="text-muted">Visualisasi jadwal dalam bentuk kalender</p>
                </div>
            </div>

            <!-- Tim -->
            <h2 class="fw-bold text-center mb-4">
                <i class="bi bi-people"></i> Tim Pengembang
            </h2>

            <div class="row justify-content-center">
                <div class="col-md-4 text-center mb-4">
                    <img src="WhatsApp Image 2025-10-16 at 09.34.47_819542be.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px;">
                    <h5>Andi Facha H.A</h5>
                    <small class="text-muted">NIM: 3312501111</small>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <img src="anggota.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px;">
                    <h5>Diar Dina</h5>
                    <small class="text-muted">NIM: 3312501109</small>
                </div>

                <div class="col-md-4 text-center mb-4">
                    <img src="anggota1.jpg" class="rounded-circle mb-3" style="width: 200px; height: 200px;">
                    <h5>Ita Lasari Purba</h5>
                    <small class="text-muted">NIM: 3312501112</small>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Form Jadwal -->
<div class="modal fade" id="jadwalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Jadwal</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="jadwalForm">
                    <input type="hidden" id="editId">

                    <label>Mata Kuliah</label>
                    <input type="text" class="form-control mb-2" id="mataKuliah">

                    <label>Hari</label>
                    <select class="form-select mb-2" id="hari">
                        <option>Senin</option><option>Selasa</option><option>Rabu</option>
                        <option>Kamis</option><option>Jumat</option><option>Sabtu</option>
                    </select>

                    <label>Tanggal</label>
                    <input type="text" class="form-control mb-2" id="tanggal">

                    <div class="row">
                        <div class="col-6">
                            <label>Jam Mulai</label>
                            <input type="time" class="form-control mb-2" id="jamMulai">
                        </div>
                        <div class="col-6">
                            <label>Jam Selesai</label>
                            <input type="time" class="form-control mb-2" id="jamSelesai">
                        </div>
                    </div>

                    <label>Ruangan</label>
                    <input type="text" id="ruangan" class="form-control mb-2">

                    <label>Dosen</label>
                    <input type="text" id="dosen" class="form-control mb-2">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="saveJadwal()">Simpan</button>
            </div>
        </div>
    </div>
</div>

    <footer class="footer">
    <p>© 2025 MySchedule | Tentang Kami: Aplikasi pengelola jadwal kuliah yang membantu mahasiswa mengatur waktu belajar dengan mudah.</p>
    </footer>

    <!-- HALAMAN JADWAL, KALENDER, ABOUT — sama seperti HTML kamu  (tidak perlu diubah) -->
    <!-- Tinggal copy dari file dashboard.html dan paste di sini -->
</div>



<!-- ===================== SCRIPT ===================== -->
<script>
    // semua script jadwalList, renderHome(), renderJadwal(), renderCalendar()
    // tetap sama seperti file HTML asli kamu

function showPage(page) {
    // Hilangkan semua section
    document.querySelectorAll('.page-section').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

    // Tampilkan section yang dipilih
    document.getElementById(page + 'Page').classList.add('active');

    // Tambahkan class active ke menu yang di-klik
    if (event.currentTarget) {
        event.currentTarget.classList.add('active');
    }

    // Render halaman sesuai menu
    if (page === 'home') {
        document.getElementById('searchInput').value = '';
        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('todayScheduleSection').style.display = 'block';
        renderHome();
    }
    if (page === 'jadwal') renderJadwal();
    if (page === 'kalender') renderCalendar();
}

function renderHome() {
            const today = new Date();
            const todayName = hariMap[today.getDay()];
            document.getElementById('todayName').textContent = todayName;

            const todaySchedule = jadwalList.filter(j => j.hari === todayName);
            const html = todaySchedule.length > 0 ? todaySchedule.map(j => `
                <div class="alert alert-success d-flex align-items-center home-item" id="jadwal-${j.id}">
                    <input type="checkbox" 
                        class="form-check-input me-3 home-checkbox" 
                        style="width: 24px; height: 24px;"
                        onchange="fadeOutAndDelete(${j.id})">
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-1">${j.mataKuliah}</h5>
                        <p class="mb-0">🕐 ${j.jamMulai} - ${j.jamSelesai}</p>
                        <small>📍 ${j.ruangan} | 👨‍🏫 ${j.dosen}</small>
                    </div>
                </div>
            `).join('') : '<p class="text-muted text-center">Tidak ada jadwal untuk hari ini 🎉</p>';

            document.getElementById('todaySchedule').innerHTML = html;
        }

        function renderJadwal() {
            const html = jadwalList.map(j => `
                <div class="card mb-3 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">${j.mataKuliah}</h5>
                            <p class="card-text text-muted mb-0">
                                ${j.hari} (${j.tanggal}) | ${j.jamMulai} - ${j.jamSelesai} | ${j.ruangan}
                            </p>
                            <small class="text-muted">Dosen: ${j.dosen}</small>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick='editJadwal(${JSON.stringify(j)})'>
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteJadwal(${j.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');

            document.getElementById('jadwalList').innerHTML = html || '<p class="text-muted text-center">Belum ada jadwal</p>';
        }

        function renderCalendar() {
            document.getElementById('calendarTitle').textContent = `${monthNames[currentMonth]} ${currentYear}`;

            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();

            let html = '';
            const today = new Date();

            // Previous month days
            for (let i = firstDay - 1; i >= 0; i--) {
                html += `<div class="calendar-day other-month">${daysInPrevMonth - i}</div>`;
            }

            // Current month days
            for (let date = 1; date <= daysInMonth; date++) {
                const dayOfWeek = new Date(currentYear, currentMonth, date).getDay();
                const hariName = hariMap[dayOfWeek];

                const formattedDate = `${date.toString().padStart(2, '0')}-${(currentMonth + 1).toString().padStart(2, '0')}-${currentYear}`;
                
                const jadwalHari = jadwalList.filter(j => j.tanggal === formattedDate);
                const hasEvent = jadwalHari.length > 0 ? "has-event" : "";
                
                const isToday = date === today.getDate() && 
                               currentMonth === today.getMonth() && 
                               currentYear === today.getFullYear();

                const jadwalHTML = jadwalHari.slice(0, 1).map(j => `
                        <div class="calendar-event" draggable="true" 
                            ondragstart="handleDragStart(event, ${j.id})"
                            title="${j.mataKuliah} - ${j.jamMulai}">
                            ${j.mataKuliah}
                            <div class="event-actions">
                                <button class="btn btn-primary btn-sm" onclick='editJadwal(${JSON.stringify(j)})'>
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteJadwal(${j.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    `).join('');

                const moreHTML = jadwalHari.length > 1 ? 
                    `<div class="more-events" onclick='showAllJadwal(${JSON.stringify(jadwalHari)})'>
                        +${jadwalHari.length - 1} <i class="bi bi-chevron-down"></i>
                    </div>` : '';

                html += `
                    <div class="calendar-day ${isToday ? 'today' : ''} ${hasEvent}" 
                        data-date="${date}"
                        ondragover="event.preventDefault()" 
                        ondrop="handleDrop(event, ${date})">
                        <div class="fw-bold mb-2">${date}</div>
                        ${jadwalHTML}
                        ${moreHTML}
                    </div>
                `;
            }

            // Next month days
            const remaining = 42 - (firstDay + daysInMonth);
            for (let date = 1; date <= remaining; date++) {
                html += `<div class="calendar-day other-month">${date}</div>`;
            }

            document.getElementById('calendarBody').innerHTML = html;
        }

        function changeMonth(direction) {
            currentMonth += direction;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            } else if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }

        function handleDragStart(event, id) {
            draggedItem = jadwalList.find(j => j.id === id);
        }

        function handleDrop(event, targetDate) {
            if (draggedItem) {
                const dayOfWeek = new Date(currentYear, currentMonth, targetDate).getDay();
                const targetHari = hariMap[dayOfWeek];
                
                const targetTanggal = `${targetDate.toString().padStart(2, '0')}-${(currentMonth + 1).toString().padStart(2, '0')}-${currentYear}`;
                
                jadwalList = jadwalList.map(j => 
                    j.id === draggedItem.id ? { ...j, hari: targetHari, tanggal: targetTanggal } : j
                );
                draggedItem = null;
                renderCalendar();
                renderHome();
            }
        }

        function showAllJadwal(jadwalArray) {
            const html = jadwalArray.map((j, idx) => `
                <div class="alert alert-success">
                    <h6>${idx + 1}. ${j.mataKuliah}</h6>
                    <p class="mb-1">🕐 ${j.jamMulai} - ${j.jamSelesai}</p>
                    <p class="mb-2">📍 ${j.ruangan} | 👨‍🏫 ${j.dosen}</p>
                    <div class="btn-group w-100">
                        <button class="btn btn-primary btn-sm" onclick='editJadwal(${JSON.stringify(j)})' data-bs-dismiss="modal">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteJadwal(${j.id}); bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();">
                            Hapus
                        </button>
                    </div>
                </div>
            `).join('');

            document.getElementById('detailModalBody').innerHTML = html;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        }

         renderHome();
        renderJadwal();
        renderCalendar();

</script>

</body>
</html>
