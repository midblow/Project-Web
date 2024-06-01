<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if (isset($_POST['login'])) {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];
    
    // Mencari user berdasarkan email
    $stmt = $conn->prepare("SELECT id_provider, username, lembaga, password, nomorhp, alamat, gmail FROM provider WHERE gmail = ?");
    $stmt->bind_param("s", $gmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Tidak ada user yang ditemukan dengan email tersebut
        $_SESSION['error_message'] = "Akun Anda belum terdaftar!";
        header("Location: ../Provider/prov_login.php");
        exit();
    } else {
        // Ambil data user
        $user = $result->fetch_assoc();
        // Uncomment the following line if you enable password hashing
        // if (password_verify($password, $user['password'])) {
        if ($password === $user['password']) {
            // Password cocok, set sesi dengan data user
            $_SESSION['id_provider'] = $user['id_provider'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['lembaga'] = $user['lembaga'];
            $_SESSION['gmail'] = $user['gmail'];
            $_SESSION['phone'] = $user['nomorhp'];
            $_SESSION['alamat'] = $user['alamat'];
            
            // echo "Login berhasil, mengarahkan ke home_prov.php"; // Debug message
            // die();
            header("Location: ../Provider/home_prov.php");
            exit();
        } else {
            // Password tidak cocok
            $_SESSION['error_message'] = "Email atau password salah!";
            header("Location: ../Provider/prov_login.php");
            exit();
        }
    }
    $stmt->close();
}

$conn->close();
?>
