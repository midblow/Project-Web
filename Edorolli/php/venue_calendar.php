<?php
header('Content-Type: application/json');
session_start();
require_once 'functions.php';
$conn = connectDatabase();

$user_id = $_SESSION['id'];
$id_venue = isset($_GET['id_venue']) ? (int)$_GET['id_venue'] : 0;
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');

if ($id_venue <= 0) {
    echo json_encode([]);
    exit();
}

$start_date = "$year-$month-01";
$end_date = date("Y-m-t", strtotime($start_date));

$sql = "SELECT start_date, end_date, status, user_id FROM booking WHERE id_venue = ? AND ((start_date BETWEEN ? AND ?) OR (end_date BETWEEN ? AND ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $id_venue, $start_date, $end_date, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

$bookings = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $booking_start_date = $row['start_date'];
        $booking_end_date = $row['end_date'];
        $status = $row['status'];
        $booking_user_id = $row['user_id'];

        if ($booking_user_id != $user_id) {
            if ($status == 'confirmed') {
                $status = 'reserved';
            } elseif ($status == 'waiting') {
                continue;
            }
        }

        $current_date = $booking_start_date;
        while ($current_date <= $booking_end_date) {
            $bookings[$current_date] = $status;
            $current_date = date("Y-m-d", strtotime($current_date . ' +1 day'));
        }
    }
}

$stmt->close();
$conn->close();

echo json_encode($bookings);
?>
