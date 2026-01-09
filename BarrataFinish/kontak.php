<?php
include 'config/db.php';

// Ambil data contact dari database
$contactResult = $conn->query("SELECT * FROM contact_info LIMIT 1");
$contactData = $contactResult ? $contactResult->fetch_assoc() : [];

include 'partials/header.php';
?>

<!-- Contact Section -->
<section id="contact" class="contact section">

  <div class="container section-title" data-aos="fade-up">
    <span class="description-title">Kontak</span>
    <h2>Hubungi Kami</h2>
    <p>Punya pertanyaan atau butuh penawaran? Tim kami siap membantu Anda.</p>
  </div>

  <div class="container">
    <div class="contact-wrapper">

      <!-- PANEL INFORMASI KONTAK -->
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
              <p><?= nl2br(htmlspecialchars($contactData['address'] ?? 'Alamat belum diatur')) ?></p>
            </div>
          </div>

          <div class="info-card">
            <div class="icon-container"><i class="bi bi-envelope-open"></i></div>
            <div class="card-content">
              <h4>Email</h4>
              <p><?= htmlspecialchars($contactData['email'] ?? '-') ?></p>
            </div>
          </div>

          <div class="info-card">
            <div class="icon-container"><i class="bi bi-telephone-fill"></i></div>
            <div class="card-content">
              <h4>Telepon</h4>
              <p><?= htmlspecialchars($contactData['phone'] ?? '-') ?></p>
            </div>
          </div>

          <div class="info-card">
            <div class="icon-container"><i class="bi bi-clock-history"></i></div>
            <div class="card-content">
              <h4>Jam Kerja</h4>
              <p><?= nl2br(htmlspecialchars($contactData['operating_hours'] ?? '-')) ?></p>
            </div>
          </div>

        </div>

        <div class="social-links-panel">
          <h5>Follow Us</h5>
          <div class="social-icons">
            <a href="<?= htmlspecialchars($contactData['facebook'] ?? '#') ?>" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="<?= htmlspecialchars($contactData['twitter'] ?? '#') ?>" target="_blank"><i class="bi bi-twitter-x"></i></a>
            <a href="https://instagram.com/<?= htmlspecialchars(str_replace('@','',$contactData['instagram'] ?? '')) ?>" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://linkedin.com/company/<?= htmlspecialchars($contactData['linkedin'] ?? '') ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>

      <!-- FORM KONTAK -->
      <div class="contact-form-panel">

        <div class="map-container">
          <iframe 
            src="<?= htmlspecialchars($contactData['maps_embed_url'] ?? 'https://www.google.com/maps') ?>" 
            width="800" height="450" style="border:0;" allowfullscreen loading="lazy">
          </iframe>
        </div>

        <div class="form-container">
          <h3>Kirim Pesan Kepada Kami</h3>
          <p>Silakan isi formulir di bawah ini dan kami akan segera menghubungi Anda.</p>

          <?php if (!empty($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <i class="bi bi-check-circle me-2"></i>
              <strong>Berhasil!</strong> Pesan Anda berhasil dikirim!
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <i class="bi bi-x-circle me-2"></i>
              <strong>Error!</strong> <?= htmlspecialchars($_GET['error']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <!-- FORM FIX: ADA ID -->
          <form id="contactForm" action="service_request_prosess.php" method="post">

            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="name" required placeholder="Nama Lengkap">
              <label>Nama Lengkap</label>
            </div>

            <div class="form-floating mb-3">
              <input type="email" class="form-control" name="email" required placeholder="Alamat Email">
              <label>Alamat Email</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="whatsapp_number" required placeholder="Nomor WhatsApp">
              <label>Nomor WhatsApp</label>
              <small class="text-muted">Format: 081234567890 atau +6281234567890</small>
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
              <input type="text" class="form-control" name="subject" required placeholder="Subjek">
              <label>Subjek</label>
            </div>

            <div class="form-floating mb-3">
              <textarea class="form-control" name="message" required style="height:150px" placeholder="Pesan Anda"></textarea>
              <label>Pesan Anda</label>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn-submit" id="submitBtn">
                <span id="btnText">Kirim Pesan</span>
                <i class="bi bi-send-fill ms-2" id="btnIcon"></i>
                <span class="spinner-border spinner-border-sm ms-2 d-none" id="btnSpinner"></span>
              </button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>

<script>
// FIX: script tidak error lagi
document.getElementById("contactForm").addEventListener("submit", function () {
    const btn = document.getElementById("submitBtn");
    document.getElementById("btnText").textContent = "Mengirim...";
    document.getElementById("btnIcon").classList.add("d-none");
    document.getElementById("btnSpinner").classList.remove("d-none");
    btn.disabled = true;
});

// Auto tutup alert
setTimeout(() => {
    document.querySelectorAll(".alert").forEach(alert => {
        new bootstrap.Alert(alert).close();
    });
}, 5000);
</script>

</section>

<?php include 'partials/footer.php'; ?>
