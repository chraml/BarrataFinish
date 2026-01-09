<div class="content-wrapper">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4><i class="bi bi-globe me-2"></i>Kelola Satellite Imagery</h4>
      <p class="text-muted">Tambah, edit, atau hapus data Satellite Imagery</p>
    </div>
    <a href="../admin/about.php" class="btn btn-secondary"><i class="bi bi-arrow-left">Kembali</i></a>
  </div>
  <?php if ($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
  <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $editData ? 'update' : 'create' ?>">
    <?php if ($editData): ?><input type="hidden" name="id" value="<?= $editData['id'] ?>"><?php endif; ?>

    <div class="mb-3"><label>Nama</label>
      <input type="text" name="name" class="form-control" required value="<?= $editData['name'] ?? '' ?>">
    </div>
    <div class="mb-3"><label>Deskripsi</label>
      <input type="text" name="description" class="form-control" required value="<?= $editData['description'] ?? '' ?>">
    </div>

    <div class="mb-3"><label>Gambar</label>
      <input type="file" name="icon" class="form-control">
      <?php if (!empty($editData['icon'])): ?>
        <img src="../../uploads/satellite/<?= $editData['icon'] ?>" width="100" class="mt-2 rounded">
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary"><?= $editData ? 'Update' : 'Tambah' ?></button>
  </form>

  <hr>
  <h5>Daftar Data</h5>
  <table class="table table-bordered table-striped">
    <tr><th>No</th><th>Gambar</th><th>Nama</th><th>Deskripsi</th><th>Aksi</th></tr>
    <?php $no=1; while($r=$list->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><img src="../../uploads/satellite/<?= $r['icon'] ?>" width="60"></td>
        <td><?= $r['name'] ?></td>
        <td><?= $r['description'] ?></td>
        <td>
          <a href="?edit=<?= $r['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="?delete=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>
