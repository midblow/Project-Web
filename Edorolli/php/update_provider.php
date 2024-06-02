<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_provider = $_SESSION['id_provider'];
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $lembaga = mysqli_real_escape_string($conn, $_POST['lembaga']);
    $gmail = mysqli_real_escape_string($conn, $_POST['gmail']);
    $nomorhp = mysqli_real_escape_string($conn, $_POST['nomorhp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = "UPDATE provider SET username='$username', lembaga='$lembaga', gmail='$gmail', nomorhp='$nomorhp', alamat='$alamat' WHERE id_provider='$id_provider'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['username'] = $username;
        $_SESSION['lembaga'] = $lembaga;
        $_SESSION['gmail'] = $gmail;
        $_SESSION['nomorhp'] = $nomorhp;
        $_SESSION['alamat'] = $alamat;

        header("Location: ../Provider/Provider.php");
    } else {
        $_SESSION['error_message'] = 'Gagal memperbarui profil: ' . mysqli_error($conn);
        header("Location: ../Provider/Provider.php");
    }

    mysqli_close($conn);
} else {
    $_SESSION['error_message'] = 'Permintaan tidak valid!';
    header("Location: ../Provider/Provider.php");
}
?>
