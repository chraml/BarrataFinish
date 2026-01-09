<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Solusi Teknologi Inovatif - PT Barrata Global Technology</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="assets/img/BGT.png" alt="PT Barrata Global Technology Logo">
      </a>

      <?php
      // Deteksi halaman aktif berdasarkan nama file
      $current_page = basename($_SERVER['PHP_SELF']);
      ?>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="<?= ($current_page == 'index.php') ? 'active' : '' ?>">Home</a></li>
          <li><a href="tentang-kami.php" class="<?= ($current_page == 'tentang-kami.php') ? 'active' : '' ?>">About</a></li>
          <li><a href="layanan.php" class="<?= ($current_page == 'layanan.php') ? 'active' : '' ?>">Services</a></li>
          <li><a href="dokumentasi.php" class="<?= ($current_page == 'dokumentasi.php') ? 'active' : '' ?>">Documentations</a></li>
          <li><a href="faq.php" class="<?= ($current_page == 'faq.php') ? 'active' : '' ?>">FAQ</a></li>
          <li><a href="kontak.php" class="<?= ($current_page == 'kontak.php') ? 'active' : '' ?>">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <a href="https://www.youtube.com/@barrataglobaltechnology8091" class="youtube"><i class="bi bi-youtube"></i></a>
        <a href="https://www.instagram.com/barrataglobal/" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="https://www.linkedin.com/company/barata-technologies/" class="linkedin"><i class="bi bi-linkedin"></i></a>
        <a href="admin/login.php" class="user"><i class="fa-solid fa-user"></i></a>
      </div>

    </div>
  </header>