<div id="profilPage" class="page-section <?php echo ($active_page == 'profil') ? 'active' : ''; ?>">
    <div class="container py-4">
        <div class="card shadow" style="max-width:500px;margin:auto;border-radius:10px;">
            <div class="card-body p-4">
                <!-- Avatar -->
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-warning mx-auto mb-3"
                        style="width:100px;height:100px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-person-fill text-white" style="font-size:50px;"></i>
                    </div>
                    <h3 class="mb-1"><?php echo htmlspecialchars($user['username']); ?></h3>
                    <small class="text-muted">Mahasiswa</small>
                </div>

                <!-- Info -->
                <div class="border-top pt-3">
                    <div class="mb-3">
                        <label class="text-muted small mb-1">NIM</label>
                        <p class="mb-0 fw-semibold"><?php echo htmlspecialchars($user['nim']); ?></p>
                    </div>
                    
                    <div class="mb-0">
                        <label class="text-muted small mb-1">Kontak</label>
                        <p class="mb-0 fw-semibold"><?php echo htmlspecialchars($user['contact']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>