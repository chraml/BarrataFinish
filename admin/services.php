<?php
// services.php
include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Kelola Services';
$pageSubtitle = 'Tambah, edit, dan hapus layanan perusahaan';

// Ambil semua services
$result = $conn->query("SELECT * FROM services ORDER BY created_at DESC");
$services = $result->fetch_all(MYSQLI_ASSOC);

// Notifikasi
$newRequestsCount = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='baru'")->fetch_assoc()['total'] ?? 0;
$totalNotifications = $newRequestsCount;

// Set konten file
$contentFile = 'content/services_content.php';

// Load layout
include 'layout/appadmin.php';
?>