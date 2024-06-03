<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_event = $_POST['id_event'];
    $nama_event = $_POST['nama_event'];
    $deskripsi = $_POST['deskripsi'];
    $jenis_event = $_POST['jenis_event'];
    $informasi = $_POST['informasi'];
    $rules = $_POST['rules'];
    $rekomendasi = isset($_POST['rekomendasi']) ? 1 : 0;
    $gambar = $_FILES['file'];

    // If a new image is uploaded
    if (!empty($gambar['tmp_name'])) {
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

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
                // Update the event with the new image
                $stmt = $conn->prepare("UPDATE event SET nama_event=?, deskripsi=?, jenis_event=?, informasi=?, rules=?, rekomendasi=?, gambar=? WHERE id_event=?");
                $stmt->bind_param("sssssssi", $nama_event, $deskripsi, $jenis_event, $informasi, $rules, $rekomendasi, $target_file, $id_event);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update the event without changing the image
        $stmt = $conn->prepare("UPDATE event SET nama_event=?, deskripsi=?, jenis_event=?, informasi=?, rules=?, rekomendasi=? WHERE id_event=?");
        $stmt->bind_param("ssssssi", $nama_event, $deskripsi, $jenis_event, $informasi, $rules, $rekomendasi, $id_event);
    }

    if (isset($stmt) && $stmt->execute()) {
        echo "Event updated successfully";
        header("Location: ../User/event_detail.php?id_venue=" . $id_venue"&id_event" . $id_event);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    if (isset($stmt)) {
        $stmt->close();
    }
}

$conn->close();
?>