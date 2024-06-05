<?php
session_start();

if (!isset($_SESSION['username'])) {
  // Jika sesi nama tidak diatur, redirect ke halaman login
  header("Location: http://localhost/Project-Web/Edorolli/Provider/prov_login.php");
  exit();
}
require_once '../php/functions.php';
$conn = connectDatabase();

$id_provider = $_SESSION['id_provider'];
$items_per_page = 8;

// Fetch all venues for the current provider
$sql = "SELECT * FROM venue WHERE id_provider = ? LIMIT $items_per_page";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_provider);
$stmt->execute();
$venue_result = $stmt->get_result();

$sql = "SELECT * FROM venue WHERE id_provider = ? and main_venue = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_provider);
$stmt->execute();
$mains_venue = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Reservasi Venue Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/home_prov.css">
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
                <a href="../Provider/home_prov.php" class="nav-item active" id="all-stay">All Stay</a>
                <a href="venue_prov.php?id_provider=<?php echo $id_provider; ?>&page=1" class="nav-item" id="venue">My Venue</a>
                <a href="booking_confirmation.php" class="nav-item" id="booking">Booking Confirmation</a>
            </nav>
        </section>

        <section class="recomendation">
        <div class="image-cardB">
            <?php
                if ($mains_venue->num_rows > 0) {
                    if ($main_venue = $mains_venue->fetch_assoc()) {
                        echo'<h1 class="title">My Main Venue</h1>';
                        echo'<div class="image-containerB">';
                        echo '  <a href="venue_detail.php?id_venue=' . $main_venue["id_venue"] . '">';
                        echo'       <img src="'.$main_venue['gambar'].'" />';
                        echo '  </a>';
                        echo'   <div class="overlay">';
                        echo '<h1 class="overlay-title">' . strtoupper($main_venue['nama_venue']) . '</h1>';
                        echo'   </div>';
                        echo'</div>';
                    }
                } else {
                    // Gambar dan nama default
                    echo '<h1 class="title">Your Best Venue</h1>';
                    echo '<div class="image-containerB">';
                    echo '  <a href="#">';
                    echo '      <img src="../image/map.jpg">';
                    echo '  </a>';
                    echo '  <div class="overlay">';
                    echo '      <h1 class="overlay-title">Default Name</h1>';
                    echo '  </div>';
                    echo '</div>';
                }
                ?>      
        </div>
    </section>

        <section class="venue">
            <div class="title">
                <h1>Top Venue As Provider</h1>
            </div>
            <div class="gallery">
                <?php
                if ($venue_result->num_rows > 0) {
                    while ($row = $venue_result->fetch_assoc()) {
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
                    echo "No venues found.";
                }
                ?>
            </div>
        </section>
    </main>
    <?php require_once '../php/footer.php'; ?>
    <script src="../js/iconHomepage.js"></script>
</body>
</html>
