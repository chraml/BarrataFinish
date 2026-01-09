<?php
include 'config/db.php';

// Ambil FAQ yang aktif dari database
$faqs = $conn->query("SELECT * FROM faqs WHERE is_active = 1 ORDER BY sort_order ASC, created_at ASC");
?>

<?php include 'partials/header.php'; ?>

    <!-- Faq Section -->
    <section id="faq" class="faq section">

      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">FAQ</span>
        <h2>Pertanyaan yang Sering Diajukan</h2>
        <p>Temukan jawaban untuk pertanyaan umum seputar layanan kami</p>
      </div>

      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">

            <div class="faq-wrapper">

              <?php if ($faqs && $faqs->num_rows > 0): ?>
                <?php 
                $first = true;
                while($faq = $faqs->fetch_assoc()): 
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
                ?>
              <?php else: ?>
                <div class="text-center py-5">
                  <i class="bi bi-question-circle text-muted" style="font-size: 4rem;"></i>
                  <p class="text-muted mt-3">Belum ada FAQ yang tersedia saat ini.</p>
                </div>
              <?php endif; ?>

            </div>

            <!-- Contact CTA -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="200">
              <div class="card p-5 border-0 shadow-sm" style="background: linear-gradient(135deg, var(--accent-color), color-mix(in srgb, var(--accent-color), #1a4372 30%));">
                <div class="card-body">
                  <h3 class="text-white mb-3">Tidak Menemukan Jawaban yang Anda Cari?</h3>
                  <p class="text-white opacity-75 mb-4">Tim kami siap membantu menjawab pertanyaan Anda. Hubungi kami sekarang!</p>
                  <a href="kontak.php" class="btn btn-light btn-lg">
                    <i class="bi bi-envelope me-2"></i>Hubungi Kami
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </section><!-- /Faq Section -->

<?php include 'partials/footer.php'; ?>
