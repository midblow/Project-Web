<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

if (!isset($_SESSION['id'])) {
    header("Location: ../User/login_user.php");
    exit();
}

// Mengambil ID Event dari URL
$id_event = isset($_GET['id_event']) ? (int)$_GET['id_event'] : 0;

if ($id_event <= 0) {
    die("Invalid event ID.");
}

// Memeriksa apakah user yang mencoba menghapus event adalah pemilik event tersebut
$sql_check = "SELECT id_user FROM event WHERE id_event = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $id_event);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$event = $result_check->fetch_assoc();

if (!$event) {
    die("Event not found.");
}

if ($event['id_user'] != $_SESSION['id']) {
    die("You do not have permission to delete this event.");
}

// Menghapus event dari database
$sql_delete = "DELETE FROM event WHERE id_event = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id_event);

if ($stmt_delete->execute()) {
    header("Location: ../User/event.php"); // Redirect ke halaman daftar event setelah penghapusan
} else {
    die("Error deleting event: " . $stmt_delete->error);
}

$stmt_check->close();
$stmt_delete->close();
$conn->close();
?>
