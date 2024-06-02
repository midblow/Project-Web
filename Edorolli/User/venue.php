<?php
session_start();
if (!isset($_SESSION['name'])) {
  // Jika sesi nama tidak diatur, redirect ke halaman login
  header("Location: ../User/login_user.php");
  exit();
}

$nicknameArray = explode(' ', $_SESSION['name']);
$nickname = $nicknameArray[0];

require_once '../php/functions.php';
$conn = connectDatabase();

$items_per_page = 16;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch venues with pagination
$sql = "SELECT * FROM venue LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Get total number of venues for pagination
$total_items_sql = "SELECT COUNT(*) AS total FROM venue";
$total_items_result = $conn->query($total_items_sql);
$total_items = $total_items_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edoroli - Reservasi Venue Online</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/venue.css" />
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

  <section class="main-title">
    <h1>Temukan venue terbaik untuk event anda</h1>
    <nav>
      <a href="home_login.php" class="nav-item" id="all-stay">All Stay</a>
      <a href="venue.php" class="nav-item active" id="venue">Venue</a>
      <a href="event.php" class="nav-item" id="event">Event</a>
    </nav>
  </section>
  <section class="venue">
    <div class="gallery">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="card">';
          echo '  <div class="image-container">';
          echo '    <a href="venue_book.php?id_venue=' . $row["id_venue"] . '">';
          echo '      <img src="' . $row["gambar"] . '" alt="Venue Image" />';
          echo '    </a>';
          echo '    <span class="heart-icon"><i class="far fa-heart" onclick="klikLike(this)"></i></span>';
          echo '  </div>';
          echo '  <div class="info">';
          echo '    <p class="name">' . htmlspecialchars($row["nama_venue"]) . '</p>';
          echo '    <span class="plus-icon"><i class="far fa-bookmark" onclick="klikBookmark(this)"></i></span>';
          echo '  </div>';
          echo '  <div class="location">';
          echo '    <i class="fa-solid fa-location-dot"></i>';
          echo '    <span>' . htmlspecialchars($row["kota"]) . '</span>';
          echo '  </div>';
          echo '</div>';
        }
      } else {
        echo "<p>No venues found.</p>";
      }
      ?>
    </div>
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="venue.php?page=<?php echo $page - 1; ?>" class="pagination-button" id="prev-button">Previous</a>
      <?php endif; ?>
      <span class="page-number"><?php echo $page; ?></span>
      <?php if ($page < $total_pages): ?>
        <a href="venue.php?page=<?php echo $page + 1; ?>" class="pagination-button" id="next-button">Next</a>
      <?php endif; ?>
    </div>
  </section>

  <?php require_once '../php/footer.php'; ?>

  <script src="../js/iconHomepage.js"></script>
</body>
</html>
