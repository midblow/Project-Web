<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id'];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query = "UPDATE user SET name='$name', gmail='$email', nomorhp='$phone', alamat='$address' WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['name'] = $name;
        $_SESSION['gmail'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['address'] = $address;

    } else {
        $_SESSION['error_message'] = 'Gagal memperbarui profil: ' . mysqli_error($conn);
    }

    mysqli_close($conn);

    header("Location: ../User/User.php");
    exit();
} else {
    $_SESSION['error_message'] = 'Permintaan tidak valid!';
    header("Location: ../User/User.php");
    exit();
}
?>
