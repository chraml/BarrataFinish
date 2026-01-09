<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit();
}

include '../config/db.php';

$message = '';
$error = '';

function uploadLogo($file, $folder) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if ($file['error'] !== 0) return '';
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return '';
    $newFilename = time() . '_' . basename($file['name']);
    $uploadPath = "../../uploads/$folder/";
    if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
    if (move_uploaded_file($file['tmp_name'], $uploadPath . $newFilename)) return $newFilename;
    return '';
}

// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $badge = $conn->real_escape_string($_POST['badge']);
    $description = $conn->real_escape_string($_POST['description']);
    $logo = uploadLogo($_FILES['logo'], 'software');

    if ($_POST['action'] === 'create') {
        $sql = "INSERT INTO software (name, badge, description" . ($logo ? ", logo" : "") . ") 
                VALUES ('$name', '$badge', '$description'" . ($logo ? ", '$logo'" : "") . ")";
        $message = $conn->query($sql) ? 'Software berhasil ditambahkan!' : 'Gagal menambahkan software: ' . $conn->error;
    } else {
        $id = (int)$_POST['id'];
        $logoQuery = $logo ? ", logo='$logo'" : "";
        if ($logo) {
            $old = $conn->query("SELECT logo FROM software WHERE id=$id")->fetch_assoc();
            if ($old && $old['logo'] && file_exists("../../uploads/software/" . $old['logo'])) unlink("../../uploads/software/" . $old['logo']);
        }
        $sql = "UPDATE software SET name='$name', badge='$badge', description='$description' $logoQuery WHERE id=$id";
        $message = $conn->query($sql) ? 'Software berhasil diperbarui!' : 'Gagal memperbarui software: ' . $conn->error;
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $data = $conn->query("SELECT logo FROM software WHERE id=$id")->fetch_assoc();
    if ($data && $data['logo'] && file_exists("../../uploads/software/".$data['logo'])) unlink("../../uploads/software/".$data['logo']);
    $message = $conn->query("DELETE FROM software WHERE id=$id") ? 'Software berhasil dihapus!' : 'Gagal menghapus software: ' . $conn->error;
}

// DATA
$softwareList = $conn->query("SELECT * FROM software ORDER BY id ASC");
$editData = isset($_GET['edit']) ? $conn->query("SELECT * FROM software WHERE id=".(int)$_GET['edit'])->fetch_assoc() : null;

// Set konten file
$contentFile = 'content/software_content.php';

// Load layout
include 'layout/appadmin.php';
?>
