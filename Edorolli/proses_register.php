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
    $name = strtolower(trim($data["name"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $gender = $data["gender"];
    $phone = filter_var($data["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address = mysqli_real_escape_string($koneksi, $data["address"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Email tidak valid!';
        header("Location: signup.php");
        exit();
    }

    // Check email
    $result = mysqli_query($koneksi, "SELECT gmail FROM user WHERE gmail = '$email'");
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['error_message'] = 'Email sudah tersedia, gunakan email yang lain!';
        header("Location: signup.php");
        exit();
    }

    // Hash the password
    // $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Add user
    $query = "INSERT INTO user (gmail, name, password, gender, nomorhp, alamat) VALUES('$email', '$name', '$password', '$gender', '$phone', '$address')";
    if (mysqli_query($koneksi, $query)) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['register'])) {
    if (registrasi($_POST)) {
        header("Location: login_user.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Registrasi gagal!';
        header("Location: signup.php");
        exit();
    }
}

mysqli_close($koneksi);
?>
