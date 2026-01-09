<!-- About Content -->
<div class="content-wrapper">
  <!-- Section Management Cards -->
  <div class="row mb-4">
    <div class="col-12">
      <h5><i class="bi bi-grid-3x3-gap me-2"></i>Kelola Section Tentang Kami</h5>
      <p class="text-muted">Kelola konten tambahan di halaman Tentang Kami</p>
      <hr>
    </div>
  </div>

  <div class="row g-3 mb-5">
    <?php 
    // Fungsi untuk cek apakah tabel ada
    function tableExists($conn, $tableName) {
        $result = $conn->query("SHOW TABLES LIKE '$tableName'");
        return $result && $result->num_rows > 0;
    }
    
    // Hitung jumlah data di setiap section (dengan error handling)
    $softwareCount = 0;
    $satelliteCount = 0;
    $clientsCount = 0;
    
    try {
        if (tableExists($conn, 'software')) {
            $result = $conn->query("SELECT COUNT(*) as total FROM software");
            $softwareCount = $result ? $result->fetch_assoc()['total'] : 0;
        }
        
        if (tableExists($conn, 'satellite_imagery')) {
            $result = $conn->query("SELECT COUNT(*) as total FROM satellite_imagery");
            $satelliteCount = $result ? $result->fetch_assoc()['total'] : 0;
        }
        
        if (tableExists($conn, 'clients')) {
            $result = $conn->query("SELECT COUNT(*) as total FROM clients");
            $clientsCount = $result ? $result->fetch_assoc()['total'] : 0;
        }
    } catch (Exception $e) {
        // Silent fail - tidak menampilkan error
    }
    
    // Cek apakah ada tabel yang belum dibuat
    $hasAllTables = tableExists($conn, 'software') && 
                    tableExists($conn, 'satellite_imagery') && 
                    tableExists($conn, 'clients');
    
    if (!$hasAllTables): ?>
    <div class="col-12">
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Setup Diperlukan!</strong> Beberapa tabel database belum dibuat. 
        Silakan jalankan SQL schema untuk membuat tabel: 
        <code>software</code>, <code>satellite_imagery</code>, dan <code>clients</code>.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php endif; ?>
    
    <!-- Software Card -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 hover-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-primary bg-opacity-10 text-primary">
              <i class="bi bi-laptop fs-4"></i>
            </div>
            <?php if (tableExists($conn, 'software')): ?>
              <span class="badge bg-primary"><?= $softwareCount ?> Items</span>
            <?php else: ?>
              <span class="badge bg-secondary">Not Setup</span>
            <?php endif; ?>
          </div>
          <h5 class="card-title">Photogrametry Software</h5>
          <p class="card-text text-muted small">Kelola daftar software yang digunakan perusahaan</p>
          <?php if (tableExists($conn, 'software')): ?>
            <a href="software.php" class="btn btn-sm btn-outline-primary w-100">
              <i class="bi bi-gear me-1"></i>Kelola Software
            </a>
          <?php else: ?>
            <button class="btn btn-sm btn-outline-secondary w-100" disabled>
              <i class="bi bi-exclamation-circle me-1"></i>Setup Required
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Satellite Card -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 hover-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-success bg-opacity-10 text-success">
              <i class="bi bi-globe fs-4"></i>
            </div>
            <?php if (tableExists($conn, 'satellite_imagery')): ?>
              <span class="badge bg-success"><?= $satelliteCount ?> Items</span>
            <?php else: ?>
              <span class="badge bg-secondary">Not Setup</span>
            <?php endif; ?>
          </div>
          <h5 class="card-title">Data Satelit Imagery</h5>
          <p class="card-text text-muted small">Kelola layanan data satelit yang tersedia</p>
          <?php if (tableExists($conn, 'satellite_imagery')): ?>
            <a href="satellite.php" class="btn btn-sm btn-outline-success w-100">
              <i class="bi bi-gear me-1"></i>Kelola Satellite
            </a>
          <?php else: ?>
            <button class="btn btn-sm btn-outline-secondary w-100" disabled>
              <i class="bi bi-exclamation-circle me-1"></i>Setup Required
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Clients Card -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 hover-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="icon-box bg-warning bg-opacity-10 text-warning">
              <i class="bi bi-building fs-4"></i>
            </div>
            <?php if (tableExists($conn, 'clients')): ?>
              <span class="badge bg-warning text-dark"><?= $clientsCount ?> Clients</span>
            <?php else: ?>
              <span class="badge bg-secondary">Not Setup</span>
            <?php endif; ?>
          </div>
          <h5 class="card-title">Client & Partner</h5>
          <p class="card-text text-muted small">Kelola logo client dan partner perusahaan</p>
          <?php if (tableExists($conn, 'clients')): ?>
            <a href="clients.php" class="btn btn-sm btn-outline-warning w-100">
              <i class="bi bi-gear me-1"></i>Kelola Clients
            </a>
          <?php else: ?>
            <button class="btn btn-sm btn-outline-secondary w-100" disabled>
              <i class="bi bi-exclamation-circle me-1"></i>Setup Required
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Informasi Perusahaan Form -->
  <div class="content-section">
    <h5><i class="bi bi-info-circle me-2"></i>Informasi Perusahaan</h5>
    <hr>

    <?php if ($message): ?>
      <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-x-circle me-2"></i><?= $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="company_name" value="<?= htmlspecialchars($about['company_name'] ?? ''); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Tagline <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="tagline" value="<?= htmlspecialchars($about['tagline'] ?? ''); ?>" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Deskripsi Perusahaan <span class="text-danger">*</span></label>
        <textarea class="form-control" rows="5" name="description" required><?= htmlspecialchars($about['description'] ?? ''); ?></textarea>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Visi <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="4" name="vision" required><?= htmlspecialchars($about['vision'] ?? ''); ?></textarea>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Misi <span class="text-danger">*</span></label>
          <textarea class="form-control" rows="4" name="mission" required><?= htmlspecialchars($about['mission'] ?? ''); ?></textarea>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar About</label>
        <input type="file" class="form-control" name="about_image" accept="image/*">
        <?php if (!empty($about['about_image'])): ?>
          <div class="mt-3">
            <img src="../uploads/about/<?= $about['about_image']; ?>" alt="About Image" class="img-thumbnail" style="max-width: 300px;">
            <p class="text-muted small mt-2">File saat ini: <?= $about['about_image']; ?></p>
          </div>
        <?php endif; ?>
      </div>

      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-modern btn-primary-modern">
          <i class="bi bi-check"></i> Simpan Perubahan
        </button>
        <a href="dashboard.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
    </form>
  </div>
</div>

<style>
/* Hover Card Effect */
.hover-card {
  transition: all 0.3s ease;
}

.hover-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Icon Box */
.icon-box {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Card Custom Styling */
.hover-card .card-body {
  padding: 1.5rem;
}

.hover-card .card-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.hover-card .btn-outline-primary:hover {
  background-color: #0d6efd;
  border-color: #0d6efd;
  color: white;
}

.hover-card .btn-outline-success:hover {
  background-color: #198754;
  border-color: #198754;
  color: white;
}

.hover-card .btn-outline-warning:hover {
  background-color: #ffc107;
  border-color: #ffc107;
  color: #000;
}

/* Badge Styling */
.badge {
  font-weight: 500;
  padding: 0.4rem 0.7rem;
  font-size: 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
  .hover-card {
    margin-bottom: 1rem;
  }
  
  .icon-box {
    width: 45px;
    height: 45px;
  }
  
  .icon-box i {
    font-size: 1.3rem !important;
  }
}
</style>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    submitBtn.disabled = true;
});
</script>