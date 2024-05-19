<?php
session_start();

// Konfigurasi database
$servername = "localhost";
$username = "username"; // ganti dengan username database Anda
$password = "password"; // ganti dengan password database Anda
$dbname = "database_name"; // ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil email pengguna dari sesi atau form (disesuaikan dengan implementasi Anda)
    if (!isset($_SESSION['email'])) {
        echo "<script>showPopup(false, 'Akses tidak sah.');</script>";
        exit;
    }

    $email = $_SESSION['email'];
    
    // Ambil kata sandi baru dari form
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi kata sandi
    if ($newPassword !== $confirmPassword) {
        echo "<script>showPopup(false, 'Kata sandi dan konfirmasi kata sandi tidak cocok.');</script>";
        exit;
    }

    // Hash kata sandi baru
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Perbarui kata sandi di database
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $hashedPassword, $email);
        if ($stmt->execute()) {
            echo "<script>showPopup(true, 'Kata Sandi Berhasil Disimpan');</script>";
        } else {
            echo "<script>showPopup(false, 'Terjadi kesalahan, silakan coba lagi.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>showPopup(false, 'Terjadi kesalahan, silakan coba lagi.');</script>";
    }
    
    $conn->close();
} else {
    echo "<script>showPopup(false, 'Akses tidak sah.');</script>";
}
?>