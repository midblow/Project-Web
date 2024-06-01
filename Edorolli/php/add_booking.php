<?php
session_start();
header('Content-Type: application/json');
require_once 'functions.php';
$conn = connectDatabase();
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['start_date']) && isset($data['end_date']) && isset($data['status']) && isset($data['payment_method'])) {
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];
    $status = $data['status'];
    $payment_method = $data['payment_method'];
    $user_id = $_SESSION['id']; // Example user ID

    // Check if the date range is already booked
    $query = "SELECT * FROM booking WHERE (start_date <= ? AND end_date >= ?) AND (status = 'waiting' OR status = 'reserved' OR status = 'confirmed')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $end_date, $start_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Tanggal Sudah di-booking']);
    } else {
        $stmt = $conn->prepare("INSERT INTO booking (user_id, start_date, end_date, status, metode_pembayaran) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $start_date, $end_date, $status, $payment_method);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
    }

    $stmt->close();
}

$conn->close();
?>
