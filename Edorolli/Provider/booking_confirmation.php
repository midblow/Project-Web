<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: http://localhost/Project-Web/Edorolli/Provider/prov_login.php");
    exit();
} else {
    $username = $_SESSION['username'];
    
    // Fetch id_provider from the database
    $sql = "SELECT id_provider FROM provider WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Output data of each row
        $row = $result->fetch_assoc();
        $id_provider = $row['id_provider'];
    } else {
        echo "0 results";
    }
}

// Pagination settings
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch bookings from the database
$sql = "SELECT b.id, b.start_date, b.end_date, b.status, u.gmail, u.name, v.nama_venue 
        FROM booking b
        JOIN user u ON b.user_id = u.id
        JOIN venue v ON b.id_venue = v.id_venue
        WHERE v.id_provider = $id_provider
        LIMIT $offset, $items_per_page";
$result = $conn->query($sql);

// Count total bookings for pagination
$sql_count = "SELECT COUNT(*) as total FROM booking b
              JOIN venue v ON b.id_venue = v.id_venue
              WHERE v.id_provider = $id_provider";
$count_result = $conn->query($sql_count);
$total_items = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Booking Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/booking_confirmation.css">
    <link rel="stylesheet" href="../css/footer.css" />
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo-nama">
                <div class="logo"><img src="../image/logo.png" alt="Logo"></div>
                <div class="nama_website"><a href="#">Edoroli</a></div>
            </div>
            <div class="menu"><a href="Provider.php">Hallo <?php echo $_SESSION['username']; ?><i class="far fa-user"></i></a></div>
        </div>
    </header>
    <nav class="main-title">
        <div class="nav-links">
            <a href="home_prov.php" class="nav-item" id="all-stay">All Stay</a>
            <a href="venue_prov.php?id_provider=<?php echo $id_provider; ?>&page=1" class="nav-item" id="venue">My Venue</a>
            <a href="booking_confirmation.php" class="nav-item active" id="booking">Booking Confirmation</a>
        </div>
    </nav>
    <main>
        <h1>Order List</h1>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <section class="order-list">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="order-item">';
                    echo '<div class="order-info">';
                    echo '<h2>' . $row['nama_venue'] . '</h2>';
                    echo '<p>Email: ' . $row['gmail'] . '</p>';
                    echo '<p>Nama: ' . $row['name'] . '</p>';
                    echo '<p>Date: ' . $row['start_date'] . ' - ' . $row['end_date'] . '</p>';
                    echo '</div>';
                    if ($row['status'] == 'waiting') {
                        echo '<div class="order-actions">';
                        echo '<form method="POST" action="../php/update_booking_status.php" class="inline-form">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<input type="hidden" name="status" value="confirmed">';
                        echo '<button type="submit" class="approve">Approve Payment</button>';
                        echo '</form>';
                        echo '<form method="POST" action="../php/update_booking_status.php" class="inline-form">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="decline">Decline</button>';
                        echo '</form>';
                        echo '</div>';
                    } else {
                        echo '<div class="order-status success">SUCCESS!!!</div>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<p>No bookings found.</p>';
            }
            ?>
        </section>
        <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="booking_confirmation.php?id_provider=<?php echo $id_provider; ?>&page=<?php echo $page - 1; ?>" class="pagination-button" id="prev-button">Previous</a>
                    <?php endif; ?>
                    <span class="page-number"><?php echo $page; ?></span>
                    <?php if ($page < $total_pages): ?>
                        <a href="booking_confirmation.php?id_provider=<?php echo $id_provider; ?>&page=<?php echo $page + 1; ?>" class="pagination-button" id="next-button">Next</a>
                    <?php endif; ?>
                </div>
    </main>
    <?php require_once '../php/footer.php'; ?>
    <script src="../js/popup_booking_status.js"></script>
</body>
</html>
