<?php
function connectDatabase() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'project_pweb';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    return $conn;
}

function registrasi($data) {
    global $conn;

    // Sanitize and validate input data
    $email = filter_var($data["gmail"], FILTER_SANITIZE_EMAIL);
    $name = strtolower(trim($data["name"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $gender = $data["gender"];
    $phone = filter_var($data["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address = mysqli_real_escape_string($conn, $data["address"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Email tidak valid!';
        header("Location: http://localhost/Project-Web/Edorolli/signup.php");
        exit();
    }

    // Check email
    $result = mysqli_query($conn, "SELECT gmail FROM user WHERE gmail = '$email'");
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['error_message'] = 'Email sudah tersedia, gunakan email yang lain!';
        header("Location: http://localhost/Project-Web/Edorolli/signup.php");
        exit();
    }

    // Hash the password
    // $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Add user
    $query = "INSERT INTO user (gmail, name, password, gender, nomorhp, alamat) VALUES('$email', '$name', '$password', '$gender', '$phone', '$address')";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}

function regProv($data) {
    global $conn;

    // Sanitize and validate input data
    $email = filter_var($data["gmail"], FILTER_SANITIZE_EMAIL);
    $username = strtolower(trim($data["username"]));
    $lembaga = mysqli_real_escape_string($conn, $data["lembaga"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $phone = filter_var($data["nomorhp"], FILTER_SANITIZE_NUMBER_INT);
    $address = mysqli_real_escape_string($conn, $data["alamat"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Email tidak valid!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }

    // Check email
    $result = mysqli_query($conn, "SELECT gmail FROM provider WHERE gmail = '$email'");
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['error_message'] = 'Email sudah tersedia, gunakan email yang lain!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }

    // Hash the password
    // $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Add user (without hashing)
    $query = "INSERT INTO provider (gmail, username, lembaga, password, nomorhp, alamat) VALUES('$email', '$username', '$lembaga', '$password', '$phone', '$address')";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}

function generateInvoice($booking_id) {
    $conn = connectDatabase();
    
    // Fetch booking details
    $sql = "SELECT b.*, v.harga, p.lembaga, b.user_id
            FROM booking b
            JOIN venue v ON b.id_venue = v.id_venue
            JOIN provider p ON v.id_provider = p.id_provider
            WHERE b.id = ? AND b.status = 'confirmed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if (!$booking) {
        die("Booking not found or not confirmed.");
    }

    // Calculate totals
    $date1 = new DateTime($booking['start_date']);
    $date2 = new DateTime($booking['end_date']);
    $interval = $date1->diff($date2);
    $days = $interval->days + 1; // Including the start date

    $price_per_day = $booking['harga'];
    $total_price = $price_per_day * $days;
    $service_fee = 50000; // Assume a fixed service fee
    $grand_total = $total_price + $service_fee;

    // Insert into invoice table
    $date = date('Y-m-d');
    $payment_method = $booking['metode_pembayaran'];

    $sql_invoice = "INSERT INTO invoice (booking_id, date, total_amount, payment_method, service_fee) VALUES (?, ?, ?, ?, ?)";
    $stmt_invoice = $conn->prepare($sql_invoice);
    $stmt_invoice->bind_param("isdss", $booking_id, $date, $grand_total, $payment_method, $service_fee);
    $stmt_invoice->execute();

    if ($stmt_invoice->affected_rows > 0) {
        $invoice_id = $conn->insert_id;
        return ['id_user' => $booking['user_id'], 'id_invoice' => $invoice_id];
    } else {
        die("Error creating invoice: " . $conn->error);
    }
}

// Example usage
// $booking_id = 1; 
// $invoice_data = generateInvoice($booking_id);
// header("Location: invoice.php?id_user=" . $invoice_data['id_user'] . "&id_invoice=" . $invoice_data['id_invoice']);
// exit();


function resize_and_crop_image($source_image_path, $output_image_path, $output_width, $output_height) {
    list($original_width, $original_height, $image_type) = getimagesize($source_image_path);
    
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $source_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_image = imagecreatefrompng($source_image_path);
            break;
        case IMAGETYPE_GIF:
            $source_image = imagecreatefromgif($source_image_path);
            break;
        default:
            return false;
    }
    
    $aspect_ratio = $original_width / $original_height;
    $output_aspect_ratio = $output_width / $output_height;

    if ($aspect_ratio > $output_aspect_ratio) {
        $new_height = $output_height;
        $new_width = intval($output_height * $aspect_ratio);
    } else {
        $new_width = $output_width;
        $new_height = intval($output_width / $aspect_ratio);
    }

    $output_image = imagecreatetruecolor($output_width, $output_height);
    
    imagecopyresampled($output_image, $source_image, 
        0 - ($new_width - $output_width) / 2,
        0 - ($new_height - $output_height) / 2,
        0, 0,
        $new_width, $new_height,
        $original_width, $original_height);
    
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            imagejpeg($output_image, $output_image_path, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($output_image, $output_image_path);
            break;
        case IMAGETYPE_GIF:
            imagegif($output_image, $output_image_path);
            break;
    }
    
    imagedestroy($source_image);
    imagedestroy($output_image);
    
    return $output_image_path;
}
?>
