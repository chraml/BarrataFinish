<?php
// about.php
include '../config/db.php';

// Set variabel untuk layout
$pageTitle = 'Kelola About Company';
$pageSubtitle = 'Update informasi perusahaan, visi, dan misi';

$message = '';
$error = '';

// Ambil data about
$result = $conn->query("SELECT * FROM about_company LIMIT 1");
$about = $result->fetch_assoc();

// Proses update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $company_name = $_POST['company_name'];
    $tagline = $_POST['tagline'];
    $description = $_POST['description'];
    $vision = $_POST['vision'];
    $mission = $_POST['mission'];
    $about_image = $about['about_image'] ?? '';

    // Upload gambar jika ada
    if (!empty($_FILES['about_image']['name'])) {
        $targetDir = "../uploads/about/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_" . basename($_FILES['about_image']['name']);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['about_image']['tmp_name'], $targetFile)) {
            $about_image = $fileName;
        } else {
            $error = "Gagal mengupload gambar.";
        }
    }

    if (empty($error)) {
        if ($about) {
            $stmt = $conn->prepare("UPDATE about_company SET company_name=?, tagline=?, description=?, vision=?, mission=?, about_image=? WHERE id=?");
            $stmt->bind_param("ssssssi", $company_name, $tagline, $description, $vision, $mission, $about_image, $about['id']);
        } else {
            $stmt = $conn->prepare("INSERT INTO about_company (company_name, tagline, description, vision, mission, about_image) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssss", $company_name, $tagline, $description, $vision, $mission, $about_image);
        }
        
        if ($stmt->execute()) {
            $message = "Data berhasil diperbarui!";
            $result = $conn->query("SELECT * FROM about_company LIMIT 1");
            $about = $result->fetch_assoc();
        } else {
            $error = "Gagal menyimpan perubahan: " . $conn->error;
        }
    }
}

// Notifikasi
$newRequestsCount = $conn->query("SELECT COUNT(*) AS total FROM contact_requests WHERE status='baru'")->fetch_assoc()['total'] ?? 0;
$totalNotifications = $newRequestsCount;

// Set konten file
$contentFile = 'content/about_content.php';

// Load layout
include 'layout/appadmin.php';
?>