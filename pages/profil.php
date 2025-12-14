<div id="profilPage" class="page-section <?php echo ($active_page == 'profil') ? 'active' : ''; ?>">
    <div class="card shadow-lg" style="max-width:500px;margin:auto;">
        <div class="card-body text-center p-5">
            <div class="rounded-circle bg-success mb-3"
                style="width:120px;height:120px;display:flex;align-items:center;justify-content:center;margin:auto;">
                <i class="bi bi-person-fill text-white" style="font-size:60px;"></i>
            </div>
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>

            <div class="text-start mt-4">
                <p><strong>NIM:</strong> <?php echo htmlspecialchars($user['nim']); ?></p>
                <p><strong>Kontak:</strong> <?php echo htmlspecialchars($user['contact']); ?></p>
                <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
            </div>
        </div>
    </div>
</div>