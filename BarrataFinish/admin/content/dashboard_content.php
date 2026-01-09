<div class="content-wrapper">
    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-primary h-100">
                <div class="card-body">
                    <div class="text-primary fs-2 mb-3"><i class="bi bi-inbox"></i></div>
                    <h3 class="mb-2"><?= $totalRequests ?></h3>
                    <p class="text-muted mb-0">Total Permintaan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-danger h-100">
                <div class="card-body">
                    <div class="text-danger fs-2 mb-3"><i class="bi bi-clock-history"></i></div>
                    <h3 class="mb-2"><?= $newRequests ?></h3>
                    <p class="text-muted mb-0">Pesan Baru</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-success h-100">
                <div class="card-body">
                    <div class="text-success fs-2 mb-3"><i class="bi bi-check-circle"></i></div>
                    <h3 class="mb-2"><?= $confirmed ?></h3>
                    <p class="text-muted mb-0">Dikonfirmasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-warning h-100">
                <div class="card-body">
                    <div class="text-warning fs-2 mb-3"><i class="bi bi-check-all"></i></div>
                    <h3 class="mb-2"><?= $pending ?></h3>
                    <p class="text-muted mb-0">Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="content-section">
        <h5><i class="bi bi-lightning-fill me-2"></i>Aksi Cepat</h5>
        <hr>
        <div class="row g-3">
            <div class="col-6 col-md-4 col-lg-2">
                <a href="home.php" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-icon"><i class="bi bi-house-add"></i></div>
                        <h6>Update Home</h6>
                        <small class="text-muted">Kelola konten homepage</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="services.php" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-icon"><i class="bi bi-plus-circle"></i></div>
                        <h6>Tambah Service</h6>
                        <small class="text-muted">Tambah layanan baru</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="portfolio.php" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-icon"><i class="bi bi-upload"></i></div>
                        <h6>Upload Portfolio</h6>
                        <small class="text-muted">Tambah portfolio</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="contact.php" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-icon"><i class="bi bi-telephone-plus"></i></div>
                        <h6>Update Kontak</h6>
                        <small class="text-muted">Perbarui info kontak</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="inbox.php" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-icon"><i class="bi bi-envelope-open"></i></div>
                        <h6>Cek Inbox</h6>
                        <small class="text-muted">Lihat pesan masuk</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="about.php" class="text-decoration-none">
                    <div class="quick-action-card">
                        <div class="quick-action-icon"><i class="bi bi-info-circle"></i></div>
                        <h6>Update About</h6>
                        <small class="text-muted">Edit info perusahaan</small>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="row g-3 mt-4">
        <div class="col-md-6">
            <div class="content-section">
                <h6><i class="bi bi-info-circle me-2"></i>Informasi Sistem</h6>
                <hr>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>PHP Version: <?= phpversion() ?></li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Server: <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Database: Connected</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Admin Login: Active</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content-section">
                <h6><i class="bi bi-speedometer2 me-2"></i>Quick Stats</h6>
                <hr>
                <div class="row text-center g-3">
                    <div class="col-6">
                        <h4 class="text-primary mb-1"><?= $conn->query("SELECT COUNT(*) AS total FROM portfolios")->fetch_assoc()['total'] ?? 0 ?></h4>
                        <small class="text-muted">Total Portfolio</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-1"><?= $conn->query("SELECT COUNT(*) AS total FROM services WHERE is_active=1")->fetch_assoc()['total'] ?? 0 ?></h4>
                        <small class="text-muted">Active Services</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>