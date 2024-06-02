<?php
session_start();
header('Content-Type: application/json');
require_once 'functions.php';
$conn = connectDatabase();
$data = json_decode(file_get_contents("php://input"), true);

$response = [];

if (isset($data['start_date']) && isset($data['end_date']) && isset($data['status']) && isset($data['payment_method']) && isset($data['id_venue'])) {
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];
    $status = $data['status'];
    $payment_method = $data['payment_method'];
    $id_venue = $data['id_venue'];
    $user_id = $_SESSION['id']; // Example user ID

    // Check if the date range is already booked for the same venue by any user with status 'reserved' or 'confirmed'
    $query = "SELECT * FROM booking WHERE id_venue = ? AND (start_date <= ? AND end_date >= ?) AND (status = 'reserved' OR status = 'confirmed')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $id_venue, $end_date, $start_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response = ['success' => false, 'error' => 'Tanggal Sudah di-booking'];
    } else {
        // Check if the user already has a booking with status 'waiting' for the same date range
        $query = "SELECT * FROM booking WHERE id_venue = ? AND user_id = ? AND (start_date <= ? AND end_date >= ?) AND status = 'waiting'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiss", $id_venue, $user_id, $end_date, $start_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response = ['success' => false, 'error' => 'You already have a pending booking for these dates.'];
        } else {
            $stmt = $conn->prepare("INSERT INTO booking (user_id, start_date, end_date, status, metode_pembayaran, id_venue) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssi", $user_id, $start_date, $end_date, $status, $payment_method, $id_venue);

            if ($stmt->execute()) {
                $response = ['success' => true];
            } else {
                $response = ['success' => false, 'error' => $stmt->error];
            }
        }
    }

    $stmt->close();
} else {
    $response = ['success' => false, 'error' => 'Invalid input.'];
}

$conn->close();
echo json_encode($response);
?>
