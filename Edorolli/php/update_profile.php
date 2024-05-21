<?php
session_start();
$koneksi = mysqli_connect('localhost', 'root', '', 'project_pweb');

// Check connection
if ($koneksi->connect_error) {
    die('Connection Failed: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id'];

    $name = mysqli_real_escape_string($koneksi, $_POST['name']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $phone = mysqli_real_escape_string($koneksi, $_POST['phone']);
    $address = mysqli_real_escape_string($koneksi, $_POST['address']);

    $query = "UPDATE user SET name='$name', gmail='$email', nomorhp='$phone', alamat='$address' WHERE id='$user_id'";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['name'] = $name;
        $_SESSION['gmail'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['address'] = $address;

    } else {
        $_SESSION['error_message'] = 'Gagal memperbarui profil: ' . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);

    header("Location: http://localhost/Project-Web/Edorolli/User.php");
    exit();
} else {
    $_SESSION['error_message'] = 'Permintaan tidak valid!';
    header("Location: http://localhost/Project-Web/Edorolli/User.php");
    exit();
}
?>
