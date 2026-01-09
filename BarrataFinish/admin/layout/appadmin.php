<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CRITICAL: Proteksi halaman - redirect ke login jika belum login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Variabel default jika tidak diset
$pageTitle = $pageTitle ?? 'Dashboard Admin';
$pageSubtitle = $pageSubtitle ?? 'Kelola konten website PT Barrata Global Technology';
$totalNotifications = $totalNotifications ?? 0;
$newRequestsCount = $newRequestsCount ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - PT Barrata Global Technology</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/admin.css" rel="stylesheet">
</head>

<body>
    <div id="app" class="d-flex">
        <?php include 'layout/sidebar.php'; ?>

        <div class="main-content flex-grow-1">
            <!-- Top Navbar -->
            <div class="top-navbar d-flex justify-content-between align-items-center px-4 py-3">
                <div>
                    <h5 class="mb-0"><?= $pageTitle ?></h5>
                    <small class="text-muted"><?= $pageSubtitle ?></small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <!-- Notification Bell -->
                    <div class="position-relative">
                        <i class="bi bi-bell" style="cursor:pointer; font-size:20px;" onclick="showNotifications()"></i>
                        <?php if ($totalNotifications > 0): ?>
                            <span class="notification-badge"><?= $totalNotifications ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link text-dark dropdown-toggle d-flex align-items-center gap-2"
                                type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_email'] ?? 'A', 0, 1)) ?></div>
                            <span><?= $_SESSION['admin_email'] ?? 'Admin' ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="../admin/logout.php" style="margin:0;">
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="p-4">
                <?php
                // Konten halaman dimuat di sini
                if (isset($contentFile) && file_exists($contentFile)) {
                    include $contentFile;
                } else {
                    echo "<div class='alert alert-warning'>Konten tidak ditemukan.</div>";
                }
                ?>
            </div>

            <!-- Footer -->
            <footer class="text-center py-3 mt-4 bg-light border-top">
                <small>&copy; <?= date('Y') ?> PT Barrata Global Technology. All rights reserved.</small>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showNotifications() {
            alert('Fitur notifikasi akan segera hadir!');
        }

        // Mobile menu toggle
        const menuToggle = document.createElement('button');
        menuToggle.className = 'menu-toggle';
        menuToggle.innerHTML = '<i class="bi bi-list"></i>';
        menuToggle.onclick = function() {
            document.querySelector('.sidebar').classList.toggle('active');
        };
        
        if (window.innerWidth <= 768) {
            document.body.appendChild(menuToggle);
        }
    </script>
</body>
</html>