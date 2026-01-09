<!-- Home Content -->
<div class="content-wrapper">
  <div class="content-section">
    <h5><i class="bi bi-house me-2"></i>Konten Homepage</h5>
    <hr>

    <?php if ($message): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i><?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-x-circle me-2"></i><?= $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-10 mb-3">
          <label class="form-label">Judul Utama</label>
          <input type="text" class="form-control" name="main_title" 
                 value="<?= htmlspecialchars($data['main_title'] ?? '') ?>"
                 placeholder="Contoh: Solusi Teknologi Terpercaya">
        </div>
        <!-- <div class="col-md-6 mb-3">
          <label class="form-label">Sub Judul</label>
          <input type="text" class="form-control" name="sub_title" 
                 value="<?= htmlspecialchars($data['sub_title'] ?? '') ?>"
                 placeholder="Contoh: Untuk Bisnis Digital Anda">
        </div>
      </div> -->

      <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea class="form-control" rows="4" name="description"
                  placeholder="Jelaskan secara singkat tentang perusahaan..."><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Gambar Utama Homepage</label>
        <input type="file" class="form-control" name="hero_image" accept="image/*">
        <small class="text-muted">Format: JPG, PNG, max 2MB.</small>

        <?php if (!empty($data['hero_image'])): ?>
          <div class="mt-3">
            <img src="../uploads/home/<?= $data['hero_image'] ?>" alt="Gambar Utama" class="img-thumbnail" style="max-width: 300px;">
            <p class="text-muted small mt-2">
              <i class="bi bi-check-circle text-success"></i> Gambar saat ini
            </p>
          </div>
        <?php endif; ?>
      </div>

      <!-- HAPUS button text section -->

      <div class="d-flex gap-2 mt-4">
        <button type="submit" name="update_home" class="btn btn-modern btn-primary-modern">
          <i class="bi bi-check"></i> Simpan Perubahan
        </button>
        <a href="dashboard.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
      </div>
    </form>
  </div>
</div>
<!-- Divider -->
<div class="my-3"></div>

<!-- SECTION 2: FAQ Management -->
<div class="content-wrapper">
  <div class="content-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5><i class="bi bi-question-circle me-2"></i>Kelola FAQ</h5>
      <button class="btn btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#faqModal" onclick="resetFaqForm()">
        <i class="bi bi-plus-circle"></i> Tambah FAQ
      </button>
    </div>
    <hr>

    <!-- Tabel FAQ -->
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-light">
          <tr>
            <th width="5%">#</th>
            <th width="30%">Pertanyaan</th>
            <th width="40%">Jawaban</th>
            <th width="10%" class="text-center">Status</th>
            <th width="15%" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if ($faqs->num_rows > 0):
            $no = 1;
            while ($faq = $faqs->fetch_assoc()): 
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($faq['question']) ?></td>
              <td><?= htmlspecialchars(substr($faq['answer'], 0, 100)) ?>...</td>
              <td class="text-center">
                <?php if ($faq['is_active']): ?>
                  <span class="badge bg-success">Aktif</span>
                <?php else: ?>
                  <span class="badge bg-secondary">Nonaktif</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <button class="btn btn-sm btn-warning" onclick='editFaq(<?= json_encode($faq) ?>)' title="Edit">
                  <i class="bi bi-pencil"></i>
                </button>
                <a href="?delete_faq=<?= $faq['id'] ?>" class="btn btn-sm btn-danger" 
                   onclick="return confirm('Yakin ingin menghapus FAQ ini?')" title="Hapus">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php 
            endwhile;
          else: 
          ?>
            <tr>
              <td colspan="5" class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                Belum ada FAQ yang ditambahkan
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal FAQ -->
<div class="modal fade" id="faqModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="faqModalLabel">Tambah FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" id="faqForm">
        <div class="modal-body">
          <input type="hidden" name="save_faq" value="1">
          <input type="hidden" name="faq_id" id="faq_id">
          
          <div class="mb-3">
            <label class="form-label">Pertanyaan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="question" id="question" required
                   placeholder="Masukkan pertanyaan...">
          </div>

          <div class="mb-3">
            <label class="form-label">Jawaban <span class="text-danger">*</span></label>
            <textarea class="form-control" name="answer" id="answer" rows="6" required
                      placeholder="Masukkan jawaban..."></textarea>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
            <label class="form-check-label" for="is_active">
              Aktifkan FAQ (tampilkan di halaman publik)
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-modern btn-primary-modern">
            <i class="bi bi-save"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Script untuk Home Content form submission
document.getElementById('homeForm')?.addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        submitBtn.disabled = true;
    }
});

// Reset FAQ form
function resetFaqForm() {
    document.getElementById('faqForm').reset();
    document.getElementById('faq_id').value = '';
    document.getElementById('faqModalLabel').textContent = 'Tambah FAQ';
    document.getElementById('is_active').checked = true;
}

// Edit FAQ
function editFaq(faq) {
    document.getElementById('faq_id').value = faq.id;
    document.getElementById('question').value = faq.question;
    document.getElementById('answer').value = faq.answer;
    document.getElementById('is_active').checked = faq.is_active == 1;
    document.getElementById('faqModalLabel').textContent = 'Edit FAQ';
    
    const modal = new bootstrap.Modal(document.getElementById('faqModal'));
    modal.show();
}

// Auto-hide alerts
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    submitBtn.disabled = true;
});
</script>
