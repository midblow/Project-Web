<?php
session_start();

if (!isset($_SESSION['id'])) {
    // Jika sesi ID tidak diatur, redirect ke halaman login
    header("Location: ../User/login_user.php");
    exit();
}

require_once 'functions.php';
$conn = connectDatabase();

$userId = intval($_SESSION['id']); // Mengambil ID pengguna dari sesi

// Hapus pengguna dari database berdasarkan ID
$sql = "DELETE FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('i', $userId);
    if ($stmt->execute()) {
        // Jika berhasil, arahkan kembali ke halaman login setelah menghancurkan sesi
        $stmt->close();
        $conn->close();
        session_destroy();
        header("Location: ../User/login_user.php");
        exit();
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
