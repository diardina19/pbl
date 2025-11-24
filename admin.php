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
    
    <style>
        body {
            background: #E2C892;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, #845512 0%, #a97124 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            padding: 20px;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .nav-item {
            padding: 12px 16px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .nav-item:hover {
            background:#E2C892;
            color: white;
        }

        .nav-item.active {
            background: white;
            color: #845512;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: white;
        }

        .admin-info {
            background: #E2C892;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .admin-info small {
            opacity: 0.9;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        .logout-btn {
            margin-top: auto;
            padding: 12px 14px;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            border: none;
            background: #dc3545;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logout-btn:hover {
            transform: scale(1.05);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #fee2e2;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        @keyframes popIn {
            0% {
                transform: scale(0.7) translateY(20px);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal.show .modal-dialog {
            animation: popIn 0.3s ease-out;
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .stats-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .table-responsive {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: fixed;
                bottom: 0;
                top: auto;
                padding: 10px;
                display: flex;
                justify-content: space-around;
                z-index: 1000;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-bottom: 80px;
            }

            .logo, .logout-btn, .admin-info {
                display: none;
            }

            .nav-item {
                flex-direction: column;
                padding: 8px;
                margin: 0;
                font-size: 12px;
            }
        }
    </style>
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
                    <div class="fw-bold" id="adminName">Administrator</div>
                    <small>Admin</small>
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
    
    <script>
        // Cek login
        let loginData = JSON.parse(sessionStorage.getItem('loginData'));
        if (!loginData || loginData.role !== 'admin') {
            alert('Silakan login sebagai admin terlebih dahulu!');
            window.location.href = 'login.html';
        } else {
            document.getElementById('adminName').textContent = loginData.nama || 'Administrator';
        }

        let storedUsers = JSON.parse(localStorage.getItem('users')) || {};

        let akunList = Object.values(storedUsers).map((u, i) => ({
            id: i + 1,
            nim: u.nim,
            nama: u.nama,
            noHp: u.contact,
            password: u.password,
            status: u.status,
            tanggalDaftar: u.tanggalDaftar || '-'
        }));

        function saveToLocalStorage() {
            let usersObj = {};
            akunList.forEach(u => {
            usersObj[u.nim] = {
                nama: u.nama,
                nim: u.nim,
                contact: u.noHp,
                password: u.password,
                role: 'siswa',
                status: u.status,
                redirect: 'dashboard.html',
                tanggalDaftar: u.tanggalDaftar
            };
            });
            localStorage.setItem('users', JSON.stringify(usersObj));
        }
        // Navigation
        function showPage(page) {
            document.querySelectorAll('.page-section').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            
            document.getElementById(page + 'Page').classList.add('active');
            event.currentTarget.classList.add('active');

            if (page === 'dashboard') renderDashboard();
            if (page === 'manajemen') renderManajemen();
        }

        // Dashboard
        function renderDashboard() {
            const total = akunList.length;
            const aktif = akunList.filter(a => a.status === 'active').length;
            const nonAktif = akunList.filter(a => a.status === 'inactive').length;

            document.getElementById('totalSiswa').textContent = total;
            document.getElementById('siswaAktif').textContent = aktif;
            document.getElementById('siswaNonAktif').textContent = nonAktif;

            const recentAccounts = akunList.slice(-5).reverse();
            const html = recentAccounts.map(a => `
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                    <div>
                        <h6 class="mb-1">${a.nama}</h6>
                        <small class="text-muted">NIM: ${a.nim} | No HP: ${a.noHp}</small>
                    </div>
                    <span class="status-badge ${a.status === 'active' ? 'status-active' : 'status-inactive'}">
                        ${a.status === 'active' ? 'Aktif' : 'Non-Aktif'}
                    </span>
                </div>
            `).join('');

            document.getElementById('recentAccounts').innerHTML = html || '<p class="text-muted text-center">Belum ada akun terdaftar</p>';
        }

        // Manajemen Akun
        function renderManajemen() {
            const html = akunList.map((a, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td><strong>${a.nim}</strong></td>
                    <td>${a.nama}</td>
                    <td>${a.noHp}</td>
                    <td>
                        <span class="status-badge ${a.status === 'active' ? 'status-active' : 'status-inactive'}">
                            ${a.status === 'active' ? 'Aktif' : 'Non-Aktif'}
                        </span>
                    </td>
                    <td>${a.tanggalDaftar}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick='editAkun(${JSON.stringify(a)})' title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            ${a.status === 'active' ? 
                                `<button class="btn btn-warning btn-sm" onclick="toggleStatus(${a.id})" title="Non-aktifkan">
                                    <i class="bi bi-x-circle"></i>
                                </button>` :
                                `<button class="btn btn-info btn-sm" onclick="toggleStatus(${a.id})" title="Aktifkan">
                                    <i class="bi bi-check-circle"></i>
                                </button>`
                            }
                            <button class="btn btn-danger btn-sm" onclick="deleteAkun(${a.id})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');

            document.getElementById('akunTableBody').innerHTML = html || '<tr><td colspan="7" class="text-center text-muted">Belum ada akun terdaftar</td></tr>';
        }

        // CRUD Functions
        function openAddForm() {
            document.getElementById('modalTitle').textContent = 'Tambah Akun Siswa';
            document.getElementById('akunForm').reset();
            document.getElementById('editId').value = '';
        }

        function editAkun(akun) {
            document.getElementById('modalTitle').textContent = 'Edit Akun Siswa';
            document.getElementById('editId').value = akun.id;
            document.getElementById('nim').value = akun.nim;
            document.getElementById('nama').value = akun.nama;
            document.getElementById('noHp').value = akun.noHp;
            document.getElementById('passwordInput').value = akun.password;

            new bootstrap.Modal(document.getElementById('akunModal')).show();
        }

        function saveAkun() {
            const editId = document.getElementById('editId').value;
            const nim = document.getElementById('nim').value.trim();
            const nama = document.getElementById('nama').value.trim();
            const noHp = document.getElementById('noHp').value.trim();
            const password = document.getElementById('passwordInput').value.trim();

            if (!nim || !nama || !noHp || !password) {
                alert('Semua field wajib diisi!');
                return;
            }

            if (password.length < 6) {
                alert('Password minimal 6 karakter!');
                return;
            }

            const isDuplicate = akunList.some(a => a.nim === nim && a.id != editId);
            if (isDuplicate) {
                alert('NIM sudah terdaftar!');
                return;
            }

            const today = new Date();
            const tanggalDaftar = `${today.getDate().toString().padStart(2, '0')}-${(today.getMonth() + 1).toString().padStart(2, '0')}-${today.getFullYear()}`;

            if (editId) {
                akunList = akunList.map(a => 
                    a.id == editId ? { ...a, nim, nama, noHp, password } : a
                );
            } else {
                akunList.push({ id: Date.now(), nim, nama, noHp, password, status: 'active', tanggalDaftar });
            }

            bootstrap.Modal.getInstance(document.getElementById('akunModal')).hide();
            renderManajemen();
            renderDashboard();
        }

        function toggleStatus(id) {
            akunList = akunList.map(a => 
                a.id === id ? { ...a, status: a.status === 'active' ? 'inactive' : 'active' } : a
            );
            saveToLocalStorage();
            renderManajemen();
            renderDashboard();
        }

        function deleteAkun(id) {
            if (confirm('Apakah Anda yakin ingin menghapus akun ini?')) {
                akunList = akunList.filter(a => a.id !== id);
                saveToLocalStorage();
                renderManajemen();
                renderDashboard();
            }
        }

        function togglePasswordModal() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('toggleIconModal');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'bi bi-eye';
            }
        }

        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                sessionStorage.removeItem('loginData');
                window.location.href = 'login.html';
            }
        }

        // Initialize
        saveToLocalStorage();
        bootstrap.Modal.getInstance(document.getElementById('akunModal')).hide();
        renderDashboard();
        renderManajemen();
    </script>
</body>
</html>