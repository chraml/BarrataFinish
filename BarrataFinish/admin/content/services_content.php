<!-- Services Content -->
<div class="content-wrapper">
    <div class="content-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Daftar Layanan</h5>
            <button class="btn btn-modern btn-primary-modern" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i class="bi bi-plus"></i> Tambah Service
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-modern table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Service</th>
                        <th>Deskripsi</th>
                        <th style="width:120px">Status</th>
                        <th style="width:150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($services)): ?>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($service['name']) ?></strong></td>
                                <td><?= htmlspecialchars(substr($service['description'], 0, 80)) ?>...</td>
                                <td>
                                    <?php if ($service['is_active']): ?>
                                        <span class="status-badge status-active">Aktif</span>
                                    <?php else: ?>
                                        <span class="status-badge status-inactive">Tidak Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-modern btn-warning-modern" onclick="editService(<?= $service['id'] ?>)" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-modern btn-danger-modern" onclick="deleteService(<?= $service['id'] ?>)" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-gear" style="font-size: 3rem;"></i><br><br>
                                Belum ada service. Tambahkan service pertama Anda!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Service -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="services_action.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Service Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Service <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required placeholder="Contoh: Pengembangan Aplikasi Web">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" name="description" required placeholder="Jelaskan detail layanan ini..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-modern btn-primary-modern">
                        <i class="bi bi-check"></i> Simpan Service
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Service -->
<div class="modal fade" id="editServiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="editServiceContent">
            <!-- Konten akan diisi dengan AJAX -->
        </div>
    </div>
</div>

<script>
function editService(id) {
    fetch('services_action.php?action=fetch&id=' + id)
        .then(r => r.text())
        .then(html => {
            document.getElementById('editServiceContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('editServiceModal')).show();
        })
        .catch(err => {
            alert('Gagal memuat data service: ' + err);
        });
}

function deleteService(id) {
    if (confirm('Yakin ingin menghapus service ini? Data yang dihapus tidak dapat dikembalikan.')) {
        fetch('services_action.php', {
            method: 'POST',
            body: new URLSearchParams({ action: 'delete', id: id })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert('Service berhasil dihapus!');
                location.reload();
            } else {
                alert('Gagal menghapus service: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            alert('Error: ' + err);
        });
    }
}
</script>