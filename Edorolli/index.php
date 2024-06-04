<?php
session_start();
require_once 'php/functions.php';
$conn = connectDatabase();

// Set limit for the number of events to display
$event_limit = 8;

// Fetch confirmed events with a recommendation limit
$sql = "SELECT * FROM event WHERE rekomendasi = 1 AND status = 'confirmed' LIMIT ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_limit);
$stmt->execute();
$events_result = $stmt->get_result();

if ($events_result === false) {
    die("Error fetching events: " . $conn->error);
}

// Ambil main_venue yang disetujui oleh admin untuk semua provider
$json_venues = file_get_contents('../Edorolli/json/main_venues.json');
$main_venues = json_decode($json_venues, true);

// Pastikan $main_venues adalah array yang valid
if (is_array($main_venues) && !empty($main_venues)) {
    $placeholders = implode(',', array_fill(0, count($main_venues), '?'));
    $types = str_repeat('i', count($main_venues)) . 'i';
    $query = "
    SELECT *
    FROM venue
    WHERE main_venue = 1 AND id_venue IN ($placeholders)
    LIMIT ?";
    $stmt = $conn->prepare($query);

    $params = array_merge(array_column($main_venues, 'id_venue'), [$limit]);

    // Memastikan jumlah parameter sesuai
    $refs = [];
    foreach ($params as $key => $value) {
        $refs[$key] = &$params[$key];
    }

    array_unshift($refs, $types); // Menambahkan jenis parameter di awal array referensi

    // Menggunakan call_user_func_array untuk bind_param
    call_user_func_array([$stmt, 'bind_param'], $refs);

    $stmt->execute();
    $result = $stmt->get_result();
    $venues = $result->fetch_all(MYSQLI_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edoroli - Reservasi Veneu Online</title>
    <link rel="stylesheet" href="../Edorolli/css/homestyle.css" />
    <link rel="stylesheet" href="../Edorolli/css/footer.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
<nav>
    <div class="wrapper">
        <div class="logo">
            <img src="../Edorolli/image/logo.png" />
        </div>
        <div class="nama_website">
            <a>Edoroli</a>
        </div>
        <div class="menu">
            <ul>
                <li><a href="homepage.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="role-selection.html" class="login">Get Started</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper">
    <section id="home">
        <div class="homepage">
            <div class="desc">
                <h2>Edoroli</h2>
                <h3>Solusi reservasi venue terlengkap se-Pulau Lombok</h3>
                <p>
                    Membuat reservasi menjadi lebih efisien dan efektif dengan
                    ketersediaan informasi yang lengkap dan sistem yang mudah dan
                    cepat
                </p>
                <a href="role-selection.html" class="login">Get Started</a>
            </div>
            <div class="landing">
                <img src="../Edorolli/image/banner.png" />
            </div>
        </div>
        <?php if (!empty($venues)): ?>
        <div class="populer">
            <h2>Popular Venue</h2>
            <div class="gallery">
                <?php
                foreach ($venues as $venue) {
                    // Cari gambar dari JSON
                    $image_path = '';
                    foreach ($main_venues as $main_venue) {
                        if ($main_venue['id_venue'] == $venue['id_venue']) {
                            $image_path = $main_venue['gambar'];
                            break;
                        }
                    }
                    echo '<div class="card">';
                    echo '    <div class="image-container">';
                    echo '        <img src="' . htmlspecialchars($image_path) . '" />';
                    echo '        <span class="heart-icon"><i class="far fa-heart" onclick="klikLike(this)"></i></span>';
                    echo '    </div>';
                    echo '    <div class="info">';
                    echo '        <p class="name">' . htmlspecialchars($venue["nama_venue"]) . '</p>';
                    echo '        <span class="plus-icon"><i class="far fa-bookmark" onclick="klikBookmark(this)"></i></span>';
                    echo '    </div>';
                    echo '    <div class="location">';
                    echo '        <i class="fa-solid fa-location-dot"></i>';
                    echo '        <span>' . htmlspecialchars($venue["kota"]) . '</span>';
                    echo '    </div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>

<section class="events">
    <h2>Event</h2>
    <div id="event-carousel" class="owl-carousel owl-theme">
    <?php while ($event = $events_result->fetch_assoc()): ?>
        <div class="event-card">
            <a href="role-selection.html">
                <img src="../Edorolli/image/<?php echo htmlspecialchars($event['gambar']); ?>" />
            </a>
            <div class="event-info">
                <a href="role-selection.html"><h2><?php echo htmlspecialchars($event['nama_event']); ?></h2></a>
                <!-- <p><?php echo htmlspecialchars($event['deskripsi']); ?></p> -->
            </div>
        </div>
    <?php endwhile; ?>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
<script src="../Edorolli/js/iconHomepage.js"></script>
<script src="../Edorolli/js/home_login.js"></script>
</body>
</html>
