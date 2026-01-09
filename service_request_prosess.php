<?php
// service_request_process.php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan input
    $name            = trim($_POST['name']);
    $email           = trim($_POST['email']);
    $whatsapp_number = trim($_POST['whatsapp_number']);
    $request_type    = trim($_POST['request_type']);
    $subject         = trim($_POST['subject']);
    $message         = trim($_POST['message']);

    // Status default (valid sesuai ENUM database)
    $status = 'Pending';

    // Validasi wajib isi
    if (empty($name) || empty($email) || empty($whatsapp_number) || empty($request_type) || empty($subject) || empty($message)) {
        header("Location: kontak.php?error=" . urlencode("Semua field wajib diisi!"));
        exit;
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: kontak.php?error=" . urlencode("Format email tidak valid!"));
        exit;
    }


    // ==========================
    // VALIDASI & NORMALISASI WHATSAPP
    // ==========================

    // Hilangkan spasi dan tanda minus
    $whatsapp_number = str_replace([' ', '-'], '', $whatsapp_number);

    // Jika input mulai dari 08 → ubah ke +62
    if (preg_match('/^08[0-9]{8,}$/', $whatsapp_number)) {
        $whatsapp_number = '+62' . substr($whatsapp_number, 1);
    }

    // Validasi format +62xxxxxxxx
    if (!preg_match('/^\+628[0-9]{8,13}$/', $whatsapp_number)) {
        header("Location: kontak.php?error=" . urlencode("Nomor WhatsApp tidak valid! Gunakan format 081234567890 atau +6281234567890"));
        exit;
    }

    // Panjang cek (10–15 digit setelah +62)
    $angka = preg_replace('/\D/', '', $whatsapp_number);  
    if (strlen($angka) < 10 || strlen($angka) > 15) {
        header("Location: kontak.php?error=" . urlencode("Panjang nomor WhatsApp tidak valid."));
        exit;
    }

    // ==========================
    // END VALIDASI WHATSAPP
    // ==========================


    // Escape input untuk keamanan
    $name            = $conn->real_escape_string($name);
    $email           = $conn->real_escape_string($email);
    $whatsapp_number = $conn->real_escape_string($whatsapp_number);
    $request_type    = $conn->real_escape_string($request_type);
    $subject         = $conn->real_escape_string($subject);
    $message         = $conn->real_escape_string($message);

    // Query insert
    $sql = "INSERT INTO contact_requests 
            (name, email, whatsapp_number, request_type, subject, message, status, created_at)
            VALUES ('$name', '$email', '$whatsapp_number', '$request_type', '$subject', '$message', '$status', NOW())";

    if ($conn->query($sql)) {
        header("Location: kontak.php?success=1");
        exit;
    } else {
        header("Location: kontak.php?error=" . urlencode("Gagal mengirim pesan: " . $conn->error));
        exit;
    }

} else {
    header("Location: kontak.php");
    exit;
}
?>
