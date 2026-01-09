<?php
// services_action.php
include '../config/db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Tambah Service
if ($action === 'add') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $is_active = $_POST['is_active'];
    $type = $_POST['type'] ?? 'software'; // default ke software
    $badge = $_POST['badge'] ?? '';

    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/services/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $fileName)) {
            $image = $fileName;
        }
    }

    $stmt = $conn->prepare("INSERT INTO services (name, description, is_active, type, badge, image) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssisss", $name, $description, $is_active, $type, $badge, $image);
    $stmt->execute();
    header("Location: services.php?success=Service berhasil ditambahkan");
    exit;
}

// Fetch Service untuk Edit
if ($action === 'fetch') {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM services WHERE id=$id");
    $s = $res->fetch_assoc();

    ob_start(); ?>
    <form action="services_action.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= $s['id']; ?>">

        <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Service <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($s['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipe Service <span class="text-danger">*</span></label>
                <select class="form-select" name="type" required>
                    <option value="software" <?= $s['type']=='software'?'selected':''; ?>>Software</option>
                    <option value="satellite" <?= $s['type']=='satellite'?'selected':''; ?>>Satellite</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Badge</label>
                <input type="text" class="form-control" name="badge" value="<?= htmlspecialchars($s['badge'] ?? ''); ?>" placeholder="Contoh: PREMIUM, NEW, etc (opsional)">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="5" name="description" required><?= htmlspecialchars($s['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar/Logo</label>
                <input type="file" class="form-control" name="image" accept="image/*">
                <?php if (!empty($s['image'])): ?>
                    <div class="mt-2">
                        <img src="../uploads/services/<?= $s['image']; ?>" width="150" class="img-thumbnail">
                        <p class="text-muted small mt-1">Gambar saat ini</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="is_active">
                    <option value="1" <?= $s['is_active']==1?'selected':''; ?>>Aktif</option>
                    <option value="0" <?= $s['is_active']==0?'selected':''; ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-modern btn-primary-modern"><i class="bi bi-check"></i> Update</button>
        </div>
    </form>
    <?php
    echo ob_get_clean();
    exit;
}

// Update Service
if ($action === 'update') {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $description = $_POST['description'];
    $is_active = $_POST['is_active'];
    $type = $_POST['type'];
    $badge = $_POST['badge'] ?? '';

    // Get current image
    $res = $conn->query("SELECT image FROM services WHERE id=$id");
    $old = $res->fetch_assoc();
    $image = $old['image'] ?? '';

    // Handle new image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/services/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $fileName)) {
            // Delete old image
            if (!empty($old['image']) && file_exists($targetDir . $old['image'])) {
                unlink($targetDir . $old['image']);
            }
            $image = $fileName;
        }
    }

    $stmt = $conn->prepare("UPDATE services SET name=?, description=?, is_active=?, type=?, badge=?, image=? WHERE id=?");
    $stmt->bind_param("ssisssi", $name, $description, $is_active, $type, $badge, $image, $id);
    $stmt->execute();
    header("Location: services.php?success=Service berhasil diupdate");
    exit;
}

// Delete Service
if ($action === 'delete') {
    $id = intval($_POST['id']);
    
    // Delete image from server
    $res = $conn->query("SELECT image FROM services WHERE id=$id");
    if ($row = $res->fetch_assoc()) {
        $imagePath = "../uploads/services/" . $row['image'];
        if (!empty($row['image']) && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    
    $conn->query("DELETE FROM services WHERE id=$id");
    echo json_encode(['success' => true]);
    exit;
}
?>
