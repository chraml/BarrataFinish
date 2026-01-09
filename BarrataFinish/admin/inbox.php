<?php
// inbox.php
include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Inbox Permintaan Layanan';
$pageSubtitle = 'Kelola dan tanggapi permintaan layanan dari klien';

// Filter status (ENUM database)
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM contact_requests";
if ($statusFilter) {
    $sql .= " WHERE status = '" . $conn->real_escape_string($statusFilter) . "'";
}
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);

// Statistik berdasarkan status ENUM database
$total = $conn->query("SELECT COUNT(*) AS total FROM contact_requests")->fetch_assoc()['total'];
$baru = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='Pending'")->fetch_assoc()['total'];
$dikonfirmasi = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='In Progress'")->fetch_assoc()['total'];
$selesai = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='Resolved'")->fetch_assoc()['total'];

// Notifikasi
$totalNotifications = $baru;
$newRequestsCount = $baru;

// File konten HTML
$contentFile = 'content/inbox_content.php';

// Load layout utama
include 'layout/appadmin.php';
?>
