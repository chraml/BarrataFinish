<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Kelola FAQ';
$pageSubtitle = 'Kelola Pertanyaan yang Sering Diajukan (FAQ)';

$message = '';
$error = '';

// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_faq'])) {
    $id = $_POST['faq_id'] ?? null;
    $question = trim($_POST['question']);
    $answer = trim($_POST['answer']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $sort_order = (int)$_POST['sort_order'];

    if ($id) {
        // Update
        $stmt = $conn->prepare("UPDATE faqs SET question=?, answer=?, is_active=?, sort_order=? WHERE id=?");
        $stmt->bind_param("ssiii", $question, $answer, $is_active, $sort_order, $id);
        $message = $stmt->execute() ? "FAQ berhasil diperbarui!" : "Gagal memperbarui FAQ: " . $conn->error;
    } else {
        // Create
        $stmt = $conn->prepare("INSERT INTO faqs (question, answer, is_active, sort_order) VALUES (?,?,?,?)");
        $stmt->bind_param("ssii", $question, $answer, $is_active, $sort_order);
        $message = $stmt->execute() ? "FAQ berhasil ditambahkan!" : "Gagal menambahkan FAQ: " . $conn->error;
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($conn->query("DELETE FROM faqs WHERE id=$id")) {
        $message = "FAQ berhasil dihapus!";
    } else {
        $error = "Gagal menghapus FAQ: " . $conn->error;
    }
    header("Location: faq.php");
    exit;
}

// Ambil semua FAQ
$faqs = $conn->query("SELECT * FROM faqs ORDER BY sort_order ASC, created_at DESC");

// Notifikasi
$newRequestsCount = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='baru'")->fetch_assoc()['total'] ?? 0;
$totalNotifications = $newRequestsCount;

// Set konten file
$contentFile = 'content/faq_content.php';

// Load layout
include 'layout/appadmin.php';
?>