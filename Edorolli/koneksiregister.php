<?php
$name = $_POST['name'];
$email = $_POST['gmail'];
$password = $_POST['password'];

$koneksi = mysqli_connect('localhost', 'root', '', 'project_pweb');

if ($koneksi->connect_error) {
    die('Connection Failed : ' . $koneksi->connect_error);
} else {
    // Check if the email already exists
    // $checkEmail = $koneksi->prepare('SELECT * FROM user WHERE gmail = ?');
    // $checkEmail->bind_param('s', $email);
    // $checkEmail->execute();
    // $result = $checkEmail->get_result();
    
    // if ($result->num_rows > 0) {
    //     // Set error message
    //     $_SESSION['error_message'] = 'Email sudah tersedia, Gunakan email yang lain!';
    //     header("Location: signup.php");
    //     exit();
    // } else {
        // Email is not in the database, proceed with registration
        $reg = $koneksi->prepare('insert into user(gmail, name, password) values(?, ?, ?)');
        $reg->bind_param('sss', $email, $name, $password);
        $reg->execute();
        header("Location: login_user.php");
        exit();
    // }

    $checkEmail->close();
    $reg->close();
    $koneksi->close();
}
?>
