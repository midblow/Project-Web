<?php
session_start();
if (!isset($_SESSION['name'])) {
    // Jika sesi nama tidak diatur, redirect ke halaman login
    header("Location: ../User/login_user.php");
    exit();
}

require_once '../php/functions.php';
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

// Fetch main venues approved by admin
$json_venues = file_get_contents('../json/main_venues.json');
$main_venues = json_decode($json_venues, true);

$venues = [];
if (is_array($main_venues) && !empty($main_venues)) {
    $placeholders = implode(',', array_fill(0, count($main_venues), '?'));
    $types = str_repeat('i', count($main_venues)) . 'i';
    $query = "
    SELECT *
    FROM venue
    WHERE main_venue = 1 AND id_venue IN ($placeholders)
    LIMIT ?";
    $stmt = $conn->prepare($query);

    $params = array_merge(array_column($main_venues, 'id_venue'), [$event_limit]);

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

$nicknameArray = explode(' ', $_SESSION['name']);
$nickname = $nicknameArray[0];
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
      href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../css/home_login.css" />
    <link rel="stylesheet" href="../css/footer.css" />
  </head>
  <body>
    <header>
      <div class="wrapper">
        <div class="logo">
          <img src="../image/logo.png" />
        </div>
        <div class="nama_website">
          <a>Edoroli</a>
        </div>
        <div class="menu">
          <a href="User.php"> Hallo <?php echo htmlspecialchars($nickname); ?><i class="far fa-user"></i></a>
        </div>
      </div>
    </header>

    <main>
      <section class="main-title">
        <h1>Temukan venue terbaik untuk event anda</h1>
        <nav>
          <a href="home_login.php" class="nav-item active" id="all-stay"
            >All Stay</a
          >
          <a href="venue.php" class="nav-item" id="venue">Venue</a>
          <a href="event.php" class="nav-item" id="event">Event</a>
        </nav>
      </section>

      <?php if (!empty($venues)): ?>
      <section class="popular-venue">
        <h2>Rekomendasi Venue (Best Venue)</h2>
        <div id="venue-carousel">
            <?php foreach ($venues as $venue): ?>
              <div class="venue-item">
                <div class="card">
                  <div class="image-container">
                    <a href="venue_book.php?id_venue=<?php echo $venue['id_venue']; ?>">
                      <img src="../image/<?php echo htmlspecialchars($venue['gambar']); ?>" alt="<?php echo htmlspecialchars($venue['nama_venue']); ?>" />
                    </a>
                  </div>
                  <div class="info">
                    <p class="name"><?php echo htmlspecialchars($venue['nama_venue']); ?></p>
                    <span class="plus-icon"><i class="far fa-bookmark" onclick="klikBookmark(this)"></i></span>
                  </div>
                  <div class="location">
                    <i class="fa-solid fa-location-dot"></i>
                    <span><?php echo htmlspecialchars($venue['kota']); ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </section>

      <section class="reservation-procedure">
        <h2>Tata cara reservasi venue</h2>
        <div class="procedure-steps">
          <div class="step">
            <img src="../image/1cara.jpg" alt="Step 1" />
            <div class="step-content">
              <h3>1. Pilih Venue/Event</h3>
              <p>
                Mulailah perjalanan tak terlupakan Anda dengan memilih venue
                yang sempurna untuk merayakan momen spesial Anda.
              </p>
            </div>
          </div>
          <div class="step">
            <img src="../image/2cara.jpg" alt="Step 2" />
            <div class="step-content">
              <h3>2. Mengisi identitas</h3>
              <p>
                Kami ingin tahu lebih banyak tentang acara Anda. Mohon berikan
                kami informasi yang diperlukan untuk memastikan semuanya
                berjalan dengan lancar.
              </p>
            </div>
          </div>
          <div class="step">
            <img src="../image/3cara.jpg" alt="Step 3" />
            <div class="step-content">
              <h3>3. Melengkapi form SOP</h3>
              <p>
                Kenyamanan Anda adalah prioritas kami. Mohon pastikan semuanya
                tersusun rapi sesuai kebutuhan Anda.
              </p>
            </div>
          </div>
          <div class="step">
            <img src="../image/4cara.jpg" alt="Step 4" />
            <div class="step-content">
              <h3>4. Melakukan pembayaran</h3>
              <p>
                Dengan persiapan yang teliti, saatnya membayar dan memastikan
                semuanya siap untuk perayaan yang tak terlupakan. Selamat datang
                di pengalaman eksklusif Anda!
              </p>
            </div>
          </div>
        </div>
      </section>
      
      <section class="events">
        <h2>Rekomendasi Event</h2>
        <div id="event-carousel" class="owl-carousel owl-theme">
          <?php while ($event = $events_result->fetch_assoc()): ?>
            <div class="event-card">
              <a href="event_detail.php?id_event=<?php echo $event['id_event']; ?>">
                <img src="../image/<?php echo htmlspecialchars($event['gambar']); ?>" />
              </a>
              <div class="event-info">
                <a href="user/event_detail.php?id_event=<?php echo $event['id_event']; ?>"><h2><?php echo htmlspecialchars($event['nama_event']); ?></h2></a>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </section>
    </main>

    <?php require_once '../php/footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <script src="../js/home_login.js"></script>
    <script src="../js/iconHomepage.js"></script>
  </body>
</html>
