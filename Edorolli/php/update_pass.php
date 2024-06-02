<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['id'])) {
        header("Location: ../User/User_KSandi.php?status=error&message=Akses tidak sah.");
        exit();
    }

    $email = $_SESSION['gmail'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi kata sandi
    if ($newPassword !== $confirmPassword) {
        header("Location: ../User/User_KSandi.php?status=error&message=Kata sandi dan konfirmasi kata sandi tidak cocok.");
        exit();
    }

    // Perbarui kata sandi di database
    $sql = "UPDATE user SET password = ? WHERE gmail = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $newPassword, $email);
        if ($stmt->execute()) {
            header("Location: ../User/User_KSandi.php?status=success&message=Kata Sandi Berhasil Disimpan");
        } else {
            header("Location: ../User/User_KSandi.php?status=error&message=Terjadi kesalahan, silakan coba lagi.");
        }
        $stmt->close();
    } else {
        header("Location: ../User/User_KSandi.php?status=error&message=Terjadi kesalahan dalam persiapan statement.");
    }

    $conn->close();
} else {
    header("Location: ../User/User_KSandi.php?status=error&message=Akses tidak sah.");
}
