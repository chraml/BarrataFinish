<?php
include 'config/db.php';

// Ambil ID service dari URL
$service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($service_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM services WHERE id = ? AND is_active = 1");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    
    if (!$service) {
        header("Location: layanan.php");
        exit;
    }
} else {
    header("Location: layanan.php");
    exit;
}

// Ambil semua services untuk sidebar
$allServicesResult = $conn->query("SELECT * FROM services WHERE is_active=1 ORDER BY created_at DESC");

// Ambil contact info untuk footer
$contactResult = $conn->query("SELECT * FROM contact_info LIMIT 1");
$contactData = $contactResult ? $contactResult->fetch_assoc() : [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= htmlspecialchars($service['name']) ?> - PT Barrata Global Technology</title>
  <meta name="description" content="<?= htmlspecialchars(substr($service['description'], 0, 160)) ?>">
  <meta name="keywords" content="<?= htmlspecialchars($service['name']) ?>, layanan IT, teknologi">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="service-details-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">Barrata</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="index.php#about">About</a></li>
          <li><a href="layanan.php" class="active">Services</a></li>
          <li><a href="dokumentasi.php">Portfolio</a></li>
          <li><a href="faq.php">FAQ</a></li>
          <li><a href="kontak.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <?php if (!empty($contactData['twitter'])): ?>
          <a href="<?= htmlspecialchars($contactData['twitter']) ?>" class="twitter"><i class="bi bi-twitter-x"></i></a>
        <?php endif; ?>
        <?php if (!empty($contactData['facebook'])): ?>
          <a href="<?= htmlspecialchars($contactData['facebook']) ?>" class="facebook"><i class="bi bi-facebook"></i></a>
        <?php endif; ?>
        <?php if (!empty($contactData['instagram'])): ?>
          <a href="https://instagram.com/<?= htmlspecialchars(str_replace('@', '', $contactData['instagram'])) ?>" class="instagram"><i class="bi bi-instagram"></i></a>
        <?php endif; ?>
        <?php if (!empty($contactData['linkedin'])): ?>
          <a href="https://linkedin.com/company/<?= htmlspecialchars($contactData['linkedin']) ?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
        <?php endif; ?>
      </div>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0"><?= htmlspecialchars($service['name']) ?></h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="layanan.php">Services</a></li>
            <li class="current"><?= htmlspecialchars($service['name']) ?></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Service Details Section -->
    <section id="service-details" class="service-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-5">

          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <div class="service-hero">
              <?php if (!empty($service['image'])): ?>
                <img src="uploads/services/<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['name']) ?>" class="img-fluid">
              <?php else: ?>
                <img src="assets/img/services/services-7.webp" alt="<?= htmlspecialchars($service['name']) ?>" class="img-fluid">
              <?php endif; ?>
              <div class="service-badge">
                <span><i class="<?= htmlspecialchars($service['icon']) ?> me-2"></i>Premium Service</span>
              </div>
            </div>

            <div class="service-content">
              <div class="service-header">
                <h2><?= htmlspecialchars($service['name']) ?></h2>
                <p class="service-intro"><?= htmlspecialchars($service['description']) ?></p>
              </div>

              <?php if (!empty($service['features'])): ?>
              <div class="service-features">
                <h4>Yang Akan Anda Dapatkan</h4>
                <div class="row gy-3">
                  <?php 
                  $features = explode("\n", $service['features']);
                  $featureIcons = ['bi-graph-up-arrow', 'bi-people', 'bi-megaphone', 'bi-gear', 'bi-shield-check', 'bi-lightning'];
                  $iconIndex = 0;
                  foreach($features as $feature): 
                    if(trim($feature)):
                      $icon = $featureIcons[$iconIndex % count($featureIcons)];
                      $iconIndex++;
                  ?>
                    <div class="col-md-6">
                      <div class="feature-item">
                        <div class="feature-icon">
                          <i class="bi <?= $icon ?>"></i>
                        </div>
                        <div class="feature-content">
                          <h5><?= htmlspecialchars(trim($feature)) ?></h5>
                          <p>Solusi terbaik untuk kebutuhan bisnis Anda</p>
                        </div>
                      </div>
                    </div>
                  <?php 
                    endif;
                  endforeach; 
                  ?>
                </div>
              </div>
              <?php endif; ?>

              <div class="service-process">
                <h4>Proses Kerja Kami</h4>
                <div class="process-steps">
                  <div class="process-step">
                    <div class="step-number">01</div>
                    <div class="step-content">
                      <h5>Analisis & Konsultasi</h5>
                      <p>Kami melakukan analisis mendalam terhadap kebutuhan bisnis Anda dan memberikan konsultasi profesional untuk menemukan solusi terbaik.</p>
                    </div>
                  </div>
                  <div class="process-step">
                    <div class="step-number">02</div>
                    <div class="step-content">
                      <h5>Perencanaan Strategi</h5>
                      <p>Menyusun roadmap dan strategi implementasi yang detail dengan timeline yang jelas dan terukur.</p>
                    </div>
                  </div>
                  <div class="process-step">
                    <div class="step-number">03</div>
                    <div class="step-content">
                      <h5>Implementasi</h5>
                      <p>Melakukan implementasi solusi dengan standar kualitas tinggi dan best practices industri.</p>
                    </div>
                  </div>
                  <div class="process-step">
                    <div class="step-number">04</div>
                    <div class="step-content">
                      <h5>Monitoring & Support</h5>
                      <p>Memberikan dukungan berkelanjutan dan monitoring untuk memastikan sistem berjalan optimal.</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="service-gallery" data-aos="fade-up" data-aos-delay="300">
                <h4>Showcase Proyek</h4>
                <div class="row gy-3">
                  <div class="col-md-4">
                    <img src="assets/img/services/services-2.webp" alt="" class="img-fluid rounded">
                  </div>
                  <div class="col-md-4">
                    <img src="assets/img/services/services-8.webp" alt="" class="img-fluid rounded">
                  </div>
                  <div class="col-md-4">
                    <img src="assets/img/services/services-11.webp" alt="" class="img-fluid rounded">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <div class="service-sidebar">

              <div class="service-menu">
                <h4>Layanan Kami</h4>
                <div class="menu-list">
                  <?php while($allService = $allServicesResult->fetch_assoc()): ?>
                    <a href="service-details.php?id=<?= $allService['id'] ?>" class="menu-item <?= $allService['id'] == $service_id ? 'active' : '' ?>">
                      <i class="bi bi-arrow-right"></i>
                      <span><?= htmlspecialchars($allService['name']) ?></span>
                    </a>
                  <?php endwhile; ?>
                </div>
              </div>

              <div class="service-info">
                <h4>Detail Layanan</h4>
                <div class="info-list">
                  <div class="info-item">
                    <span class="info-label">Durasi:</span>
                    <span class="info-value">Disesuaikan proyek</span>
                  </div>
                  <div class="info-item">
                    <span class="info-label">Tim:</span>
                    <span class="info-value">4-6 spesialis</span>
                  </div>
                  <div class="info-item">
                    <span class="info-label">Delivery:</span>
                    <span class="info-value">Progress report berkala</span>
                  </div>
                  <div class="info-item">
                    <span class="info-label">Support:</span>
                    <span class="info-value">24/7 monitoring</span>
                  </div>
                </div>
              </div>

              <div class="contact-card">
                <div class="contact-content">
                  <h4>Butuh Bantuan?</h4>
                  <p>Hubungi kami untuk konsultasi gratis dan penawaran terbaik untuk kebutuhan bisnis Anda.</p>
                  <div class="contact-info">
                    <div class="contact-item">
                      <i class="bi bi-telephone"></i>
                      <span><?= htmlspecialchars($contactData['phone'] ?? '+62 22 1234 5678') ?></span>
                    </div>
                    <div class="contact-item">
                      <i class="bi bi-envelope"></i>
                      <span><?= htmlspecialchars($contactData['email'] ?? 'info@barrataglobal.tech') ?></span>
                    </div>
                  </div>
                  <a href="kontak.php" class="btn btn-primary">Dapatkan Penawaran</a>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Service Details Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div class="address">
            <h4>Address</h4>
            <p><?= nl2br(htmlspecialchars($contactData['address'] ?? 'Jl. Arcamanik Endah No.85A, Bandung')) ?></p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Contact</h4>
            <p>
              <strong>Phone:</strong> <span><?= htmlspecialchars($contactData['phone'] ?? '+62 22 1234 5678') ?></span><br>
              <strong>Email:</strong> <span><?= htmlspecialchars($contactData['email'] ?? 'info@barrataglobal.tech') ?></span><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Opening Hours</h4>
            <p><?= nl2br(htmlspecialchars($contactData['operating_hours'] ?? 'Senin-Jumat: 08:00 - 17:00 WIB')) ?></p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4>Follow Us</h4>
          <div class="social-links d-flex">
            <?php if (!empty($contactData['twitter'])): ?>
              <a href="<?= htmlspecialchars($contactData['twitter']) ?>" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <?php endif; ?>
            <?php if (!empty($contactData['facebook'])): ?>
              <a href="<?= htmlspecialchars($contactData['facebook']) ?>" class="facebook"><i class="bi bi-facebook"></i></a>
            <?php endif; ?>
            <?php if (!empty($contactData['instagram'])): ?>
              <a href="https://instagram.com/<?= htmlspecialchars(str_replace('@', '', $contactData['instagram'])) ?>" class="instagram"><i class="bi bi-instagram"></i></a>
            <?php endif; ?>
            <?php if (!empty($contactData['linkedin'])): ?>
              <a href="https://linkedin.com/company/<?= htmlspecialchars($contactData['linkedin']) ?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Barrata Global Technology</strong> <span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>