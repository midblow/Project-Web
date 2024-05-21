<?php

$koneksi = mysqli_connect('localhost', 'root', '', 'project_pweb');

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $name = $koneksi->real_escape_string($_POST['name']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $phone = $koneksi->real_escape_string($_POST['phone']);
    $message = $koneksi->real_escape_string($_POST['message']);

    // Menyusun query untuk memasukkan data ke dalam tabel contact
    $sql = "INSERT INTO contact (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";

    // Set cookie dengan status
    // setcookie("status", "success", time() + (86400 * 30), "/"); // status success, berlaku selama 30 hari

    // Menjalankan query dan memeriksa apakah berhasil
    if ($koneksi->query($sql) === TRUE) {
        header("Location: http://localhost/Project-Web/Edorolli/contact.html?status=success");
    } else {
        header("Location: http://localhost/Project-Web/Edorolli/contact.html?status=error");
    }
}

// Menutup koneksi
$koneksi->close();
?>