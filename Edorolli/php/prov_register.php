<?php

require_once 'functions.php';
start_session_if_not_started();
$conn = connectDatabase();

if (isset($_POST['register'])) {
    if (regProv($_POST)) {
        header("Location: ../Provider/prov_login.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Registrasi gagal!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }
}

mysqli_close($conn);
?>
