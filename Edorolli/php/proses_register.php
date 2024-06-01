<?php
require_once 'functions.php';
start_session_if_not_started();
$conn = connectDatabase();

if (isset($_POST['register'])) {
    if (registrasi($_POST)) {
        header("Location: ../User/login_user.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Registrasi gagal!';
        header("Location: ../User/signup.php");
        exit();
    }
}

mysqli_close($conn);
?>
