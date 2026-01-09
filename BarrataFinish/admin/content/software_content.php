<div class="content-wrapper">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4><i class="bi bi-laptop me-2"></i>Kelola Photogrammetry Software</h4>
      <p class="text-muted">Tambah, edit, atau hapus software photogrammetry</p>
    </div>
    <a href="../admin/about.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
  </div>

  <?php if ($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <?php if ($editData): ?><input type="hidden" name="id" value="<?= $editData['id'] ?>"><?php endif; ?>

    <div class="mb-3">
      <label>Nama Software</label>
      <input type="text" name="name" class="form-control" required value="<?= $editData['name'] ?? '' ?>">
    </div>

    <div class="mb-3">
      <label>Badge</label>
      <input type="text" name="badge" class="form-control" required value="<?= $editData['badge'] ?? '' ?>">
    </div>

    <div class="mb-3">
      <label>Deskripsi</label>
      <textarea name="description" class="form-control" rows="3" required><?= $editData['description'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
      <label>Logo</label>
      <input type="file" name="logo" class="form-control">
      <?php if (!empty($editData['logo'])): ?>
        <img src="admin/uploads/about/<?= $editData['logo'] ?>" width="100" class="mt-2 rounded">
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary"><?= $editData ? 'Update' : 'Tambah' ?></button>
  </form>

  <hr>
  <h5>Daftar Software</h5>
  <table class="table table-bordered table-striped">
    <tr><th>No</th><th>Logo</th><th>Nama</th><th>Badge</th><th>Deskripsi</th><th>Aksi</th></tr>
    <?php $no=1; while($row=$softwareList->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><img src="../../uploads/software/<?= $row['logo'] ?>" width="60"></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['badge'] ?></td>
        <td><?= $row['description'] ?></td>
        <td>
          <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>
