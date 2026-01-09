<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit();
}
include '../config/db.php';

$message = ''; $error = '';

function uploadFile($file, $folder) {
    $allowed = ['jpg','jpeg','png','webp','gif'];
    if ($file['error'] !== 0) return '';
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return '';
    $newName = time().'_'.$file['name'];
    $path = "../../uploads/$folder/";
    if (!file_exists($path)) mkdir($path, 0777, true);
    return move_uploaded_file($file['tmp_name'], $path.$newName) ? $newName : '';
}

// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $icon = uploadFile($_FILES['icon'], 'satellite');

    if ($_POST['action'] === 'create') {
        $sql = "INSERT INTO satellite_imagery (name, description" . ($icon ? ", icon" : "") . ") 
                VALUES ('$name', '$description'" . ($icon ? ", '$icon'" : "") . ")";
        $message = $conn->query($sql) ? 'Satellite imagery berhasil ditambahkan!' : 'Gagal menambahkan: ' . $conn->error;
    } else {
        $id = (int)$_POST['id'];
        $updateIcon = $icon ? ", icon='$icon'" : "";
        if ($icon) {
            $old = $conn->query("SELECT icon FROM satellite_imagery WHERE id=$id")->fetch_assoc();
            if ($old && $old['icon'] && file_exists("../../uploads/satellite/".$old['icon'])) {
                unlink("../../uploads/satellite/".$old['icon']);
            }
        }
        $sql = "UPDATE satellite_imagery SET name='$name', description='$description' $updateIcon WHERE id=$id";
        $message = $conn->query($sql) ? 'Data berhasil diperbarui!' : 'Gagal memperbarui: ' . $conn->error;
    }
}


// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $data = $conn->query("SELECT icon FROM satellite_imagery WHERE id=$id")->fetch_assoc();
    if ($data && $data['icon'] && file_exists("../../uploads/satellite/".$data['icon'])) unlink("../../uploads/satellite/".$data['icon']);
    $conn->query("DELETE FROM satellite_imagery WHERE id=$id");
    $message = 'Data dihapus!';
}

$list = $conn->query("SELECT * FROM satellite_imagery ORDER BY id ASC");
$editData = isset($_GET['edit']) ? $conn->query("SELECT * FROM satellite_imagery WHERE id=".(int)$_GET['edit'])->fetch_assoc() : null;

// Set konten file
$contentFile = 'content/satellite_content.php';

// Load layout
include 'layout/appadmin.php';
?>
