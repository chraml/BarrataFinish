<?php
include '../config/db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // HANDLE MULTIPLE CATEGORIES - Gabung jadi string dengan koma
    $category = isset($_POST['categories']) && is_array($_POST['categories']) 
        ? implode(',', $_POST['categories']) 
        : '';
    
    $client = !empty($_POST['client']) ? $_POST['client'] : null;
    $completion_date = !empty($_POST['completion_date']) ? $_POST['completion_date'] : null;
    $project_url = !empty($_POST['project_url']) ? $_POST['project_url'] : null;
    $technologies = !empty($_POST['technologies']) ? $_POST['technologies'] : null;
    $image = '';

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/portfolio/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $fileName);
        $image = $fileName;
    }

    $stmt = $conn->prepare("INSERT INTO portfolios (title, description, category, image, client, completion_date, project_url, technologies) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss", $title, $description, $category, $image, $client, $completion_date, $project_url, $technologies);
    $stmt->execute();
    header("Location: portfolio.php?success=1");
    exit;
}

if ($action === 'fetch') {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM portfolios WHERE id=$id");
    $p = $res->fetch_assoc();
    
    // Parse categories untuk multi-select
    $selectedCategories = !empty($p['category']) ? explode(',', $p['category']) : [];
    
    // Ambil services aktif untuk dropdown edit
    $servicesResult = $conn->query("SELECT name FROM services WHERE is_active=1 ORDER BY name ASC");
    $activeServices = [];
    if ($servicesResult) {
        while ($service = $servicesResult->fetch_assoc()) {
            $activeServices[] = $service['name'];
        }
    }

    ob_start(); ?>
    <form action="portfolio_action.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= $p['id']; ?>">

        <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Portfolio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Judul Proyek <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($p['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control" rows="4" name="description" required><?= htmlspecialchars($p['description']); ?></textarea>
            </div>
        <!-- MULTI-SELECT KATEGORI UNTUK EDIT DENGAN CHECKBOX -->
            <div class="mb-3">
                <label class="form-label">Kategori (Pilih Satu atau Lebih) <span class="text-danger">*</span></label>
                <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                    <?php if (!empty($activeServices)): ?>
                        <?php foreach ($activeServices as $serviceName): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="categories[]" 
                                       value="<?= htmlspecialchars($serviceName); ?>" 
                                       id="edit_<?= md5($serviceName); ?>"
                                       <?= in_array($serviceName, $selectedCategories) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="edit_<?= md5($serviceName); ?>">
                                    <?= htmlspecialchars($serviceName); ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <!-- KATEGORI DEFAULT "LAINNYA" -->
                    <hr class="my-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" 
                               value="Lainnya" id="edit_lainnya"
                               <?= in_array('Lainnya', $selectedCategories) ? 'checked' : ''; ?>>
                        <label class="form-check-label fw-bold" for="edit_lainnya">
                            Lainnya
                        </label>
                    </div>
                </div>
                <small class="text-muted">
                    <strong>Kategori terpilih saat ini:</strong> 
                    <?php 
                    if (!empty($selectedCategories)) {
                        foreach ($selectedCategories as $cat) {
                            $cat = trim($cat);
                            if (!empty($cat)) {
                                echo '<span class="badge bg-success me-1">' . htmlspecialchars($cat) . '</span>';
                            }
                        }
                    } else {
                        echo '<em class="text-danger">Belum ada kategori</em>';
                    }
                    ?>
                </small>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Baru (opsional)</label>
                <input type="file" class="form-control" name="image" accept="image/*">
                <?php if ($p['image']): ?>
                    <div class="mt-2">
                        <img src="../uploads/portfolio/<?= $p['image']; ?>" width="200" class="img-thumbnail">
                        <p class="text-muted small mt-1">Gambar saat ini</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Client</label>
                    <input type="text" class="form-control" name="client" value="<?= htmlspecialchars($p['client'] ?? ''); ?>" placeholder="Nama perusahaan/klien (opsional)">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="completion_date" value="<?= htmlspecialchars($p['completion_date'] ?? ''); ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">URL Proyek</label>
                <input type="url" class="form-control" name="project_url" value="<?= htmlspecialchars($p['project_url'] ?? ''); ?>" placeholder="https://example.com (opsional)">
            </div>
            <div class="mb-3">
                <label class="form-label">Teknologi yang Digunakan</label>
                <input type="text" class="form-control" name="technologies" value="<?= htmlspecialchars($p['technologies'] ?? ''); ?>" placeholder="SimActive, DATEM, AW3D (opsional)">
                <small class="text-muted">Pisahkan dengan koma</small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-modern btn-primary-modern"><i class="bi bi-check"></i> Update Portfolio</button>
        </div>
    </form>
    <?php
    echo ob_get_clean();
    exit;
}

if ($action === 'update') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // HANDLE MULTIPLE CATEGORIES - Gabung jadi string dengan koma
    $category = isset($_POST['categories']) && is_array($_POST['categories']) 
        ? implode(',', $_POST['categories']) 
        : '';
    
    $client = !empty($_POST['client']) ? $_POST['client'] : null;
    $completion_date = !empty($_POST['completion_date']) ? $_POST['completion_date'] : null;
    $project_url = !empty($_POST['project_url']) ? $_POST['project_url'] : null;
    $technologies = !empty($_POST['technologies']) ? $_POST['technologies'] : null;

    $res = $conn->query("SELECT image FROM portfolios WHERE id=$id");
    $old = $res->fetch_assoc();
    $image = $old['image'];

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/portfolio/";
        $fileName = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $fileName);
        $image = $fileName;
        
        // Hapus gambar lama jika ada
        if (!empty($old['image']) && file_exists($targetDir . $old['image'])) {
            unlink($targetDir . $old['image']);
        }
    }

    $stmt = $conn->prepare("UPDATE portfolios SET title=?, description=?, category=?, image=?, client=?, completion_date=?, project_url=?, technologies=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $title, $description, $category, $image, $client, $completion_date, $project_url, $technologies, $id);
    $stmt->execute();
    header("Location: portfolio.php?updated=1");
    exit;
}

if ($action === 'delete') {
    $id = intval($_POST['id']);
    
    // Hapus gambar dari server
    $res = $conn->query("SELECT image FROM portfolios WHERE id=$id");
    if ($row = $res->fetch_assoc()) {
        $imagePath = "../uploads/portfolio/" . $row['image'];
        if (!empty($row['image']) && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    
    $conn->query("DELETE FROM portfolios WHERE id=$id");
    echo json_encode(['success' => true]);
    exit;
}
?>