<?php
include '../config/db.php';

$email = 'admin@barrata.com';
$password = password_hash('admin123', PASSWORD_DEFAULT); // HASH password

$stmt = $conn->prepare("INSERT INTO admin_users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo "✅ Admin berhasil dibuat!";
} else {
    echo "❌ Gagal: " . $conn->error;
}
