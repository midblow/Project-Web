<?php
session_start();

// Membuat koneksi
$conn = mysqli_connect('localhost', 'root', '', 'project_pweb');

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Periksa apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil email pengguna dari sesi atau form (disesuaikan dengan implementasi Anda)
    if (!isset($_SESSION['id'])) {
        echo "<script>showPopup(false, 'Akses tidak sah.');</script>";
        exit;
    }

    $email = $_SESSION['gmail'];

    // Ambil kata sandi baru dari form
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validasi kata sandi
    if ($newPassword !== $confirmPassword) {
        echo "<script>showPopup(false, 'Kata sandi dan konfirmasi kata sandi tidak cocok.');</script>";
        exit;
    }


    // Perbarui kata sandi di database
    $sql = "UPDATE user SET password = ? WHERE gmail = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $newPassword, $email);
        if ($stmt->execute()) {
            echo "<script>showPopup(true, 'Kata Sandi Berhasil Disimpan');</script>";
        } else {
            echo "<script>showPopup(false, 'Terjadi kesalahan, silakan coba lagi.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>showPopup(false, 'Terjadi kesalahan dalam persiapan statement.');</script>";
    }

    $conn->close();
} else {
    echo "<script>showPopup(false, 'Akses tidak sah.');</script>";
}
