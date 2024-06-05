<?php
session_start();

if (!isset($_SESSION['id_provider'])) {
    // Jika sesi ID tidak diatur, redirect ke halaman login
    header("Location: ../provider/prov_login.php");
    exit();
}

require_once 'functions.php';
$conn = connectDatabase();

$providerId = intval($_SESSION['id_provider']); // Mengambil ID pengguna dari sesi

// Hapus pengguna dari database berdasarkan ID
$sql = "DELETE FROM provider WHERE id_provider = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('i', $providerId);
    if ($stmt->execute()) {
        // Jika berhasil, arahkan kembali ke halaman login setelah menghancurkan sesi
        $stmt->close();
        $conn->close();
        session_destroy();
        header("Location: ../provider/prov_login.php");
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
