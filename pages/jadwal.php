<div id="jadwalPage" class="page-section <?php echo ($active_page == 'jadwal') ? 'active' : ''; ?>">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white">Jadwal Kuliah</h1>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#jadwalModal" onclick="resetForm()">
            <i class="bi bi-plus-lg"></i> Tambah Jadwal
        </button>
    </div>

    <?php if (empty($jadwal_list)): ?>
        <div class="text-center text-white p-5">
            <i class="bi bi-calendar-x" style="font-size: 64px;"></i>
            <p class="mt-3">Belum ada jadwal. Klik tombol "Tambah Jadwal".</p>
        </div>
    <?php else: ?>
        <?php foreach ($jadwal_list as $jadwal): ?>
        <div class="card mb-3 shadow-sm jadwal-item">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($jadwal['mata_kuliah']); ?></h5>
                    <p class="card-text text-muted mb-0">
                        <?php echo $jadwal['hari']; ?> (<?php echo date('d-m-Y', strtotime($jadwal['tanggal'])); ?>) | 
                        <?php echo $jadwal['jam_mulai']; ?> - <?php echo $jadwal['jam_selesai']; ?> | 
                        <?php echo htmlspecialchars($jadwal['ruangan']); ?>
                    </p>
                    <small class="text-muted">Dosen: <?php echo htmlspecialchars($jadwal['dosen']); ?></small>
                </div>
                <div class="btn-group">
                    <a href="dashboard.php?page=jadwal&edit=<?php echo $jadwal['id']; ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete('<?php echo htmlspecialchars($jadwal['mata_kuliah']); ?>', <?php echo $jadwal['id']; ?>, 'jadwal')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Modal Form -->
<div class="modal fade" id="jadwalModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="jadwalFormElement">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="jadwalModalTitle">
                        <i class="bi bi-plus-circle"></i> Tambah Jadwal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="jadwalId">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-book"></i> Mata Kuliah <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="mata_kuliah" id="jadwalMataKuliah" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-calendar3"></i> Hari</label>
                        <select class="form-select" name="hari" id="jadwalHari">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-calendar-event"></i> Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="jadwalTanggal">
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold"><i class="bi bi-clock"></i> Jam Mulai</label>
                            <input type="time" class="form-control" name="jam_mulai" id="jadwalJamMulai">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold"><i class="bi bi-clock-fill"></i> Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai" id="jadwalJamSelesai">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-door-closed"></i> Ruangan</label>
                        <input type="text" class="form-control" name="ruangan" id="jadwalRuangan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-person-badge"></i> Dosen</label>
                        <input type="text" class="form-control" name="dosen" id="jadwalDosen">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>