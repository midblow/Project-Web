<?php
session_start();
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'project_pweb');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $venue_id = $_POST['venue_id'];
    $name_venue = $_POST['name_venue'];
    $deskripsi_fasilitas = $_POST['deskripsi_fasilitas'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $kapasitas = $_POST['kapasitas'];
    $harga = $_POST['harga'];
    $jenis_instansi = $_POST['jenis_instansi'];  // Now a single value from radio buttons
    $gambar = $_FILES['file'];
    $main_venue = isset($_POST['main_venue']) ? 1 : 0;  // Checkbox value
    $id_provider = $_SESSION['id_provider'];

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($gambar["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!empty($gambar["tmp_name"])) {
        $check = getimagesize($gambar["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            // If file exists, use the existing file
            $uploadOk = 0;
            $use_existing_file = true;
        } else {
            $use_existing_file = false;
        }

        if ($gambar["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            $temp_file = $target_dir . 'temp_' . basename($gambar["name"]);
            if (move_uploaded_file($gambar["tmp_name"], $temp_file)) {
                if (resize_and_crop_image($temp_file, $target_file, 278, 285)) {
                    unlink($temp_file);
                } else {
                    echo "Sorry, there was an error processing your image.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $use_existing_file = true;
        $target_file = $_POST['existing_image'];
    }

    if ($use_existing_file || $uploadOk == 1) {
        $stmt = $conn->prepare("UPDATE venue SET nama_venue=?, deskripsi_fasilitas=?, alamat=?, kota=?, penanggung_jawab=?, kapasitas=?, harga=?, jenis_instansi=?, gambar=?, main_venue=?, id_provider=? WHERE id_venue=?");
        $stmt->bind_param("sssssiissiii", $name_venue, $deskripsi_fasilitas, $alamat, $kota, $penanggung_jawab, $kapasitas, $harga, $jenis_instansi, $target_file, $main_venue, $id_provider, $venue_id);

        if ($stmt->execute()) {
            echo "Record updated successfully";
            // Generate detail files
            generate_all_venue_detail_files($conn);
            header("Location: ../Provider/venue_detail_" . $venue_id . ".php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
}
?>
