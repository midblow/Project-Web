<?php
session_start();
require_once 'functions.php'; 
$conn = connectDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name_venue = $_POST['name_venue'];
    $deskripsi_fasilitas = $_POST['deskripsi_fasilitas'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $penanggung_jawab = $_POST['penanggung_jawab'];
    $kapasitas = $_POST['kapasitas'];
    $harga = $_POST['harga'];
    $jenis_instansi = $_POST['jenis_instansi'];
    $main_venue = isset($_POST['main_venue']) ? 1 : 0; // Assuming this is passed as a checkbox
    $gambar = $_FILES['file'];
    $id_provider = $_SESSION['id_provider'];

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($gambar["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($gambar["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
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

                $stmt = $conn->prepare("INSERT INTO venue (nama_venue, deskripsi_fasilitas, alamat, kota, penanggung_jawab, kapasitas, harga, jenis_instansi, gambar, id_provider) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssiissi", $name_venue, $deskripsi_fasilitas, $alamat, $kota, $penanggung_jawab, $kapasitas, $harga, $jenis_instansi, $target_file, $id_provider);

                if ($stmt->execute()) {
                    $venue_id = $conn->insert_id; // Get the last inserted ID

                    // Update main_venue status
                    if ($main_venue == 1) {
                        // Reset main_venue for all venues from this provider
                        $query = "UPDATE venue SET main_venue = 0 WHERE id_provider = ?";
                        $stmt_reset = $conn->prepare($query);
                        $stmt_reset->bind_param("i", $id_provider);
                        $stmt_reset->execute();

                        // Set main_venue for the newly inserted venue
                        $query = "UPDATE venue SET main_venue = 1 WHERE id_venue = ?";
                        $stmt_update = $conn->prepare($query);
                        $stmt_update->bind_param("i", $venue_id);
                        $stmt_update->execute();
                    }

                    // Calculate new total pages for the specific provider
                    $total_items_sql = "SELECT COUNT(*) AS total FROM venue WHERE id_provider = ?";
                    $stmt_total = $conn->prepare($total_items_sql);
                    $stmt_total->bind_param("i", $id_provider);
                    $stmt_total->execute();
                    $total_items_result = $stmt_total->get_result();
                    $total_items = $total_items_result->fetch_assoc()['total'];
                    $total_pages = ceil($total_items / 8); // Assuming items per page

                    // Redirect to the last page
                    header("Location: ../Provider/venue_prov.php?id_provider=" . $id_provider . "&page=" . $total_pages);
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error processing your image.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } elseif ($use_existing_file) {
        // If using existing file
        $stmt = $conn->prepare("INSERT INTO venue (nama_venue, deskripsi_fasilitas, alamat, kota, penanggung_jawab, kapasitas, harga, jenis_instansi, gambar, id_provider) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssiissi", $name_venue, $deskripsi_fasilitas, $alamat, $kota, $penanggung_jawab, $kapasitas, $harga, $jenis_instansi, $target_file, $id_provider);

        if ($stmt->execute()) {
            $venue_id = $conn->insert_id; // Get the last inserted ID

            // Update main_venue status
            if ($main_venue == 1) {
                // Reset main_venue for all venues from this provider
                $query = "UPDATE venue SET main_venue = 0 WHERE id_provider = ?";
                $stmt_reset = $conn->prepare($query);
                $stmt_reset->bind_param("i", $id_provider);
                $stmt_reset->execute();

                // Set main_venue for the newly inserted venue
                $query = "UPDATE venue SET main_venue = 1 WHERE id_venue = ?";
                $stmt_update = $conn->prepare($query);
                $stmt_update->bind_param("i", $venue_id);
                $stmt_update->execute();
            }

            // Calculate new total pages for the specific provider
            $total_items_sql = "SELECT COUNT(*) AS total FROM venue WHERE id_provider = ?";
            $stmt_total = $conn->prepare($total_items_sql);
            $stmt_total->bind_param("i", $id_provider);
            $stmt_total->execute();
            $total_items_result = $stmt_total->get_result();
            $total_items = $total_items_result->fetch_assoc()['total'];
            $total_pages = ceil($total_items / 8); // Assuming items per page

            // Redirect to the last page
            header("Location: ../Provider/venue_prov.php?id_provider=" . $id_provider . "&page=" . $total_pages);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
}
?>
