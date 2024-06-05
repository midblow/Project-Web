<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: http://localhost/Project-Web/Edorolli/Admin/login_admin.php");
  exit();
}

require_once 'functions.php';
$conn = connectDatabase();


if (isset($_GET['id'])) {
  $userId = intval($_GET['id']);
  echo "User ID to delete: " . $userId; // Debugging line

  // Hapus pengguna dari database berdasarkan ID
  $sql = "DELETE FROM user WHERE id = ?";
  $stmt = $conn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i', $userId);
    if ($stmt->execute()) {
      // Jika berhasil, arahkan kembali ke halaman manage_user.php
      echo "User deleted successfully"; // Debugging line
      header("Location: http://localhost/project-web/Edorolli/manage_user.php");
      exit();
    } else {
      echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "Error preparing statement: " . $conn->error;
  }
}


$conn->close();
?>
