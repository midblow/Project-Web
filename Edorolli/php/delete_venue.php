<?php
session_start();
require_once 'functions.php';
$conn = connectDatabase();

if (isset($_GET['id']) && isset($_SESSION['id_provider'])) {

    $venue_id = $_GET['id'];
    $id_provider = $_SESSION['id_provider'];

    $stmt = $conn->prepare("DELETE FROM venue WHERE id_venue=?");
    $stmt->bind_param("i", $venue_id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";

        // Calculate new total pages for the specific provider
        $total_items_sql = "SELECT COUNT(*) AS total FROM venue WHERE id_provider = ?";
        $stmt_total = $conn->prepare($total_items_sql);
        $stmt_total->bind_param("i", $id_provider);
        $stmt_total->execute();
        $total_items_result = $stmt_total->get_result();
        $total_items = $total_items_result->fetch_assoc()['total'];
        $total_pages = ceil($total_items / 8); // Assuming items per page

        // Redirect to the first page or the previous page if the last page was deleted
        $redirect_page = $total_pages > 0 ? $total_pages : 1;
        header("Location: ../Provider/venue_prov.php?id_provider=" . $id_provider . "&page=" . $redirect_page);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();

    $conn->close();
} else {
    echo "Error: Invalid request.";
    if (!isset($_GET['id'])) {
        echo " Venue ID is missing.";
    }
    if (!isset($_SESSION['id_provider'])) {
        echo " Provider ID is missing.";
    }
}
?>
