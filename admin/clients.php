<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit();
}
include '../config/db.php';

$message = '';  $error = '';

function uploadLogo($file, $folder) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return '';
    }
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExt = ['jpg','jpeg','png','gif','webp'];
    if (!in_array($ext, $allowedExt)) {
        return '';
    }
    
    if ($file['size'] > 2097152) {
        return '';
    }
    
    $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', basename($file['name']));
    $path = __DIR__ . "/../../uploads/$folder/";
    
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $path . $name)) {
        return $name;
    }
    
    return '';
}

// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = $conn->real_escape_string(trim($_POST['name']));
    
    // Proses upload logo
    $logo = '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logo = uploadLogo($_FILES['logo'], 'clients');
        if (!$logo) {
            $error = 'Gagal upload logo. Pastikan file format JPG/PNG/GIF/WEBP dan ukuran max 2MB.';
        }
    }

    if (!$error) {
        if ($_POST['action'] === 'create') {
            if ($logo) {
                $sql = "INSERT INTO clients (name, logo) VALUES ('$name', '$logo')";
                $message = $conn->query($sql) ? 'Client berhasil ditambahkan!' : 'Error: ' . $conn->error;
            } else {
                $error = 'Logo wajib diupload saat menambah client baru!';
            }
        } else {
            $id = (int)$_POST['id'];
            
            if ($logo) {
                $old = $conn->query("SELECT logo FROM clients WHERE id=$id")->fetch_assoc();
                if ($old && $old['logo']) {
                    $oldPath = __DIR__ . "/../../uploads/clients/" . $old['logo'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $sql = "UPDATE clients SET name='$name', logo='$logo' WHERE id=$id";
            } else {
                $sql = "UPDATE clients SET name='$name' WHERE id=$id";
            }
            
            $message = $conn->query($sql) ? 'Data berhasil diperbarui!' : 'Error: ' . $conn->error;
        }
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $data = $conn->query("SELECT logo FROM clients WHERE id=$id")->fetch_assoc();
    
    if ($data && $data['logo']) {
        $logoPath = __DIR__ . "../../uploads/clients/" . $data['logo'];
        if (file_exists($logoPath)) {
            unlink($logoPath);
        }
    }
    
    $conn->query("DELETE FROM clients WHERE id=$id");
    $message = 'Client berhasil dihapus!';
    header('Location: clients.php');
    exit();
}

$list = $conn->query("SELECT * FROM clients ORDER BY id ASC");
$editData = isset($_GET['edit']) ? $conn->query("SELECT * FROM clients WHERE id=".(int)$_GET['edit'])->fetch_assoc() : null;

$contentFile = 'content/clients_content.php';
include 'layout/appadmin.php';
?>