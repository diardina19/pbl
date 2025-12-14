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