<?php
header('Content-Type: application/json');

$conn = mysqli_connect('localhost', 'root', '', 'project_pweb');

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['start_date']) && isset($data['end_date']) && isset($data['status'])) {
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];
    $status = $data['status'];
    $user_id = 2; // Example user ID

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, start_date, end_date, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $start_date, $end_date, $status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
