<?php
session_start();

require_once '../php/functions.php';
$conn = connectDatabase();

if (!isset($_SESSION['id'])) {
    header("Location: ../User/login_user.php");
    exit();
}

// Mengambil data dari form
$id_event = isset($_POST['id_event']) ? (int)$_POST['id_event'] : 0;
$id_venue = isset($_POST['id_venue']) ? (int)$_POST['id_venue'] : 0;
$nama_event = isset($_POST['nama_event']) ? $_POST['nama_event'] : '';
$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
$jenis_event = isset($_POST['jenis_event']) ? $_POST['jenis_event'] : '';
$informasi = isset($_POST['informasi']) ? $_POST['informasi'] : '';
$rules = isset($_POST['rules']) ? $_POST['rules'] : '';
$rekomendasi = isset($_POST['rekomendasi']) ? 1 : 0;
$gambar = '';

// Mengunggah gambar jika ada
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $uploadResult = uploadImage($_FILES["file"]);
    if (isset($uploadResult["error"])) {
        die($uploadResult["error"]);
    } else {
        $gambar = $uploadResult["path"];
    }
}

// Jika ID event ada, lakukan update, jika tidak lakukan insert
if ($id_event > 0) {
    // Update event
    if ($gambar) {
        $sql = "UPDATE event SET id_venue = ?, nama_event = ?, deskripsi = ?, jenis_event = ?, informasi = ?, rules = ?, rekomendasi = ?, gambar = ? WHERE id_event = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssisi", $id_venue, $nama_event, $deskripsi, $jenis_event, $informasi, $rules, $rekomendasi, $gambar, $id_event);
    } else {
        $sql = "UPDATE event SET id_venue = ?, nama_event = ?, deskripsi = ?, jenis_event = ?, informasi = ?, rules = ?, rekomendasi = ? WHERE id_event = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssii", $id_venue, $nama_event, $deskripsi, $jenis_event, $informasi, $rules, $rekomendasi, $id_event);
    }
} else {
    // Insert event baru
    $sql = "INSERT INTO event (id_venue, nama_event, deskripsi, jenis_event, informasi, rules, rekomendasi, gambar, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssisi", $id_venue, $nama_event, $deskripsi, $jenis_event, $informasi, $rules, $rekomendasi, $gambar, $_SESSION['id']);
}

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

if ($stmt->execute()) {
    if ($id_event > 0) {
        // Jika ini adalah update, redirect ke halaman event
        header("Location: ../User/event.php");
    } else {
        // Jika ini adalah insert baru, dapatkan id_event yang baru saja diinsert
        $new_id_event = $stmt->insert_id;
        // Redirect ke halaman detail event dengan id_event yang baru saja dibuat
        header("Location: ../User/event_detail.php?id_event=$new_id_event&id_venue=$id_venue");
    }
} else {
    die("Error executing statement: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>