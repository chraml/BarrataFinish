<?php 
include 'config/db.php';

// Ambil data home content dari database
$homeResult = $conn->query("SELECT * FROM home_content LIMIT 1");
$homeData = $homeResult ? $homeResult->fetch_assoc() : [];

// Ambil data services
$servicesResult = $conn->query("SELECT * FROM services WHERE is_active=1 ORDER BY created_at DESC");

// Ambil data portfolio untuk preview
$portfolioResult = $conn->query("SELECT * FROM portfolios ORDER BY created_at DESC LIMIT 4");

include 'partials/header.php'; 
?>
<main class="main">

  <!-- Hero Section -->
<section id="hero" class="hero section">
  <div class="hero-background">
    <div class="hero-overlay"></div>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row justify-content-center text-center">
      <div class="col-lg-10">
        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
          <h1><?= htmlspecialchars($homeData['main_title'] ?? 'Solusi Teknologi Inovatif untuk Pertumbuhan Bisnis Anda') ?></h1>
          <p><?= htmlspecialchars($homeData['description'] ?? 'Kami adalah mitra strategis Anda dalam transformasi digital') ?></p>

          <div class="hero-btns" data-aos="fade-up" data-aos-delay="300">
            <a href="tentang-kami.php" class="btn btn-primary">
              Tentang Kami
            </a>
            <a href="kontak.php" class="btn btn-outline">
              <i class="bi bi-telephone-fill"></i>
              Hubungi Kami
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="hero-image-container" data-aos="zoom-in" data-aos-delay="400">
          <div class="hero-image">
            <?php if (!empty($homeData['hero_image'])): ?>
              <img src="uploads/home/<?= htmlspecialchars($homeData['hero_image']) ?>" alt="Gambar Utama" class="img-fluid">
            <?php else: ?>
              <img src="assets/img/about/1.png" alt="Business Innovation" class="img-fluid">
            <?php endif; ?>
            <div class="image-decoration"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats section tetap sama -->
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="hero-stats" data-aos="fade-up" data-aos-delay="500">
          <!-- ... stats items ... -->
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- About Section -->
  <?php
  $aboutResult = $conn->query("SELECT * FROM about_company LIMIT 1");
  $aboutData = $aboutResult ? $aboutResult->fetch_assoc() : [];
  ?>
  <section id="about" class="about section">
    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">Tentang Kami</span>
      <h2><?= htmlspecialchars($aboutData['company_name'] ?? 'Tentang PT Barrata Global Technology') ?></h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gx-0 gx-lg-5 gy-5 align-items-center">
        <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
          <div class="image-wrapper">
            <div class="image-box">
              <?php if (!empty($aboutData['about_image'])): ?>
                <img src="uploads/about/<?= htmlspecialchars($aboutData['about_image']) ?>" class="img-fluid" alt="About Image">
              <?php else: ?>
                <img src="assets/img/about/2.png" class="img-fluid" alt="About Image">
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
            <p class="highlight-text"><?= nl2br(htmlspecialchars($aboutData['description'] ?? 'Dengan pengalaman dan tim ahli yang berdedikasi...')) ?></p>
          
            <div class="features-list">
              <div class="feature-item" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box"><i class="bi bi-check2-circle"></i></div>
                <div class="text">
                  <h4>Visi</h4>
                  <p><?= htmlspecialchars($aboutData['vision'] ?? 'Menjadi penyedia solusi teknologi terdepan...') ?></p>
                </div>
              </div>

              <div class="feature-item" data-aos="zoom-in" data-aos-delay="400">
                <div class="icon-box"><i class="bi bi-lightbulb"></i></div>
                <div class="text">
                  <h4>Misi</h4>
                  <p><?= htmlspecialchars($aboutData['mission'] ?? 'Memberikan solusi teknologi inovatif...') ?></p>
                </div>
              </div>
            </div>

            <div class="cta-buttons">
              <a href="tentang-kami.php" class="btn-learn-more">Learn More</a>
              <a href="kontak.php" class="btn-get-started">Get Started</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

  <!-- Services Section -->
  <section id="services" class="services section">
    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">Layanan Kami</span>
      <h2>Layanan Profesional Kami</h2>
      <p>Kami menyediakan layanan komprehensif untuk memenuhi semua kebutuhan teknologi dan digitalisasi perusahaan Anda.</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="services-container">
        <div class="row g-4">
          <?php 
          $delay = 100;
          while($service = $servicesResult->fetch_assoc()): 
          ?>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
              <div class="service-item">
                <div class="service-content">
                  <h3 class="service-title"><?= htmlspecialchars($service['name']) ?></h3>
                  <p class="service-text"><?= htmlspecialchars($service['description']) ?></p>
                </div>
              </div>
            </div>
          <?php 
          $delay += 100;
          endwhile; 
          ?>
        </div>
      </div>
    </div>
  </section><!-- /Services Section -->

  <!-- Portfolio Section -->
  <section id="portfolio" class="portfolio section">
    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">Dokumentasi</span>
      <h2>Dokumentasi Proyek Kami</h2>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="isotope-layout" data-default-filter="*" data-layout="fitRows" data-sort="original-order">
        <div class="row gy-4 portfolio-grid isotope-container" data-aos="fade-up" data-aos-delay="200">
          <?php while($portfolio = $portfolioResult->fetch_assoc()): ?>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item">
              <div class="portfolio-card">
                <div class="image-container">
                  <?php if (!empty($portfolio['image'])): ?>
                    <img src="uploads/portfolio/<?= htmlspecialchars($portfolio['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($portfolio['title']) ?>">
                  <?php else: ?>
                    <img src="assets/img/portfolio/portfolio-3.webp" class="img-fluid" alt="<?= htmlspecialchars($portfolio['title']) ?>">
                  <?php endif; ?>
                  <div class="overlay">
                    <div class="overlay-content">
                      <a href="uploads/portfolio/<?= htmlspecialchars($portfolio['image']) ?>" class="glightbox zoom-link"><i class="bi bi-zoom-in"></i></a>
                      <a href="portfolio-details.php?id=<?= $portfolio['id'] ?>" class="details-link"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
                <div class="content">
                  <h3><?= htmlspecialchars($portfolio['title']) ?></h3>
                  <p><?= htmlspecialchars(substr($portfolio['description'], 0, 60)) ?>...</p>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </section><!-- /Portfolio Section -->

  <!-- Faq Section -->
  <section id="faq" class="faq section">

    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">FAQ</span>
      <h2>Pertanyaan yang Sering Diajukan</h2>
      <p>Punya pertanyaan? Temukan jawabannya di sini!</p>
    </div>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">

          <div class="faq-wrapper">

            <?php
            // Ambil 5 FAQ pertama untuk ditampilkan di home
            $home_faqs = $conn->query("SELECT * FROM faqs WHERE is_active = 1 ORDER BY sort_order ASC LIMIT 5");
            
            if ($home_faqs && $home_faqs->num_rows > 0):
              $first = true;
              while($faq = $home_faqs->fetch_assoc()): 
            ?>
              <div class="faq-item <?= $first ? 'faq-active' : '' ?>">
                <div class="faq-header">
                  <div class="faq-icon">
                    <i class="bi bi-question-circle"></i>
                  </div>
                  <h4><?= htmlspecialchars($faq['question']) ?></h4>
                  <div class="faq-toggle">
                    <i class="bi bi-plus"></i>
                    <i class="bi bi-dash"></i>
                  </div>
                </div>
                <div class="faq-content">
                  <div class="content-inner">
                    <p><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                  </div>
                </div>
              </div><!-- End FAQ Item -->
            <?php 
              $first = false;
              endwhile;
            else: 
            ?>
              <div class="text-center py-5">
                <i class="bi bi-question-circle text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">FAQ sedang dalam proses pembaruan.</p>
              </div>
            <?php endif; ?>

          </div>

          <!-- Tombol Lihat Semua FAQ -->
          <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
            <a href="faq.php" class="btn btn-primary btn-lg">
              <i class="bi bi-arrow-right-circle me-2"></i>Lihat Semua FAQ
            </a>
          </div>

        </div>
      </div>
    </div>

  </section><!-- /Faq Section -->
  <!-- Contact Section -->
  <?php
  $contactResult = $conn->query("SELECT * FROM contact_info LIMIT 1");
  $contactData = $contactResult ? $contactResult->fetch_assoc() : [];
  ?>
  <section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
      <span class="description-title">Kontak</span>
      <h2>Hubungi Kami</h2>
      <p>Punya pertanyaan atau butuh penawaran? Tim kami siap membantu Anda.</p>
    </div>

    <div class="container">
      <div class="contact-wrapper">
        <div class="contact-info-panel">
          <div class="contact-info-header">
            <h3>Informasi Kontak</h3>
            <p>Hubungi kami melalui detail di bawah ini selama jam kerja.</p>
          </div>

          <div class="contact-info-cards">
            <div class="info-card">
              <div class="icon-container"><i class="bi bi-pin-map-fill"></i></div>
              <div class="card-content">
                <h4>Lokasi Kami</h4>
                <p><?= nl2br(htmlspecialchars($contactData['address'] ?? 'Jl. Arcamanik Endah No.85A...')) ?></p>
              </div>
            </div>

            <div class="info-card">
              <div class="icon-container"><i class="bi bi-envelope-open"></i></div>
              <div class="card-content">
                <h4>Email</h4>
                <p><?= htmlspecialchars($contactData['email'] ?? 'info@barrataglobal.tech') ?></p>
              </div>
            </div>

            <div class="info-card">
              <div class="icon-container"><i class="bi bi-telephone-fill"></i></div>
              <div class="card-content">
                <h4>Telepon</h4>
                <p><?= htmlspecialchars($contactData['phone'] ?? '+62 22 1234 5678') ?></p>
              </div>
            </div>

            <div class="info-card">
              <div class="icon-container"><i class="bi bi-clock-history"></i></div>
              <div class="card-content">
                <h4>Jam Kerja</h4>
                <p><?= nl2br(htmlspecialchars($contactData['operating_hours'] ?? 'Senin-Jumat: 08:00 - 17:00 WIB')) ?></p>
              </div>
            </div>
          </div>

          <div class="social-links-panel">
            <h5>Follow Us</h5>
            <div class="social-icons">
              <?php if (!empty($contactData['facebook'])): ?>
                <a href="<?= htmlspecialchars($contactData['facebook']) ?>"><i class="bi bi-facebook"></i></a>
              <?php endif; ?>
              <?php if (!empty($contactData['twitter'])): ?>
                <a href="<?= htmlspecialchars($contactData['twitter']) ?>"><i class="bi bi-twitter-x"></i></a>
              <?php endif; ?>
              <?php if (!empty($contactData['instagram'])): ?>
                <a href="<?= htmlspecialchars($contactData['instagram']) ?>"><i class="bi bi-instagram"></i></a>
              <?php endif; ?>
              <?php if (!empty($contactData['linkedin'])): ?>
                <a href="<?= htmlspecialchars($contactData['linkedin']) ?>"><i class="bi bi-linkedin"></i></a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="contact-form-panel">
          <div class="map-container">
            <?php if (!empty($contactData['maps_embed_url'])): ?>
              <iframe src="<?= htmlspecialchars($contactData['maps_embed_url']) ?>" width="800" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <?php else: ?>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.766295376035!2d107.67217807403556!3d-6.918519267713315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dd75c0000001%3A0x3eabb88b5648a569!2sPT.%20Barrata%20Global%20Technology!5e0!3m2!1sid!2sid!4v1758522744582!5m2!1sid!2sid" width="800" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <?php endif; ?>
          </div>

          <div class="form-container">
            <h3>Kirim Pesan Kepada Kami</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipiscing elit mauris hendrerit faucibus imperdiet nec eget felis.</p>

            <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Berhasil!</strong> Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-2"></i>
                <strong>Error!</strong> <?= htmlspecialchars($_GET['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <form action="service_request_process.php" method="post" class="php-email-form">
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required>
                <label>Nama Lengkap</label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" placeholder="Alamat Email" required>
                <label>Alamat Email</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="whatsapp_number" placeholder="Nomor WhatsApp" required>
                <label>Nomor WhatsApp</label>
                <small class="text-muted">Contoh: 081234567890 atau +6281234567890</small>
              </div>

              <div class="form-floating mb-3">
              <select class="form-select" name="request_type" required>
                <option value="">Pilih Jenis Permintaan</option>
                <option value="Pelatihan Fotogrametri - Remote Sensing">Pelatihan Fotogrametri - Remote Sensing</option>
                <option value="Jasa Pembuatan Peta">Jasa Pembuatan Peta</option>
                <option value="Survey">Survey</option>
                <option value="Lainnya">Lainnya</option>
              </select>
              <label>Jenis Permintaan</label>
            </div>
              <div class="form-floating mb-3">
                <input type="text" class="form-control" name="subject" placeholder="Subjek" required>
                <label>Subjek</label>
              </div>

              <div class="form-floating mb-3">
                <textarea class="form-control" name="message" placeholder="Pesan Anda" style="height: 150px" required></textarea>
                <label>Pesan Anda</label>
              </div>

               <div class="d-grid">
                  <button type="submit" class="btn-submit" id="submitBtn">
                    <span id="btnText">Kirim Pesan</span>
                    <i class="bi bi-send-fill ms-2" id="btnIcon"></i>
                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" id="btnSpinner"></span>
                  </button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  <script>
// Script untuk disable tombol submit saat form sedang diproses
document.getElementById('contactForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnIcon = document.getElementById('btnIcon');
    const btnSpinner = document.getElementById('btnSpinner');
    
    // Disable button
    submitBtn.disabled = true;
    
    // Ubah tampilan
    btnText.textContent = 'Mengirim...';
    btnIcon.classList.add('d-none');
    btnSpinner.classList.remove('d-none');
});

// Auto-hide alert setelah 5 detik
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>  
  </section><!-- /Contact Section -->

</main>

<?php include 'partials/footer.php'; ?>