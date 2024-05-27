<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', '', 'project_pweb');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings
$sql = "SELECT start_date, end_date, status FROM bookings";
$result = $conn->query($sql);

$bookings = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $status = $row['status'];

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
