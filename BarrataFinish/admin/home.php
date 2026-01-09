<?php
// home.php
include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Kelola Konten Homepage';
$pageSubtitle = 'Update konten halaman utama website dan FAQ';

$message = '';
$error = '';

// Ambil data home content dari database
$result = $conn->query("SELECT * FROM home_content LIMIT 1");
$data = $result ? $result->fetch_assoc() : [];

// ===============================
// PROSES UPDATE HOME CONTENT
// ===============================
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_home'])) {

    // Semua field tidak wajib
    $main_title   = $_POST['main_title'] ?? '';
    $sub_title    = $_POST['sub_title'] ?? '';
    $description  = $_POST['description'] ?? '';

    // Hapus button text, button link, background image
    $hero_image = $data['hero_image'] ?? '';

    // Upload hero image jika ada
    if (!empty($_FILES['hero_image']['name'])) {
        $targetDir = "../uploads/home/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = time() . "_hero_" . basename($_FILES['hero_image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['hero_image']['tmp_name'], $targetFile)) {
            if (!empty($data['hero_image']) && file_exists($targetDir . $data['hero_image'])) {
                unlink($targetDir . $data['hero_image']);
            }
            $hero_image = $fileName;
        }
    }

    // UPDATE atau INSERT
    if ($data) {
        $stmt = $conn->prepare("
            UPDATE home_content 
            SET main_title=?, sub_title=?, description=?, hero_image=? 
            WHERE id=?
        ");
        $stmt->bind_param("ssssi", $main_title, $sub_title, $description, $hero_image, $data['id']);
    } else {
        $stmt = $conn->prepare("
            INSERT INTO home_content (main_title, sub_title, description, hero_image) 
            VALUES (?,?,?,?)
        ");
        $stmt->bind_param("ssss", $main_title, $sub_title, $description, $hero_image);
    }

    if ($stmt->execute()) {
        $message = "Data homepage berhasil diperbarui!";
        $result = $conn->query("SELECT * FROM home_content LIMIT 1");
        $data = $result->fetch_assoc();
    } else {
        $error = "Gagal menyimpan perubahan: " . $conn->error;
    }
}

//Proses crud faq
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_faq'])) {
    $id        = $_POST['faq_id'] ?? null;
    $question  = trim($_POST['question']);
    $answer    = trim($_POST['answer']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if ($id) {
        $stmt = $conn->prepare("UPDATE faqs SET question=?, answer=?, is_active=? WHERE id=?");
        $stmt->bind_param("ssii", $question, $answer, $is_active, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO faqs (question, answer, is_active) VALUES (?,?,?)");
        $stmt->bind_param("ssi", $question, $answer, $is_active);
    }

    if ($stmt->execute()) {
        $message = "FAQ berhasil disimpan!";
    } else {
        $error = "Gagal menyimpan FAQ: " . $conn->error;
    }
}

// DELETE FAQ
if (isset($_GET['delete_faq'])) {
    $deleteId = intval($_GET['delete_faq']);
    if ($conn->query("DELETE FROM faqs WHERE id=$deleteId")) {
        $message = "FAQ berhasil dihapus!";
    } else {
        $error = "Gagal menghapus FAQ!";
    }
    header("Location: home.php");
    exit;
}

// Ambil semua FAQ
$faqs = $conn->query("SELECT * FROM faqs ORDER BY created_at DESC");

// Notifikasi
$newRequestsCount = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='baru'")
                        ->fetch_assoc()['total'] ?? 0;

$totalNotifications = $newRequestsCount;

// Set konten file
$contentFile = 'content/home_content.php';

// Load layout
include 'layout/appadmin.php';
?>
