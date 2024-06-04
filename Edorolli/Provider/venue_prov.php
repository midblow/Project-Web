<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['id_provider'])) {
    // Jika sesi username atau id_provider tidak diatur, redirect ke halaman login
    header("Location: ../Provider/prov_login.php");
    exit();
}

require_once '../php/functions.php';
$conn = connectDatabase();

$logged_in_id_provider = $_SESSION['id_provider'];
$id_provider = isset($_GET['id_provider']) ? (int)$_GET['id_provider'] : 0;

// Validate id_provider
if ($id_provider !== $logged_in_id_provider) {
    // Redirect to login page if id_provider is not authorized
    header("Location: ../Provider/prov_login.php");
    exit();
}

$items_per_page = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

if ($id_provider == 0) {
    echo "No provider ID provided.";
    exit();
}

// Fetch venues for the current provider with pagination
$sql = "SELECT * FROM venue WHERE id_provider = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $id_provider, $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Get total number of venues for pagination
$total_items_sql = "SELECT COUNT(*) AS total FROM venue WHERE id_provider = ?";
$stmt_total = $conn->prepare($total_items_sql);
$stmt_total->bind_param("i", $id_provider);
$stmt_total->execute();
$total_items_result = $stmt_total->get_result();
$total_items = $total_items_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Reservasi Venue Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/venue_prov.css">
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
    <main>
        <section class="main-title">
            <nav>
                <a href="../Provider/home_prov.php" class="nav-item" id="all-stay">All Stay</a>
                <a href="venue_prov.php?id_provider=<?php echo $id_provider; ?>&page=1" class="nav-item active" id="venue">My Venue</a>
                <a href="booking_confirmation.php" class="nav-item" id="booking">Booking Confirmation</a>
            </nav>
        </section>
        <section class="venue">
            <div class="gallery">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card">';
                        echo '    <div class="image-container">';
                        echo '        <a href="venue_detail.php?id_venue=' . $row["id_venue"] . '">';
                        echo '            <img src="' . $row["gambar"] . '" alt="Venue Image">';
                        echo '        </a>';
                        echo '    </div>';
                        echo '    <div class="info">';
                        echo '        <p class="name">' . $row["nama_venue"] . '</p>';
                        echo '        <span class="plus-icon"><i class="far fa-bookmark" onclick="klikBookmark(this)"></i></span>';
                        echo '    </div>';
                        echo '    <div class="location">';
                        echo '        <i class="fa-solid fa-location-dot"></i>';
                        echo '        <span>' . $row["kota"] . '</span>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No venues found. <a href='add_venue_form.php'>Add a new venue</a>.</p>";
                }
                ?>
            </div>
            <div class="button-container">
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="venue_prov.php?id_provider=<?php echo $id_provider; ?>&page=<?php echo $page - 1; ?>" class="pagination-button" id="prev-button">Previous</a>
                    <?php endif; ?>
                    <span class="page-number"><?php echo $page; ?></span>
                    <?php if ($page < $total_pages): ?>
                        <a href="venue_prov.php?id_provider=<?php echo $id_provider; ?>&page=<?php echo $page + 1; ?>" class="pagination-button" id="next-button">Next</a>
                    <?php endif; ?>
                </div>
                <div class="add-venue">
                    <a href="add_venue_form.php">
                        <button class="card add-venue-btn">
                            <h3>+Add Venue</h3>
                        </button>
                    </a>
                </div>
            </div>
        </section>
    </main>
    <?php require_once '../php/footer.php'; ?>
    <script src="../js/iconHomepage.js"></script>
</body>
</html>
