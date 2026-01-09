<?php 
include 'config/db.php';

// Ambil semua portfolio dari database
$portfolioResult = $conn->query("SELECT * FROM portfolios ORDER BY created_at DESC");

// Ambil kategori unik untuk filter
$categoriesResult = $conn->query("SELECT DISTINCT category FROM portfolios WHERE category IS NOT NULL AND category != '' ORDER BY category");
$categories = [];
$otherCategory = null;

while ($row = $categoriesResult->fetch_assoc()) {
    // Split kategori yang mengandung koma (misal: "ALOS-4,AW3D" jadi ["ALOS-4", "AW3D"])
    $categoryList = array_map('trim', explode(',', $row['category']));
    
    foreach ($categoryList as $cat) {
        if (empty($cat)) continue;
        
        // Pisahkan kategori "Lainnya" untuk ditampilkan terakhir
        if (strtolower($cat) === 'lainnya') {
            $otherCategory = $cat;
        } else {
            // Hindari duplikat
            if (!in_array($cat, $categories)) {
                $categories[] = $cat;
            }
        }
    }
}

// Sort alfabetis
sort($categories);

// Tambahkan "Lainnya" di akhir jika ada
if ($otherCategory !== null) {
    $categories[] = $otherCategory;
}

// Helper function untuk sanitize kategori menjadi class name
function sanitizeCategory($category) {
    // Konversi ke lowercase, replace spasi dan karakter spesial dengan dash
    $sanitized = strtolower($category);
    $sanitized = preg_replace('/[^a-z0-9]+/', '-', $sanitized);
    $sanitized = trim($sanitized, '-');
    return 'filter-' . $sanitized;
}

include 'partials/header.php'; 
?>
<!-- Portfolio Section -->
<section id="portfolio" class="portfolio section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <span class="description-title">Dokumentasi</span>
    <h2>Dokumentasi Proyek Kami</h2>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="isotope-layout" data-default-filter="*" data-layout="fitRows" data-sort="original-order">

      <div class="portfolio-filters-wrapper" data-aos="fade-up" data-aos-delay="100">
        <ul class="portfolio-filters isotope-filters">
          <li data-filter="*" class="filter-active">Semua Proyek</li>
          <?php 
          // Generate filter buttons dari kategori database
          foreach($categories as $category): 
            $filterClass = sanitizeCategory($category);
          ?>
            <li data-filter=".<?= $filterClass ?>"><?= htmlspecialchars($category) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="row gy-4 portfolio-grid isotope-container" data-aos="fade-up" data-aos-delay="200">

        <?php 
        if ($portfolioResult && $portfolioResult->num_rows > 0):
          while($portfolio = $portfolioResult->fetch_assoc()): 
            // Generate filter class dari kategori portfolio (support multiple categories)
            $filterClasses = [];
            if (!empty($portfolio['category'])) {
                $categoryList = array_map('trim', explode(',', $portfolio['category']));
                foreach ($categoryList as $cat) {
                    if (!empty($cat)) {
                        $filterClasses[] = sanitizeCategory($cat);
                    }
                }
            }
            $filterClass = !empty($filterClasses) ? implode(' ', $filterClasses) : 'filter-uncategorized';
        ?>
          <div class="col-lg-4 col-md-6 portfolio-item isotope-item <?= $filterClass ?>">
            <div class="portfolio-card">
              <div class="image-container">
                <?php if (!empty($portfolio['image'])): ?>
                  <img src="uploads/portfolio/<?= htmlspecialchars($portfolio['image']) ?>" class="img-fluid" alt="<?= htmlspecialchars($portfolio['title']) ?>" loading="lazy">
                <?php else: ?>
                  <img src="assets/img/portfolio/portfolio-3.webp" class="img-fluid" alt="<?= htmlspecialchars($portfolio['title']) ?>" loading="lazy">
                <?php endif; ?>
                <div class="overlay">
                  <div class="overlay-content">
                    <?php if (!empty($portfolio['image'])): ?>
                      <a href="uploads/portfolio/<?= htmlspecialchars($portfolio['image']) ?>" class="glightbox zoom-link" title="<?= htmlspecialchars($portfolio['title']) ?>">
                        <i class="bi bi-zoom-in"></i>
                      </a>
                    <?php endif; ?>
                    <a href="portfolio-details.php?id=<?= $portfolio['id'] ?>" class="details-link" title="Lihat Detail Proyek">
                      <i class="bi bi-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="content">
                <h3><?= htmlspecialchars($portfolio['title']) ?></h3>
                <p><?= htmlspecialchars(substr($portfolio['description'], 0, 100)) ?><?= strlen($portfolio['description']) > 100 ? '...' : '' ?></p>
                
                <div class="portfolio-meta mt-2">
                  <?php if (!empty($portfolio['category'])): ?>
                    <span class="badge bg-primary"><?= htmlspecialchars($portfolio['category']) ?></span>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div><!-- End Portfolio Item -->
        <?php 
          endwhile;
        else:
        ?>
          <div class="col-12">
            <div class="alert alert-info text-center py-5">
              <i class="bi bi-folder2-open" style="font-size: 3rem;"></i>
              <p class="mt-3">Belum ada portfolio yang tersedia saat ini.</p>
            </div>
          </div>
        <?php endif; ?>

      </div><!-- End Portfolio Grid -->

    </div>

  </div>

</section><!-- /Portfolio Section -->

<?php include 'partials/footer.php'; ?>