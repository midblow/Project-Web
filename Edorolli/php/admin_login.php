<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if (isset($_POST['login'])) {
    $email_admin = $_POST['email_admin'];
    $password = $_POST['password'];
    
    // Mencari admin berdasarkan email
    $stmt = $conn->prepare("SELECT id_admin, admin_name, password, email_admin FROM admin WHERE email_admin = ?");
    $stmt->bind_param("s", $email_admin);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Tidak ada admin yang ditemukan dengan email tersebut
        $_SESSION['error_message'] = "Akun admin belum terdaftar!";
        header("Location: ../Admin/login_admin.php"); // Adjusted to correct path
        exit();
    } else {
        // Ambil data admin
        $admin = $result->fetch_assoc();
        // if (password_verify($password, $admin['password'])) {
        if ($admin['password'] === $password) { // Plain text comparison
            // Password cocok, set sesi dengan data admin
            $_SESSION['id_admin'] = $admin['id_admin'];
            $_SESSION['admin_name'] = $admin['admin_name'];
            $_SESSION['email_admin'] = $admin['email_admin'];
            
            // Redirect ke halaman admin dashboard
            header("Location: ../Admin/user_manage.php?page=1");
            exit();
        } else {
            // Password tidak cocok
            $_SESSION['error_message'] = "Email atau password salah!";
            header("Location: ../Admin/login_admin.php"); // Adjusted to correct path
            exit();
        }
    }
    $stmt->close();
}

$conn->close();
?>