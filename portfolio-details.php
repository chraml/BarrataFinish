<?php
include 'config/db.php';

// Ambil ID portfolio dari URL
$portfolio_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($portfolio_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM portfolios WHERE id = ?");
    $stmt->bind_param("i", $portfolio_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $portfolio = $result->fetch_assoc();
    
    if (!$portfolio) {
        header("Location: dokumentasi.php");
        exit;
    }
} else {
    header("Location: dokumentasi.php");
    exit;
}

// Ambil contact info untuk footer
$contactResult = $conn->query("SELECT * FROM contact_info LIMIT 1");
$contactData = $contactResult ? $contactResult->fetch_assoc() : [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= htmlspecialchars($portfolio['title']) ?> - PT Barrata Global Technology</title>
  <meta name="description" content="<?= htmlspecialchars(substr($portfolio['description'], 0, 160)) ?>">
  <meta name="keywords" content="<?= htmlspecialchars($portfolio['category']) ?>, portfolio, project">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="logo">

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

<body class="portfolio-details-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">Barrata</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="index.php#about">About</a></li>
          <li><a href="layanan.php">Services</a></li>
          <li><a href="dokumentasi.php" class="active">dokumentasi</a></li>
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
        <h1 class="mb-2 mb-lg-0"><?= htmlspecialchars($portfolio['title']) ?></h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="dokumentasi.php">Portfolio</a></li>
            <li class="current"><?= htmlspecialchars($portfolio['title']) ?></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">

      <div class="container" data-aos="fade-up">

        <div class="row gy-4 g-lg-5">
          <!-- Left Side - Image -->
          <div class="col-lg-6">
            <div class="position-sticky" style="top: 40px">
              <?php if (!empty($portfolio['image'])): ?>
                <img src="uploads/portfolio/<?= htmlspecialchars($portfolio['image']) ?>" 
                     class="img-fluid rounded shadow" 
                     alt="<?= htmlspecialchars($portfolio['title']) ?>">
              <?php else: ?>
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                  <div class="text-center">
                    <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                    <p class="text-muted mt-3">Tidak ada gambar</p>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Right Side - Details -->
          <div class="col-lg-6">
            <div class="portfolio-description">
              <h2><?= htmlspecialchars($portfolio['title']) ?></h2>
              <p class="mb-4"><?= nl2br(htmlspecialchars($portfolio['description'])) ?></p>

              <?php if (!empty($portfolio['client'])): ?>
                <div class="testimonial-item mb-4">
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    <span>Proyek ini dikembangkan untuk <?= htmlspecialchars($portfolio['client']) ?> dengan teknologi terkini dan solusi yang disesuaikan dengan kebutuhan bisnis mereka.</span>
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              <?php endif; ?>

              <?php if (!empty($portfolio['technologies'])): ?>
                <div class="mb-4">
                  <h4><i class="bi bi-gear-fill me-2"></i>Teknologi yang Digunakan</h4>
                  <div class="technologies mt-3">
                    <?php 
                    $techs = explode(',', $portfolio['technologies']);
                    foreach($techs as $tech): 
                      if(trim($tech)):
                    ?>
                      <span class="badge bg-primary me-2 mb-2" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                        <?= htmlspecialchars(trim($tech)) ?>
                      </span>
                    <?php 
                      endif;
                    endforeach; 
                    ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>

            <div class="portfolio-info mt-4">
              <h3>Informasi Proyek</h3>
              <ul>
                <?php if (!empty($portfolio['category'])): ?>
                  <li><strong>Kategori:</strong> <?= htmlspecialchars($portfolio['category']) ?></li>
                <?php endif; ?>
                
                <?php if (!empty($portfolio['client'])): ?>
                  <li><strong>Klien:</strong> <?= htmlspecialchars($portfolio['client']) ?></li>
                <?php endif; ?>
                
                <?php if (!empty($portfolio['completion_date'])): ?>
                  <li><strong>Tanggal Selesai:</strong> <?= date('d F Y', strtotime($portfolio['completion_date'])) ?></li>
                <?php endif; ?>
                
                <?php if (!empty($portfolio['project_url'])): ?>
                  <li><strong>Project URL:</strong> <a href="<?= htmlspecialchars($portfolio['project_url']) ?>" target="_blank"><?= htmlspecialchars($portfolio['project_url']) ?></a></li>
                  <li class="mt-3">
                    <a href="<?= htmlspecialchars($portfolio['project_url']) ?>" target="_blank" class="btn btn-primary btn-visit align-self-start">
                      <i class="bi bi-box-arrow-up-right me-2"></i>Kunjungi Website
                    </a>
                  </li>
                <?php endif; ?>
              </ul>
            </div>
            
            <div class="mt-4 d-flex gap-2">
              <a href="dokumentasi.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
              </a>
              <a href="kontak.php" class="btn btn-primary">
                <i class="bi bi-envelope me-2"></i>Hubungi Kami
              </a>
            </div>

          </div>
        </div>

      </div>

    </section><!-- /Portfolio Details Section -->

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