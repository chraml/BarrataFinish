<!-- FAQ Content -->
<div class="content-wrapper">
  <div class="content-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Daftar FAQ</h5>
      <button class="btn btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#faqModal" onclick="resetFaqForm()">
        <i class="bi bi-plus-circle"></i> Tambah FAQ
      </button>
    </div>

    <?php if ($message): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i><?= $message ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-x-circle me-2"></i><?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Tabel FAQ -->
    <div class="table-responsive">
      <table class="table table-modern table-hover align-middle">
        <thead>
          <tr>
            <th width="5%">#</th>
            <th width="30%">Pertanyaan</th>
            <th width="40%">Jawaban</th>
            <th width="8%">Urutan</th>
            <th width="10%" class="text-center">Status</th>
            <th width="12%" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if ($faqs && $faqs->num_rows > 0):
            $no = 1;
            while ($faq = $faqs->fetch_assoc()): 
          ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><strong><?= htmlspecialchars($faq['question']) ?></strong></td>
              <td><?= htmlspecialchars(substr($faq['answer'], 0, 100)) ?>...</td>
              <td><span class="badge bg-secondary"><?= $faq['sort_order'] ?></span></td>
              <td class="text-center">
                <?php if ($faq['is_active']): ?>
                  <span class="status-badge status-active">Aktif</span>
                <?php else: ?>
                  <span class="status-badge status-inactive">Nonaktif</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <div class="btn-group btn-group-sm">
                  <button class="btn btn-warning" onclick='editFaq(<?= json_encode($faq) ?>)' title="Edit">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <a href="?delete=<?= $faq['id'] ?>" class="btn btn-danger" 
                     onclick="return confirm('Yakin ingin menghapus FAQ ini?')" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php 
            endwhile;
          else: 
          ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-5">
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

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Urutan Tampilan</label>
              <input type="number" class="form-control" name="sort_order" id="sort_order" value="0" min="0">
              <small class="text-muted">Angka lebih kecil akan tampil lebih dulu</small>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label d-block">Status</label>
              <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                <label class="form-check-label" for="is_active">
                  Aktifkan FAQ (tampilkan di halaman publik)
                </label>
              </div>
            </div>
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
// Reset FAQ form
function resetFaqForm() {
    document.getElementById('faqForm').reset();
    document.getElementById('faq_id').value = '';
    document.getElementById('faqModalLabel').textContent = 'Tambah FAQ';
    document.getElementById('is_active').checked = true;
    document.getElementById('sort_order').value = '0';
}

// Edit FAQ
function editFaq(faq) {
    document.getElementById('faq_id').value = faq.id;
    document.getElementById('question').value = faq.question;
    document.getElementById('answer').value = faq.answer;
    document.getElementById('is_active').checked = faq.is_active == 1;
    document.getElementById('sort_order').value = faq.sort_order || 0;
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
</script>