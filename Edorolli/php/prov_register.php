<?php
session_start();

// Include database connection
$koneksi = mysqli_connect('localhost', 'root', '', 'project_pweb');

// Check connection
if ($koneksi->connect_error) {
    die('Connection Failed: ' . mysqli_connect_error());
}

function registrasi($data) {
    global $koneksi;

    // Sanitize and validate input data
    $email = filter_var($data["gmail"], FILTER_SANITIZE_EMAIL);
    $username = strtolower(trim($data["username"]));
    $lembaga = mysqli_real_escape_string($koneksi, $data["lembaga"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $phone = filter_var($data["nomorhp"], FILTER_SANITIZE_NUMBER_INT);
    $address = mysqli_real_escape_string($koneksi, $data["alamat"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Email tidak valid!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }

    // Check email
    $result = mysqli_query($koneksi, "SELECT gmail FROM provider WHERE gmail = '$email'");
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['error_message'] = 'Email sudah tersedia, gunakan email yang lain!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }

    // Hash the password
    // $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Add user (without hashing)
    $query = "INSERT INTO provider (gmail, username, lembaga, password, nomorhp, alamat) VALUES('$email', '$username', '$lembaga', '$password', '$phone', '$address')";
    if (mysqli_query($koneksi, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['register'])) {
    if (registrasi($_POST)) {
        header("Location: ../Provider/prov_login.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Registrasi gagal!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }
}

mysqli_close($koneksi);
?>
