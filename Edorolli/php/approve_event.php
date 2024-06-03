<?php
require_once '../php/functions.php';
$conn = connectDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_event'])) {
  $id_event = (int)$_POST['id_event'];

  $sql = "UPDATE event SET status = 'confirmed' WHERE id_event = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_event);
  if ($stmt->execute()) {
    echo "Event approved successfully.";
  } else {
    echo "Error approving event: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();

  header("Location: " . $_SERVER['HTTP_REFERER']);
  exit();
}
?>
