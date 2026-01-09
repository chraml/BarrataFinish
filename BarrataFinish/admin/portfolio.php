<?php
// portfolio.php
include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Kelola Portfolio';
$pageSubtitle = 'Tambah, edit, dan hapus portfolio proyek perusahaan';

// Ambil semua portfolio
$result = $conn->query("SELECT * FROM portfolios ORDER BY created_at DESC");
$portfolios = $result->fetch_all(MYSQLI_ASSOC);

// Ambil services aktif untuk dropdown kategori
$servicesResult = $conn->query("SELECT name FROM services WHERE is_active=1 ORDER BY name ASC");
$activeServices = [];
if ($servicesResult) {
    while ($service = $servicesResult->fetch_assoc()) {
        $activeServices[] = $service['name'];
    }
}

// Notifikasi
$newRequestsCount = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='baru'")->fetch_assoc()['total'] ?? 0;
$totalNotifications = $newRequestsCount;

// Set konten file
$contentFile = 'content/portfolio_content.php';

// Load layout
include 'layout/appadmin.php';
?>