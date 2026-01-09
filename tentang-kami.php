<?php 
include 'config/db.php';

// Ambil data about dari database
$aboutResult = $conn->query("SELECT * FROM about_company LIMIT 1");
$aboutData = $aboutResult ? $aboutResult->fetch_assoc() : [];

include 'partials/header.php'; 
?>
<!-- About Section -->
<section id="about" class="about section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <span class="description-title">Tentang Kami</span>
    <h2><?= htmlspecialchars($aboutData['company_name'] ?? 'Tentang PT Barrata Global Technology') ?></h2>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gx-0 gx-lg-5 gy-5 align-items-center">
      <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
        <div class="image-wrapper">
          <div class="image-box">
            <?php if (!empty($aboutData['about_image'])): ?>
              <img src="uploads/about/<?= htmlspecialchars($aboutData['about_image']) ?>" class="img-fluid" alt="About Image" loading="lazy">
            <?php else: ?>
              <img src="assets/img/about/about-square-15.webp" class="img-fluid" alt="About Image" loading="lazy">
            <?php endif; ?>
          </div>
          <div class="experience-box" data-aos="zoom-in" data-aos-delay="300">
            <div class="years">15+</div>
            <div class="text">Years of<br>Experience</div>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
        <div class="content">
          <div class="section-header">
            <h2><?= htmlspecialchars($aboutData['tagline'] ?? 'Mitra Teknologi Terpercaya untuk Masa Depan Digital Anda') ?></h2>
          </div>
          <p class="highlight-text"><?= nl2br(htmlspecialchars($aboutData['description'] ?? 'Dengan pengalaman dan tim ahli yang berdedikasi, kami berkomitmen untuk memberikan solusi teknologi yang tidak hanya canggih, tetapi juga tepat sasaran dan memberikan nilai nyata bagi bisnis Anda.')) ?></p>
      
          <div class="features-list">
            <div class="feature-item" data-aos="zoom-in" data-aos-delay="300">
              <div class="icon-box">
                <i class="bi bi-check2-circle"></i>
              </div>
              <div class="text">
                <h4>Visi Perusahaan</h4>
                <p><?= nl2br(htmlspecialchars($aboutData['vision'] ?? 'Menjadi penyedia solusi teknologi terdepan di Indonesia yang membantu perusahaan mencapai transformasi digital yang berkelanjutan.')) ?></p>
              </div>
            </div>

            <div class="feature-item" data-aos="zoom-in" data-aos-delay="400">
              <div class="icon-box">
                <i class="bi bi-lightbulb"></i>
              </div>
              <div class="text">
                <h4>Misi Perusahaan</h4>
                <p><?= nl2br(htmlspecialchars($aboutData['mission'] ?? 'Memberikan solusi teknologi inovatif yang berkualitas tinggi, terpercaya, dan sesuai dengan kebutuhan bisnis klien.')) ?></p>
              </div>
            </div>

          <div class="cta-buttons">
            <a href="layanan.php" class="btn-learn-more">Our Services</a>
            <a href="kontak.php" class="btn-get-started">Get Started</a>
          </div>
        </div>
      </div>
    </div>

  </div>

</section><!-- /About Section -->

<!-- Our Client Section -->
<section id="clients" class="clients-section section">
  <div class="container">
    <div class="section-title text-center" data-aos="fade-up">
      <span class="description-title">Klien Kami</span>
      <h2>OUR CLIENTS</h2>
      <p class="section-subtitle">Dipercaya oleh berbagai instansi pemerintah dan perusahaan terkemuka</p>
    </div>

    <?php 
    $clientsResult = $conn->query("SELECT * FROM clients ORDER BY id ASC");
    if ($clientsResult && $clientsResult->num_rows > 0): 
    ?>
    <div class="clients-grid" data-aos="fade-up" data-aos-delay="100">
      <?php while ($client = $clientsResult->fetch_assoc()): ?>
      <div class="client-item" data-aos="zoom-in" data-aos-delay="100">
        <div class="client-logo-box">
          <img src="../uploads/clients/<?= htmlspecialchars($client['logo']) ?>" 
               alt="<?= htmlspecialchars($client['name']) ?>" 
               title="<?= htmlspecialchars($client['name']) ?>"
               loading="lazy">
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="text-center text-muted py-5">
      <i class="bi bi-inbox fs-1 d-block mb-2"></i>
      <p>Belum ada data client yang tersedia.</p>
    </div>
    <?php endif; ?>
  </div>
</section><!-- /Our Client Section -->


<?php include 'partials/footer.php'; ?>