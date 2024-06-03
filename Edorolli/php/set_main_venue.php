<?php
session_start();

if (!isset($_SESSION['email_admin'])) {
    header("Location: http://localhost/Project-Web/Edorolli/Admin/login_admin.php");
    exit();
}

require_once '../php/functions.php';
$conn = connectDatabase();

$venue_id = isset($_POST['venue_id']) ? (int)$_POST['venue_id'] : null;
$provider_id = isset($_POST['provider_id']) ? (int)$_POST['provider_id'] : null;

if ($venue_id === null || $provider_id === null) {
    echo "Venue ID or Provider ID not specified.";
    exit();
}

// Reset main_venue untuk semua venue dari provider ini
$sql_reset = "UPDATE venue SET main_venue = 0 WHERE id_provider = ?";
$stmt_reset = $conn->prepare($sql_reset);
$stmt_reset->bind_param("i", $provider_id);
$stmt_reset->execute();

// Set main_venue untuk venue yang dipilih
$sql_set = "UPDATE venue SET main_venue = 1 WHERE id_venue = ?";
$stmt_set = $conn->prepare($sql_set);
$stmt_set->bind_param("i", $venue_id);
$stmt_set->execute();

$conn->close();

header("Location: prov_venue.php?id_provider=" . $provider_id);
exit();
?>