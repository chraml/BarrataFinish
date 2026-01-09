<?php
// contact_update.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $address = $_POST['address'];
    $operating_hours = $_POST['operating_hours'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];
    $website = $_POST['website'];
    $instagram = $_POST['instagram'];
    $linkedin = $_POST['linkedin'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $maps_embed_url = $_POST['maps_embed_url'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $location_description = $_POST['location_description'];

    // Cek apakah data sudah ada
    $check = $conn->query("SELECT id FROM contact_info LIMIT 1");
    
    if ($check && $check->num_rows > 0) {
        // Update existing record
        $row = $check->fetch_assoc();
        $stmt = $conn->prepare("UPDATE contact_info SET address=?, operating_hours=?, phone=?, email=?, whatsapp=?, website=?, instagram=?, linkedin=?, facebook=?, twitter=?, maps_embed_url=?, latitude=?, longitude=?, location_description=? WHERE id=?");
        $stmt->bind_param("ssssssssssssssi", $address, $operating_hours, $phone, $email, $whatsapp, $website, $instagram, $linkedin, $facebook, $twitter, $maps_embed_url, $latitude, $longitude, $location_description, $row['id']);
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO contact_info (address, operating_hours, phone, email, whatsapp, website, instagram, linkedin, facebook, twitter, maps_embed_url, latitude, longitude, location_description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssssssss", $address, $operating_hours, $phone, $email, $whatsapp, $website, $instagram, $linkedin, $facebook, $twitter, $maps_embed_url, $latitude, $longitude, $location_description);
    }

    if ($stmt->execute()) {
        header("Location: contact.php?success=1");
    } else {
        header("Location: contact.php?error=1");
    }
    exit;
}

header("Location: contact.php");
exit;
?>