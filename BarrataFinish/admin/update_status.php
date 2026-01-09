<?php
// update_status.php
session_start();
include '../config/db.php';

// Validasi ID
if (!isset($_GET['id'])) {
    header("Location: inbox.php?error=" . urlencode("ID pesan tidak ditemukan"));
    exit;
}

$id = (int) $_GET['id'];

// === 1. HAPUS PESAN ===
if (isset($_GET['action']) && $_GET['action'] === 'delete') {

    $stmt = $conn->prepare("DELETE FROM contact_requests WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: inbox.php?success=" . urlencode("Pesan berhasil dihapus"));
    } else {
        header("Location: inbox.php?error=" . urlencode("Gagal menghapus pesan: " . $conn->error));
    }

    exit;
}


// === 2. UPDATE STATUS ===
if (!isset($_GET['status'])) {
    header("Location: inbox.php?error=" . urlencode("Status tidak ditemukan"));
    exit;
}

$status = trim($_GET['status']);

// MAPPING status UI → ENUM database
$statusMapping = [
    'baru'          => 'Pending',
    'dikonfirmasi'  => 'In Progress',
    'selesai'       => 'Resolved'
];

if (!isset($statusMapping[$status])) {
    header("Location: inbox.php?error=" . urlencode("Status tidak valid: $status"));
    exit;
}

$dbStatus = $statusMapping[$status];

// Update status
$stmt = $conn->prepare("UPDATE contact_requests SET status = ? WHERE id = ?");
$stmt->bind_param("si", $dbStatus, $id);

if ($stmt->execute()) {
    $successMessage = match($status) {
        'baru' => 'Status berhasil direset ke Baru',
        'dikonfirmasi' => 'Pesan berhasil dikonfirmasi',
        'selesai' => 'Pesan berhasil ditandai selesai',
        default => 'Status berhasil diperbarui'
    };

    header("Location: inbox.php?success=" . urlencode($successMessage));
} else {
    header("Location: inbox.php?error=" . urlencode("Gagal update: " . $conn->error));
}

exit;

?>
