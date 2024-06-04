<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if (!isset($_SESSION['id_provider'])) {
    header("Location: ../Provider/prov_login.php");
    exit();
}

// Mengambil data dari form
$venue_id = isset($_POST['venue_id']) ? (int)$_POST['venue_id'] : 0;
$name_venue = isset($_POST['name_venue']) ? $_POST['name_venue'] : '';
$deskripsi_fasilitas = isset($_POST['deskripsi_fasilitas']) ? $_POST['deskripsi_fasilitas'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$kota = isset($_POST['kota']) ? $_POST['kota'] : '';
$penanggung_jawab = isset($_POST['penanggung_jawab']) ? $_POST['penanggung_jawab'] : '';
$kapasitas = isset($_POST['kapasitas']) ? (int)$_POST['kapasitas'] : 0;
$harga = isset($_POST['harga']) ? (int)$_POST['harga'] : 0;
$jenis_instansi = isset($_POST['jenis_instansi']) ? $_POST['jenis_instansi'] : '';
$main_venue = isset($_POST['main_venue']) ? 1 : 0;
$id_provider = $_SESSION['id_provider'];
$gambar_path = '';

// Mengunggah gambar jika ada
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
    $uploadResult = uploadImage($_FILES["file"]);
    if (isset($uploadResult["error"])) {
        die($uploadResult["error"]);
    } else {
        $gambar_path = $uploadResult["path"];
    }
}

// Jika ID venue ada, lakukan update, jika tidak lakukan insert
if ($venue_id > 0) {
    // Ambil gambar lama jika tidak ada gambar baru yang di-upload
    if (!$gambar_path) {
        $sql = "SELECT gambar FROM venue WHERE id_venue = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $venue_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $venue = $result->fetch_assoc();
        $gambar_path = $venue['gambar'];
    }

    // Update venue
    $sql = "UPDATE venue SET nama_venue = ?, deskripsi_fasilitas = ?, alamat = ?, kota = ?, penanggung_jawab = ?, kapasitas = ?, harga = ?, jenis_instansi = ?, gambar = ?, main_venue = ?, id_provider = ? WHERE id_venue = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiissiii", $name_venue, $deskripsi_fasilitas, $alamat, $kota, $penanggung_jawab, $kapasitas, $harga, $jenis_instansi, $gambar_path, $main_venue, $id_provider, $venue_id);
} else {
    // Insert venue baru
    $sql = "INSERT INTO venue (nama_venue, deskripsi_fasilitas, alamat, kota, penanggung_jawab, kapasitas, harga, jenis_instansi, gambar, main_venue, id_provider) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiissii", $name_venue, $deskripsi_fasilitas, $alamat, $kota, $penanggung_jawab, $kapasitas, $harga, $jenis_instansi, $gambar_path, $main_venue, $id_provider);
}

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

if ($stmt->execute()) {
    if ($main_venue == 1) {
        // Reset main_venue untuk semua venue dari provider ini
        $query = "UPDATE venue SET main_venue = 0 WHERE id_provider = $id_provider";
        mysqli_query($conn, $query);

        // Set main_venue untuk venue yang dipilih
        $query = "UPDATE venue SET main_venue = 1 WHERE id_venue = $venue_id ";
        mysqli_query($conn, $query);
        header("Location: ../Provider/venue_prov.php?id_provider=" . $id_provider . "&page1");
        exit();
    } else {
        $query = "UPDATE venue SET main_venue = 0 WHERE id_venue = $venue_id";
        mysqli_query($conn, $query);
        header("Location: ../Provider/venue_detail.php?id_venue=" . $venue_id);
        exit();
    }

} else {
    die("Error executing statement: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>