<?php

session_start();
$name = $_POST['name'];
$email = $_POST['gmail'];
$password = $_POST['password'];

$koneksi = mysqli_connect('localhost', 'root', '', 'project_pweb');

function registrasi($data) {
    global $koneksi;

    $email = $data["gmail"];
    $name = strtolower(stripslashes($data["name"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);

    // Cek email
    $result = mysqli_query($koneksi, "SELECT gmail FROM user WHERE gmail = '$email'");
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['error_message'] = 'Email sudah tersedia, Gunakan email yang lain!';
        header("Location: signup.php");
        exit();
    } 

    // Tambah User
    mysqli_query($koneksi, "INSERT INTO user (gmail, name, password) VALUES('$email', '$name', '$password')");

    return mysqli_affected_rows($koneksi);
}

if ($koneksi->connect_error) {
    die('Connection Failed: ' . mysqli_connect_error());
}

if (isset($_POST['register'])) {
    if (registrasi($_POST) > 0) {
        header("Location: login_user.php");
        exit();
    } else {
        echo mysqli_connect_error();
    }
}

$koneksi->close();
?>