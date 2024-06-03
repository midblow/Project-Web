<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_event = $_POST['nama_event'];
    $deskripsi = $_POST['deskripsi'];
    $jenis_event = $_POST['jenis_event'];
    $informasi = $_POST['informasi'];
    $rules = $_POST['rules'];
    $rekomendasi = isset($_POST['rekomendasi']) ? 1 : 0;
    $gambar = $_FILES['file'];
    $id_user = $_SESSION['id'];
    $id_venue = $_POST['id_venue'];

    // Process the uploaded image
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($gambar["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($gambar["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($gambar["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
            // Resize and crop the image
            $resized_image_path = $target_dir . 'resized_' . basename($gambar["name"]);
            resize_and_crop_image($target_file, $resized_image_path, 800, 600);

            // Insert new event into the database
            $stmt = $conn->prepare("INSERT INTO event (nama_event, deskripsi, jenis_event, informasi, rules, rekomendasi, gambar, id_user, id_venue, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'waiting')");
            $stmt->bind_param("sssssssis", $nama_event, $deskripsi, $jenis_event, $informasi, $rules, $rekomendasi, $resized_image_path, $id_user, $id_venue);
            if ($stmt->execute()) {
                echo "Event added successfully";
                header("Location: ../User/event_detail.php?id_event=" . $conn->insert_id);
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
