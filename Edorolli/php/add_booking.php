<?php
session_start();
header('Content-Type: application/json');

$conn = mysqli_connect('localhost', 'root', '', 'project_pweb');

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$data = json_decode(file_get_contents("php://input"), true);



if (isset($data['start_date']) && isset($data['end_date']) && isset($data['status']) && isset($data['payment_method'])) {
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];
    $status = $data['status'];
    $payment_method = $data['payment_method'];
    $user_id = $_SESSION['id']; // Example user ID


    if (!in_array($payment_method, ['bri', 'bca', 'mandiri', 'bni', 'alfamart', 'indomaret', 'dana', 'ovo', 'shopeepay', 'linkaja'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid payment method']);
        exit;
    }

    // Cek apakah sudah ada booking dengan status waiting, reservasi, atau confirmed
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM booking WHERE ((start_date <= ? AND end_date >= ?) OR (start_date <= ? AND end_date >= ?)) AND (status = 'waiting' OR status = 'reservasi' OR status = 'confirmed')");
    $stmt->bind_param("ssss", $start_date, $start_date, $end_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(['success' => false, 'error' => 'Date range is already booked.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    // Jika tidak ada konflik, lakukan booking
    $stmt = $conn->prepare("INSERT INTO booking (user_id, start_date, end_date, status, metode_pembayaran) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $start_date, $end_date, $status, $payment_method);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'bookings' => getBookings($conn)]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();

?>
