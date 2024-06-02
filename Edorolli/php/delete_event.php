
<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if (!isset($_SESSION['id']) || !isset($_GET['id_event'])) {
    header("Location: ../User/login_user.php");
    exit();
}

$id_event = $_GET['id_event'];

// Delete the event from the database
$stmt = $conn->prepare("DELETE FROM event WHERE id_event = ?");
$stmt->bind_param("i", $id_event);

if ($stmt->execute()) {
    echo "Event deleted successfully";
    header("Location: ../User/home_login.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
