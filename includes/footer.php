<footer class="footer">
        <p>© 2025 MySchedule | Aplikasi pengelola jadwal kuliah</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <script>
        let draggedJadwalId = null;
        let draggedOldDate = null;

        // ========== LOGOUT CONFIRMATION dengan ANIMASI ==========
        function confirmLogout() {
            Swal.fire({
                icon: 'warning',
                title: 'Yakin ingin keluar?',
                text: 'Anda akan diarahkan ke halaman login',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-box-arrow-right"></i> Ya, Keluar',
                cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading dengan animasi
                    Swal.fire({
                        title: 'Logging out...',
                        html: '<div class="spinner-border text-danger" role="status"></div><br><br>Sampai jumpa lagi! 👋',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        showClass: {
                            popup: 'animate__animated animate__zoomIn'
                        }
                    }).then(() => {
                        // Redirect ke logout.php
                        window.location.href = 'logout.php';
                    });
                }
            });
        }

        // ========== SEARCH FUNCTION ==========
        function handleSearch() {
            const query = document.getElementById('searchInput').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.jadwal-item');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(query) || query === '') {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // ========== MARK AS DONE ==========
        function markAsDone(id) {
            Swal.fire({
                title: 'Tandai Selesai?',
                text: 'Jadwal ini akan dihapus dari daftar',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Selesai',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'process/mark_done.php?id=' + id;
                }
            });
        }

        // ========== DRAG & DROP FUNCTIONS (NO AJAX) ==========
        function handleDragStart(event, jadwalId, oldDate) {
            draggedJadwalId = jadwalId;
            draggedOldDate = oldDate;
            event.dataTransfer.effectAllowed = 'move';
            event.target.style.opacity = '0.5';
        }

        function allowDrop(event) {
            event.preventDefault();
            event.currentTarget.classList.add('drag-over');
        }

        function handleDrop(event) {
            event.preventDefault();
            event.stopPropagation();
            event.currentTarget.classList.remove('drag-over');
            
            if (!draggedJadwalId) return;
            
            const targetDate = event.currentTarget.getAttribute('data-date');
            
            // Jangan submit jika di-drop ke tanggal yang sama
            if (targetDate === draggedOldDate) {
                draggedJadwalId = null;
                draggedOldDate = null;
                return;
            }
            
            Swal.fire({
                title: 'Pindahkan Jadwal?',
                text: 'Jadwal akan dipindahkan ke tanggal ini',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Pindahkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form
                    document.getElementById('dragJadwalId').value = draggedJadwalId;
                    document.getElementById('dragNewDate').value = targetDate;
                    document.getElementById('dragOldDate').value = draggedOldDate;
                    document.getElementById('dragDropForm').submit();
                }
                draggedJadwalId = null;
                draggedOldDate = null;
            });
        }

        // Remove drag-over class
        document.addEventListener('dragleave', function(e) {
            if (e.target.classList.contains('calendar-day')) {
                e.target.classList.remove('drag-over');
            }
        });

        document.addEventListener('dragend', function(e) {
            if (e.target.classList.contains('calendar-event')) {
                e.target.style.opacity = '1';
            }
        });

        // ========== MODAL FUNCTIONS ==========
        function resetForm() {
            document.getElementById('jadwalFormElement').action = 'process/add_jadwal.php';
            document.getElementById('jadwalFormElement').reset();
            document.getElementById('jadwalId').value = '';
            document.getElementById('jadwalModalTitle').innerHTML = '<i class="bi bi-plus-circle"></i> Tambah Jadwal';
            document.getElementById('jadwalTanggal').value = new Date().toISOString().split('T')[0];
            document.getElementById('jadwalJamMulai').value = '08:00';
            document.getElementById('jadwalJamSelesai').value = '10:00';
        }

        function editJadwalModal(jadwal) {
            document.getElementById('jadwalFormElement').action = 'process/edit_jadwal.php';
            document.getElementById('jadwalModalTitle').innerHTML = '<i class="bi bi-pencil"></i> Edit Jadwal';
            document.getElementById('jadwalId').value = jadwal.id;
            document.getElementById('jadwalMataKuliah').value = jadwal.mata_kuliah;
            document.getElementById('jadwalHari').value = jadwal.hari;
            document.getElementById('jadwalTanggal').value = jadwal.tanggal;
            document.getElementById('jadwalJamMulai').value = jadwal.jam_mulai;
            document.getElementById('jadwalJamSelesai').value = jadwal.jam_selesai;
            document.getElementById('jadwalRuangan').value = jadwal.ruangan;
            document.getElementById('jadwalDosen').value = jadwal.dosen;
            
            const modal = new bootstrap.Modal(document.getElementById('jadwalModal'));
            modal.show();
        }

        // ========== KALENDER: CLICK DAY TO ADD ==========
        function openAddJadwalWithDate(date) {
            resetForm();
            document.getElementById('jadwalTanggal').value = date;
            
            // Calculate day name
            const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const dateObj = new Date(date + 'T00:00:00');
            const dayName = dayNames[dateObj.getDay()];
            document.getElementById('jadwalHari').value = dayName;
            
            const modal = new bootstrap.Modal(document.getElementById('jadwalModal'));
            modal.show();
        }

        // ========== SHOW MULTIPLE SCHEDULES POPUP ==========
        function showAllJadwalPopup(jadwalArray) {
            let html = '';
            jadwalArray.forEach((j, idx) => {
                html += `
                    <div class="alert alert-success mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold">${idx + 1}. ${j.mata_kuliah}</h6>
                                <p class="mb-1">🕐 ${j.jam_mulai} - ${j.jam_selesai}</p>
                                <p class="mb-0">📍 ${j.ruangan} | 👨‍🏫 ${j.dosen}</p>
                            </div>
                            <div class="btn-group-vertical btn-group-sm">
                                <a href="dashboard.php?page=kalender&edit=${j.id}" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-danger" onclick="confirmDelete('${j.mata_kuliah}', ${j.id}, 'kalender')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            document.getElementById('multipleScheduleBody').innerHTML = html;
            const modal = new bootstrap.Modal(document.getElementById('multipleScheduleModal'));
            modal.show();
        }

        // ========== DELETE CONFIRMATION ==========
        function confirmDelete(mataKuliah, id, redirect) {
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Jadwal?',
                text: 'Apakah Anda yakin ingin menghapus jadwal ' + mataKuliah + '?',
                showConfirmButton: true,
                confirmButtonText: 'Ya, Hapus',
                confirmButtonColor: '#dc3545',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'process/delete_jadwal.php?id=' + id + '&redirect=' + redirect;
                }
            });
        }
    </script>
    
    <?php if (isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?php echo $_SESSION['success']; ?>',
            timer: 2000,
            showConfirmButton: false,
            showClass: {
                popup: 'animate__animated animate__bounceIn'
            }
        });
    </script>
    <?php unset($_SESSION['success']); endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?php echo $_SESSION['error']; ?>',
            showConfirmButton: true
        });
    </script>
    <?php unset($_SESSION['error']); endif; ?>
    
    <?php if (isset($edit_data) && $edit_data): ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            editJadwalModal(<?php echo json_encode($edit_data); ?>);
        });
    </script>
    <?php endif; ?>
</body>
</html>