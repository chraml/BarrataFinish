<?php
// service_request_process.php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $whatsapp_number = $conn->real_escape_string(trim($_POST['whatsapp_number']));
    $request_type = $conn->real_escape_string($_POST['request_type']);
    $priority = $conn->real_escape_string($_POST['priority']);
    $subject = $conn->real_escape_string(trim($_POST['subject']));
    $message = $conn->real_escape_string(trim($_POST['message']));
    $status = 'baru'; // Default status

    // Validasi input
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: kontak.php?error=Semua field wajib diisi!");
        exit;
    }

    // Insert ke database
    $sql = "INSERT INTO contact_requests 
            (name, email, whatsapp_number, request_type, priority, subject, message, status, created_at)
            VALUES ('$name', '$email', '$whatsapp_number', '$request_type', '$priority', '$subject', '$message', '$status', NOW())";

    if ($conn->query($sql)) {
        // Redirect dengan pesan sukses
        header("Location: kontak.php?success=1");
        exit;
    } else {
        // Redirect dengan pesan error
        header("Location: kontak.php?error=" . urlencode("Gagal mengirim pesan: " . $conn->error));
        exit;
    }
} else {
    header("Location: kontak.php");
    exit;
}
?>