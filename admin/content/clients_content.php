<div class="content-wrapper">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4><i class="bi bi-people me-2"></i>Kelola Client Perusahaan</h4>
      <p class="text-muted">Tambah, edit, atau hapus data Client Perusahaan</p>
    </div>
    <a href="about.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
  </div>

  <?php if ($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title"><?= $editData ? 'Edit Client' : 'Tambah Client Baru' ?></h5>
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
        <?php if ($editData): ?><input type="hidden" name="id" value="<?= $editData['id'] ?>"><?php endif; ?>

        <div class="mb-3">
          <label class="form-label">Nama Client <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($editData['name'] ?? '') ?>">
        </div>

        
        <div class="mb-3">
          <label class="form-label">Logo Client <?= $editData ? '' : '<span class="text-danger">*</span>' ?></label>
          <input type="file" name="logo" class="form-control" accept="image/*" <?= $editData ? '' : 'required' ?>>
          <small class="text-muted">Format: JPG, PNG, GIF, WEBP (Max 2MB)</small>
          
          <?php if (!empty($editData['logo'])): ?>
            <div class="mt-2">
              <p class="mb-1"><strong>Logo Saat Ini:</strong></p>
              <img src="../../uploads/clients/<?= htmlspecialchars($editData['logo']) ?>" width="150" class="rounded border">
            </div>
          <?php endif; ?>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i><?= $editData ? 'Update Data' : 'Tambah Client' ?>
          </button>
          <?php if ($editData): ?>
            <a href="clients.php" class="btn btn-secondary">
              <i class="bi bi-x-circle me-1"></i>Batal Edit
            </a>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Daftar Client</h5>
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th width="50">No</th>
              <th width="100">Logo</th>
              <th>Nama Client</th>
              <th width="150" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1; 
            if ($list->num_rows > 0):
              while($r = $list->fetch_assoc()): 
            ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td>
                  <?php if (!empty($r['logo'])): ?>
                    <img src="../../uploads/clients/<?= htmlspecialchars($r['logo']) ?>" width="60" class="rounded">
                  <?php else: ?>
                    <span class="text-muted">No logo</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td class="text-center">
                  <a href="?edit=<?= $r['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <a href="?delete=<?= $r['id'] ?>" class="btn btn-danger btn-sm" 
                     onclick="return confirm('Yakin ingin menghapus client <?= htmlspecialchars($r['name']) ?>?')" 
                     title="Hapus">
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
                  <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                  Belum ada data client
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>