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

    $stmt = $conn->prepare("INSERT INTO booking (user_id, start_date, end_date, status, metode_pembayaran) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $start_date, $end_date, $status, $payment_method);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
