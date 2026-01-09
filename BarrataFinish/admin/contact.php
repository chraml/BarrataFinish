<?php
// contact.php
include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Kelola Informasi Kontak';
$pageSubtitle = 'Update informasi kontak dan media sosial perusahaan';

// Ambil data contact
$contactResult = $conn->query("SELECT * FROM contact_info LIMIT 1");
$contactInfo = $contactResult ? $contactResult->fetch_assoc() : [];

// Notifikasi
$newRequestsCount = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='baru'")->fetch_assoc()['total'] ?? 0;
$totalNotifications = $newRequestsCount;

// Set konten file
$contentFile = 'content/contact_content.php';

// Load layout
include 'layout/appadmin.php';
?>