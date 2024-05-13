<?php
$koneksi = mysqli_connect('localhost', 'root', '', 'project-pweb');

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
session_start();
$gmail = $_POST['gmail'];
$password = $_POST['password'];

// Eksekusi query
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE gmail='$gmail' AND password='$password'");
if (!$query) {
    die(mysqli_error($koneksi));
}

// Memeriksa jumlah baris yang ditemukan
$cek = mysqli_num_rows($query);

if ($cek == 0) {
    echo "Password atau Username Salah!";
} else {
    header("Location: home_login.html");
    exit();
}
