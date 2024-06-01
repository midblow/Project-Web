<?php
header('Content-Type: application/json');
session_start();
require_once 'functions.php';
$conn = connectDatabase();

$user_id = $_SESSION['id'];

$sql = "SELECT start_date, end_date, status, user_id FROM booking";
$result = $conn->query($sql);

$bookings = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $status = $row['status'];
        $booking_user_id = $row['user_id'];

        if ($booking_user_id != $user_id) {
            if ($status == 'confirmed') {
                $status = 'reserved';
            } elseif ($status == 'waiting') {
                continue;
            }
        }

        $current_date = $start_date;
        while ($current_date <= $end_date) {
            $bookings[$current_date] = $status;
            $current_date = date("Y-m-d", strtotime($current_date . ' +1 day'));
        }
    }
}

$conn->close();

echo json_encode($bookings);
?>
