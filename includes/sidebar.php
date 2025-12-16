<div class="sidebar d-flex flex-column">
    <div class="logo">
        <i class="bi bi-book"></i> MySchedule
    </div>
    
    <div class="user-info">
        <div class="d-flex align-items-center">
            <i class="bi bi-person-circle me-2" style="font-size: 24px;"></i>
            <div>
                <div class="fw-bold"><?php echo htmlspecialchars($user['username']); ?></div>
                <small>NIM: <?php echo htmlspecialchars($user['nim']); ?></small>
            </div>
        </div>
    </div>
    
    <div class="flex-grow-1">
        <a href="dashboard.php?page=home" class="nav-item <?php echo ($active_page == 'home') ? 'active' : ''; ?>">
            <i class="bi bi-house-door"></i> <span>Home</span>
        </a>
        <a href="dashboard.php?page=jadwal" class="nav-item <?php echo ($active_page == 'jadwal') ? 'active' : ''; ?>">
            <i class="bi bi-journal-text"></i> <span>Jadwal</span>
        </a>
        <a href="dashboard.php?page=kalender" class="nav-item <?php echo ($active_page == 'kalender') ? 'active' : ''; ?>">
            <i class="bi bi-calendar3"></i> <span>Kalender</span>
        </a>
        <a href="dashboard.php?page=profil" class="nav-item <?php echo ($active_page == 'profil') ? 'active' : ''; ?>">
            <i class="bi bi-person"></i> <span>Profil</span>
        </a>
        <a href="dashboard.php?page=about" class="nav-item <?php echo ($active_page == 'about') ? 'active' : ''; ?>">
            <i class="bi bi-info-circle"></i> <span>About</span>
        </a>
    </div>
    
    <!-- Logout Button di Pojok Bawah -->
    <button class="logout-btn" type="button" onclick="confirmLogout()">
        <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
    </button>
</div>