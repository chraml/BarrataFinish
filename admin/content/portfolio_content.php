<!-- Portfolio Content -->
<div class="content-wrapper">
    <div class="content-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0"><i class="bi bi-folder me-2"></i>Daftar Portfolio</h5>
            <button class="btn btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#addPortfolioModal">
                <i class="bi bi-plus"></i> Tambah Portfolio
            </button>
        </div>

        <?php if (count($portfolios) > 0): ?>
            <div class="row g-4">
                <?php foreach ($portfolios as $p): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($p['image']): ?>
                                <img src="../uploads/portfolio/<?= htmlspecialchars($p['image']); ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($p['title']); ?>" 
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?= htmlspecialchars($p['title']); ?></h6>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?= htmlspecialchars(substr($p['description'], 0, 100)); ?>
                                    <?= strlen($p['description']) > 100 ? '...' : '' ?>
                                </p>
                                <!-- TAMPILKAN MULTIPLE CATEGORIES -->
                                <div class="d-flex flex-wrap gap-1 mt-3">
                                    <?php 
                                    $categories = !empty($p['category']) ? explode(',', $p['category']) : [];
                                    foreach ($categories as $cat): 
                                        $cat = trim($cat);
                                        if (!empty($cat)):
                                    ?>
                                        <span class="badge bg-primary"><?= htmlspecialchars($cat); ?></span>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                                <?php if (!empty($p['client'])): ?>
                                    <small class="text-muted mt-2">
                                        <i class="bi bi-building"></i> <?= htmlspecialchars($p['client']); ?>
                                    </small>
                                <?php endif; ?>
                                <?php if (!empty($p['completion_date'])): ?>
                                    <small class="text-muted mt-1">
                                        <i class="bi bi-calendar-check"></i> <?= date('d M Y', strtotime($p['completion_date'])); ?>
                                    </small>
                                <?php endif; ?>
                                <div class="d-flex gap-2 mt-3">
                                    <button class="btn btn-sm btn-warning flex-fill" onclick="editPortfolio(<?= $p['id']; ?>)">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger flex-fill" onclick="deletePortfolio(<?= $p['id']; ?>)">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-folder2-open text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">Belum ada portfolio. Tambahkan portfolio pertama Anda!</p>
                <button class="btn btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#addPortfolioModal">
                    <i class="bi bi-plus"></i> Tambah Portfolio Sekarang
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Portfolio -->
<div class="modal fade" id="addPortfolioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="portfolio_action.php" method="POST" enctype="multipart/form-data" id="addPortfolioForm">
                <input type="hidden" name="action" value="add">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Portfolio Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Proyek <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required placeholder="Contoh: Pemetaan Area Pertambangan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" name="description" required placeholder="Jelaskan detail proyek ini..."></textarea>
                    </div>
                    
                    <!-- MULTI-SELECT KATEGORI DENGAN CHECKBOX -->
                    <div class="mb-3">
                        <label class="form-label">Kategori (Pilih Satu atau Lebih) <span class="text-danger">*</span></label>
                        <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                            <?php if (!empty($activeServices)): ?>
                                <?php foreach ($activeServices as $serviceName): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-checkbox" type="checkbox" name="categories[]" 
                                               value="<?= htmlspecialchars($serviceName); ?>" 
                                               id="add_<?= md5($serviceName); ?>">
                                        <label class="form-check-label" for="add_<?= md5($serviceName); ?>">
                                            <?= htmlspecialchars($serviceName); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <!-- KATEGORI DEFAULT "LAINNYA" -->
                            <hr class="my-2">
                            <div class="form-check">
                                <input class="form-check-input category-checkbox" type="checkbox" name="categories[]" 
                                       value="Lainnya" id="add_lainnya">
                                <label class="form-check-label fw-bold" for="add_lainnya">
                                    Lainnya
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Centang satu atau lebih kategori. Pilih "Lainnya" jika tidak ada kategori yang sesuai.</small>
                        <div id="categoryError" class="text-danger mt-1" style="display: none;">Pilih minimal 1 kategori!</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Gambar Proyek <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="image" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, max 5MB</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client</label>
                            <input type="text" class="form-control" name="client" placeholder="Nama perusahaan/klien (opsional)">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" name="completion_date">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL Proyek</label>
                        <input type="url" class="form-control" name="project_url" placeholder="https://example.com (opsional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teknologi yang Digunakan</label>
                        <input type="text" class="form-control" name="technologies" placeholder="SimActive, DATEM, AW3D (opsional)">
                        <small class="text-muted">Pisahkan dengan koma</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-modern btn-primary-modern">
                        <i class="bi bi-check"></i> Simpan Portfolio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Portfolio -->
<div class="modal fade" id="editPortfolioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="editPortfolioContent">
            <!-- Konten akan diisi dengan AJAX -->
        </div>
    </div>
</div>

<script>
// Validasi checkbox kategori sebelum submit
document.getElementById('addPortfolioForm')?.addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('.category-checkbox:checked');
    const errorDiv = document.getElementById('categoryError');
    
    if (checkboxes.length === 0) {
        e.preventDefault();
        errorDiv.style.display = 'block';
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    errorDiv.style.display = 'none';
    return true;
});

function editPortfolio(id) {
    fetch('portfolio_action.php?action=fetch&id=' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editPortfolioContent').innerHTML = html;
            const modal = new bootstrap.Modal(document.getElementById('editPortfolioModal'));
            modal.show();
            

        })
        .catch(err => {
            alert('Gagal memuat data portfolio: ' + err);
        });
}

function deletePortfolio(id) {
    if (confirm("Yakin ingin menghapus portfolio ini? Data yang dihapus tidak dapat dikembalikan.")) {
        fetch('portfolio_action.php', {
            method: 'POST',
            body: new URLSearchParams({ action: 'delete', id: id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Portfolio berhasil dihapus!');
                location.reload();
            } else {
                alert("Gagal menghapus portfolio: " + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            alert('Error: ' + err);
        });
    }
}
</script>