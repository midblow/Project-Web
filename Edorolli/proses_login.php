<?php
session_start();
$koneksi = mysqli_connect('localhost', 'root', '', 'project_pweb');

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$gmail = $_POST['gmail'];
$password = $_POST['password'];


$stmt = $koneksi->prepare("SELECT password FROM user WHERE gmail = ?");
$stmt->bind_param("s", $gmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Tidak ada user yang ditemukan dengan email tersebut
    $_SESSION['error_message'] = "Akun Anda belum terdaftar!";
    header("Location: login_user.php");
    exit();
} else {
    $user = $result->fetch_assoc();
    if ($user['password'] === $password) {
        // Password cocok, redirect ke halaman home
        header("Location: home_login.html");
        exit();
    } else {
        // Password tidak cocok
        $_SESSION['error_message'] = "Email atau password salah!";
        header("Location: login_user.php");
        exit();
    }
}

$stmt->close();
$koneksi->close();
?>