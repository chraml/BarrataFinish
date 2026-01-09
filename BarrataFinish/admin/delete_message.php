<?php
$host = "localhost"; $user = "root"; $pass = ""; $db = "pt-barrata";
$conn = new mysqli($host, $user, $pass, $db);

$id = $_GET['id'];
$conn->query("DELETE FROM contact_requests WHERE id='$id'");
header("Location: inbox.php?success=Pesan telah dihapus!");
?>
