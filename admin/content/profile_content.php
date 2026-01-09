<?php
include __DIR__ . '/../../config/db.php';

$adminEmail = $_SESSION['admin_email'] ?? '';

$stmt = $conn->prepare("SELECT * FROM admin_users WHERE email = ?");
$stmt->bind_param("s", $adminEmail);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newEmail = trim($_POST['email']);
    $newPassword = trim($_POST['password']);

    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE admin_users SET email=?, password=? WHERE id=?");
        $update->bind_param("ssi", $newEmail, $hashedPassword, $admin['id']);
    } else {
        $update = $conn->prepare("UPDATE admin_users SET email=? WHERE id=?");
        $update->bind_param("si", $newEmail, $admin['id']);
    }

    if ($update->execute()) {
        $_SESSION['admin_email'] = $newEmail;
        echo "<div class='alert alert-success'><i class='bi bi-check-circle'></i> Profil berhasil diperbarui!</div>";
    } else {
        echo "<div class='alert alert-danger'><i class='bi bi-x-circle'></i> Gagal memperbarui profil.</div>";
    }

    $update->close();
}
?>

<div class="content-header mb-4">
    <h2 class="fw-bold"><i class="bi bi-person-circle me-2"></i>Profil Admin</h2>
    <p class="text-muted">Ubah informasi akun Anda di sini.</p>
</div>

<div class="card shadow-sm border-0 p-4" style="max-width:600px;">
    <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Akun</h5>

    <form method="POST" class="profile-form">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($admin['email']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password Baru <span class="text-muted">(kosongkan jika tidak ingin ubah)</span></label>
            <input type="password" name="password" class="form-control" placeholder="********">
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-save me-2"></i> Simpan Perubahan
        </button>
    </form>
</div>
