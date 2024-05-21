<?php
session_start();
$koneksi = mysqli_connect('localhost', 'root', '', 'project_pweb');

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];
    
    // Mencari user berdasarkan email
    $stmt = $koneksi->prepare("SELECT id, name, password, gender, nomorhp, alamat, gmail FROM user WHERE gmail = ?");
    $stmt->bind_param("s", $gmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Tidak ada user yang ditemukan dengan email tersebut
        $_SESSION['error_message'] = "Akun Anda belum terdaftar!";
        header("Location: http://localhost/Project-Web/Edorolli/login_user.php");
        exit();
    } else {
        // Ambil data user
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) {
            // Password cocok, set sesi dengan data user
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['nomorhp'] = $user['nomorhp'];
            $_SESSION['alamat'] = $user['alamat'];
            $_SESSION['gmail'] = $user['gmail'];
            
            // Debugging: Cetak sesi untuk memastikan nilai yang benar
            // echo "Sesi diatur dengan data baru: ";
            // print_r($_SESSION);
            // exit();
            
            // Redirect ke halaman home_login.php
            header("Location: http://localhost/Project-Web/Edorolli/home_login.php");
            exit();
        } else {
            // Password tidak cocok
            $_SESSION['error_message'] = "Email atau password salah!";
            header("Location: http://localhost/Project-Web/Edorolli/login_user.php");
            exit();
        }
    }
    $stmt->close();
}

$koneksi->close();
?>
