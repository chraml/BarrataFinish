<?php 
include 'config/db.php';
include 'partials/header.php';
?>

<main class="main">

  <!-- Services Intro Section -->
  <section id="services-intro" class="services-intro section">
    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">Layanan Kami</span>
      <h2>Layanan Profesional Kami</h2>
      <p>Kami menyediakan layanan komprehensif untuk memenuhi semua kebutuhan teknologi dan digitalisasi perusahaan Anda.</p>
    </div>
  </section><!-- /Services Intro Section -->

  <!-- Software Section -->
  <section id="software" class="software section">
    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">Photogrammetry Software</span>
      <h2>SOFTWARE PHOTOGRAMMETRY</h2>
      <p>Kami mendistribusikan software photogrammetry terkemuka untuk kebutuhan pemetaan profesional Anda.</p>
    </div>

    <div class="container">
      <div class="row gy-4">
        <?php
        // ✅ UPDATED: Query dari tabel services dengan type='software'
        $softwareResult = $conn->query("SELECT * FROM services WHERE type='software' AND is_active=1 ORDER BY created_at ASC");
        
        if ($softwareResult && $softwareResult->num_rows > 0):
          $delay = 100;
          while($software = $softwareResult->fetch_assoc()):
        ?>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
            <div class="software-card">
              <div class="software-header">
                <?php if (!empty($software['image'])): ?>
                  <img src="uploads/services/<?= htmlspecialchars($software['image']) ?>" 
                       alt="<?= htmlspecialchars($software['name']) ?>" 
                       class="software-logo">
                <?php endif; ?>
                <div class="software-info">
                  <h3><?= htmlspecialchars($software['name']) ?></h3>
                  <?php if (!empty($software['badge'])): ?>
                    <span class="badge"><?= htmlspecialchars($software['badge']) ?></span>
                  <?php endif; ?>
                </div>
              </div>
              <div class="software-body">
                <p><?= nl2br(htmlspecialchars($software['description'])) ?></p>
              </div>
            </div>
          </div>
        <?php
          $delay += 100;
          endwhile;
        else:
        ?>
          <div class="col-12">
            <div class="alert alert-info text-center">
              <i class="bi bi-info-circle me-2"></i>
              Informasi software sedang dalam proses pembaruan.
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section><!-- /Software Section -->

  <!-- Satellite Imagery Section -->
  <section id="satellite" class="satellite section">
    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">Data Satelit Imagery</span>
      <h2>DATA SATELIT IMAGERY</h2>
      <p>Kami menyediakan data citra satelit berkualitas tinggi untuk berbagai keperluan pemetaan dan analisis geospasial.</p>
    </div>

    <div class="container">
      <div class="row gy-4">
        <?php
        // ✅ UPDATED: Query dari tabel services dengan type='satellite'
        $satelliteResult = $conn->query("SELECT * FROM services WHERE type='satellite' AND is_active=1 ORDER BY created_at ASC");
        
        if ($satelliteResult && $satelliteResult->num_rows > 0):
          $delay = 100;
          while($satellite = $satelliteResult->fetch_assoc()):
        ?>
          <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="<?= $delay ?>">
            <div class="satellite-card">
              <?php if (!empty($satellite['image'])): ?>
                <div class="satellite-icon">
                  <img src="uploads/services/<?= htmlspecialchars($satellite['image']) ?>" 
                       alt="<?= htmlspecialchars($satellite['name']) ?>">
                </div>
              <?php endif; ?>
              <div class="satellite-content">
                <h3><?= htmlspecialchars($satellite['name']) ?></h3>
                <?php if (!empty($satellite['badge'])): ?>
                  <span class="badge mb-2 d-inline-block"><?= htmlspecialchars($satellite['badge']) ?></span>
                <?php endif; ?>
                <p><?= nl2br(htmlspecialchars($satellite['description'])) ?></p>
              </div>
            </div>
          </div>
        <?php
          $delay += 100;
          endwhile;
        else:
        ?>
          <div class="col-12">
            <div class="alert alert-info text-center">
              <i class="bi bi-info-circle me-2"></i>
              Informasi data satelit sedang dalam proses pembaruan.
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section><!-- /Satellite Imagery Section -->

</main>

<?php include 'partials/footer.php'; ?>