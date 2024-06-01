<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if (isset($_POST['login'])) {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];
    
    // Mencari user berdasarkan email
    $stmt = $conn->prepare("SELECT id, name, password, gender, nomorhp, alamat, gmail FROM user WHERE gmail = ?");
    $stmt->bind_param("s", $gmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Tidak ada user yang ditemukan dengan email tersebut
        $_SESSION['error_message'] = "Akun Anda belum terdaftar!";
        header("Location: http://localhost/Project-Web/Edorolli/User/login_user.php");
        exit();
    } else {
        // Ambil data user
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) {
            // Password cocok, set sesi dengan data user
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['gmail'] = $user['gmail'];
            $_SESSION['phone'] = $user['nomorhp'];
            $_SESSION['alamat'] = $user['alamat'];
            // $hp = $_SESSION['nomorhp'];
            // var_dump($hp); die;
            
            // Debugging: Cetak sesi untuk memastikan nilai yang benar
            // echo "Sesi diatur dengan data baru: ";
            // print_r($_SESSION);
            // exit();
            
            // Redirect ke halaman home_login.php
            header("Location: ../User/home_login.php");
            exit();
        } else {
            // Password tidak cocok
            $_SESSION['error_message'] = "Email atau password salah!";
            header("Location: ../User/login_user.php");
            exit();
        }
    }
    $stmt->close();
}

$conn->close();
?>
