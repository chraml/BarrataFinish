<div class="sidebar">
    <div class="sidebar-header">
        <h4>Admin Panel</h4>
        <small>PT Barrata Global Technology</small>
    </div>
    <nav class="sidebar-menu">
        <a href="dashboard.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        <a href="inbox.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'inbox.php' ? 'active' : '' ?>">
            <i class="bi bi-inbox"></i>
            <span>Inbox Permintaan</span>
            <?php if (isset($newRequestsCount) && $newRequestsCount > 0): ?>
                <span class="notification-badge"><?= $newRequestsCount ?></span>
            <?php endif; ?>
        </a>
        <a href="home.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>">
            <i class="bi bi-house"></i>
            <span>Kelola Home</span>
        </a>
        <a href="about.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>">
            <i class="bi bi-info-circle"></i>
            <span>Kelola About</span>
        </a>
        <a href="services.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : '' ?>">
            <i class="bi bi-gear"></i>
            <span>Kelola Services</span>
        </a>
        <a href="portfolio.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'portfolio.php' ? 'active' : '' ?>">
            <i class="bi bi-folder"></i>
            <span>Kelola Dokumentasi</span>
        </a>
        <a href="faq.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'faq.php' ? 'active' : '' ?>">
            <i class="bi bi-question-circle"></i>
            <span>Kelola FAQ</span>
        </a>
        <a href="contact.php" class="sidebar-menu-item <?= basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : '' ?>">
            <i class="bi bi-telephone"></i>
            <span>Kelola Kontak</span>
        </a>
        <a href="../index.php" target="_blank" class="sidebar-menu-item">
             <i class="bi bi-globe"></i>
             <span>Lihat Website</span>
        </a>
        <hr>
        <form method="POST" action="../admin/logout.php" id="sidebarLogoutForm">
            <button type="submit" class="sidebar-menu-item">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</div>
