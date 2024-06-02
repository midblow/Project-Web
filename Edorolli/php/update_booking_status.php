<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if ($status) {
        $sql = "UPDATE booking SET status='$status' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                localStorage.setItem('successMessage', 'Booking updated successfully');
                window.location.href='../Provider/booking_confirmation.php';
            </script>";
        } else {
            echo "<script>
                localStorage.setItem('errorMessage', 'Error updating booking: " . $conn->error . "');
                window.location.href='../Provider/booking_confirmation.php';
            </script>";
        }
    } else {
        $sql = "DELETE FROM booking WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                localStorage.setItem('successMessage', 'Booking deleted successfully');
                window.location.href='../Provider/booking_confirmation.php';
            </script>";
        } else {
            echo "<script>
                localStorage.setItem('errorMessage', 'Error deleting booking: " . $conn->error . "');
                window.location.href='../Provider/booking_confirmation.php';
            </script>";
        }
    }

    $conn->close();
    exit();
}
?>