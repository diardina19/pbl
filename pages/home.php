<div id="homePage" class="page-section <?php echo ($active_page == 'home') ? 'active' : ''; ?>">
    <div class="text-center mb-4">
        <h1 class="display-4 fw-bold text-white">
            Selamat Datang, <?php echo explode(" ", $user['username'])[0]; ?>! 👋
        </h1>
        <p class="lead text-white">Kelola jadwal kuliah Anda dengan mudah</p>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <input type="text" class="form-control" id="searchInput" 
               placeholder="Cari jadwal kuliah atau dosen..." onkeyup="handleSearch()">
        <i class="bi bi-search search-icon"></i>
    </div>

    <!-- Today Schedule -->
    <div class="card shadow-lg">
        <div class="card-body p-4">
            <h2>Jadwal Hari Ini (<?php echo $hari_ini; ?>)</h2>
            <?php if (empty($jadwal_today)): ?>
                <p class="text-muted text-center">Tidak ada jadwal untuk hari ini 🎉</p>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($jadwal_today as $jadwal): ?>
                    <div class="col-md-6 mb-3 jadwal-item fade-in">
                        <div class="alert alert-success d-flex align-items-center justify-content-between">
                            <div class="flex-grow-1">
                                <h5 class="alert-heading mb-1"><?php echo htmlspecialchars($jadwal['mata_kuliah']); ?></h5>
                                <p class="mb-0">🕐 <?php echo $jadwal['jam_mulai']; ?> - <?php echo $jadwal['jam_selesai']; ?></p>
                                <small>📍 <?php echo htmlspecialchars($jadwal['ruangan']); ?> | 👨‍🏫 <?php echo htmlspecialchars($jadwal['dosen']); ?></small>
                            </div>
                            <button class="btn btn-sm btn-outline-success ms-2" onclick="markAsDone(<?php echo $jadwal['id']; ?>)" title="Tandai Selesai">
                                <i class="bi bi-check-lg"></i> Selesai
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>