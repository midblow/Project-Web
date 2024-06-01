<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['id_provider'])) {
        header("Location: ../Provider/provider_KSandi.php?status=error&message=Akses tidak sah.");
        exit();
    }

    $id_provider = $_SESSION['id_provider'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi kata sandi
    if ($newPassword !== $confirmPassword) {
        header("Location: ../Provider/provider_KSandi.php?status=error&message=Kata sandi dan konfirmasi kata sandi tidak cocok.");
        exit();
    }

    // Hash the new password (currently commented out)
    // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Perbarui kata sandi di database
    // Using the plain password for now
    $sql = "UPDATE provider SET password = ? WHERE id_provider = ?";
    if ($stmt = $conn->prepare($sql)) {
        // $stmt->bind_param('si', $hashedPassword, $id_provider);
        $stmt->bind_param('si', $newPassword, $id_provider);
        if ($stmt->execute()) {
            header("Location: ../Provider/Provider_KSandi.php?status=success&message=Kata Sandi Berhasil Disimpan");
        } else {
            header("Location: ../Provider/Provider_KSandi.php?status=error&message=Terjadi kesalahan, silakan coba lagi.");
        }
        $stmt->close();
    } else {
        header("Location: ../Provider/Provider_KSandi.php?status=error&message=Terjadi kesalahan dalam persiapan statement.");
    }

    $conn->close();
} else {
    header("Location: ../Provider/Provider_KSandi.php?status=error&message=Akses tidak sah.");
}
?>
