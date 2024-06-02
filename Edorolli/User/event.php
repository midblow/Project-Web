<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

// Constants for pagination
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch total number of events
$total_sql = "SELECT COUNT(*) as total FROM event";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

// Fetch events for the current page
$sql = "SELECT * FROM event LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $items_per_page);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Error fetching events: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edoroli - Reservasi Venue Online</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../css/events.css" />
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo">
                <img src="../image/logo.png" />
            </div>
            <div class="nama_website">
                <a href="../index.html">Edoroli</a>
            </div>
            <div class="menu">
                <a href="User.php"> Hallo <?php echo $_SESSION['name']; ?><i class="far fa-user"></i></a>
            </div>
        </div>
    </header>

    <section class="main-title">
        <h1>Temukan venue terbaik untuk event anda</h1>
        <nav>
            <a href="home_login.php" class="nav-item" id="all-stay">All Stay</a>
            <a href="venue.php" class="nav-item" id="venue">Venue</a>
            <a href="events1.html" class="nav-item active" id="event">Event</a>
        </nav>
    </section>

    <section class="events">
        <?php while ($event = $result->fetch_assoc()): ?>
            <div class="event-card">
                <a href="event_detail.php?id_event=<?php echo $event['id_event']; ?>">
                    <img src="<?php echo htmlspecialchars($event['gambar']); ?>" alt="<?php echo htmlspecialchars($event['nama_event']); ?>" />
                </a>
                <div class="event-info">
                    <a href="event_detail.php?id_event=<?php echo $event['id_event']; ?>"><h2><?php echo htmlspecialchars($event['nama_event']); ?></h2></a>
                    <p><?php echo htmlspecialchars($event['deskripsi']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </section>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="pagination-button" id="prev-button">Previous</a>
        <?php endif; ?>
        <span class="page-number"><?php echo $page; ?></span>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="pagination-button" id="next-button">Next</a>
        <?php endif; ?>
    </div>

    <script src="../js/pageEvent.js"></script>
    <script>
        function updatePageNumber() {
            document.querySelector('.page-number').textContent = <?php echo $page; ?>;
        }
        updatePageNumber();
    </script>
</body>
</html>

<?php