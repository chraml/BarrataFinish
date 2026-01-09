<?php
// dashboard.php
include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Dashboard Admin';
$pageSubtitle = 'Selamat datang di panel admin PT Barrata Global Technology';

// Ambil statistik dari database (SESUAIKAN DENGAN ENUM DATABASE)
$totalRequests = $conn->query("SELECT COUNT(*) AS total FROM contact_requests")->fetch_assoc()['total'] ?? 0;
$newRequests = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='Pending'")->fetch_assoc()['total'] ?? 0;
$confirmed = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='In Progress'")->fetch_assoc()['total'] ?? 0;
$pending = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='Resolved'")->fetch_assoc()['total'] ?? 0;

// Notifikasi
$totalNotifications = $newRequests;
$newRequestsCount = $newRequests;

// Set konten file
$contentFile = 'content/dashboard_content.php';

// Load layout
include 'layout/appadmin.php';
?>