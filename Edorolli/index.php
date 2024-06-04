<?php
session_start();
require_once 'php/functions.php';
$conn = connectDatabase();

// Constants for pagination
$items_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch total number of confirmed events
$total_sql = "SELECT COUNT(*) as total FROM event WHERE status = 'confirmed' AND rekomendasi = 1";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

// Fetch confirmed events for the current page
$sql = "SELECT * FROM event  WHERE rekomendasi = 1 AND status = 'confirmed' LIMIT ?, ?";
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
    <title>Edoroli - Reservasi Veneu Online</title>
    <link rel="stylesheet" href="../Edorolli/css/homestyle.css" />
    <link rel="stylesheet" href="../Edorolli/css/footer.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
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
            <h3>Solusi reservasi veneu terlengkap se-Pulau Lombok</h3>
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

        <div class="populer">
          <h2>Popular Venue</h2>
          <div class="gallery">
            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Sangkareang.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Taman Sangkareang</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>

            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Pantai_Senggigi.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Pantai Senggigi</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Senggigi</span>
              </div>
            </div>

            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Narmada_Convention_Hall.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Narmada Convention Hall</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>

            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Hotel_Lombok_Raya.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Hotel Lombok Raya</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>

            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Grand_Imperial.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Grand Imperial Ballroom</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>

            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Islamic_Center.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Islamic Center NTB</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>

            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Gelanggang_Pemuda.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Gelanggang Pemuda Mataram</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>

            <div class="card">
              <div class="image-container">
                <img src="../Edorolli/image/Senggigi_Hotel.jpg" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Aruna Senggigi Resort & Convention</p>
                <span class="plus-icon">
                  <i class="far fa-bookmark" onclick="klikBookmark(this)"></i>
                </span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Senggigi</span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <section class="events">
      <h2>Event</h2>
      <div id="event-carousel" class="owl-carousel owl-theme">
      <?php while ($event = $result->fetch_assoc()): ?>
            <div class="event-card">
                <a href="user/event_detail.php?id_event=<?php echo $event['id_event']; ?>">
                  <img src="../Edorolli/image/<?php echo htmlspecialchars($event['gambar']); ?>" />
                </a>
                <div class="event-info">
                  <a href="user/event_detail.php?id_event=<?php echo $event['id_event']; ?>"><h2><?php echo htmlspecialchars($event['nama_event']); ?></h2></a>
                    <!-- <p><?php echo htmlspecialchars($event['deskripsi']); ?></p> -->
                </div>
            </div>
        <?php endwhile; ?>
      </div>
    </section>

    <footer>
    <div class="footer-container">
        <div class="footer-left">
            <img src="../Edorolli/image/logo.png" alt="Edoroli Logo" />
            <div class="nama_website">
                <a>Edoroli</a>
            </div>
        </div>
        <div class="footer-center">
            <h3>TENTANG EDOROLI</h3>
            <p>Edoroli adalah portal reservasi venue pertama se-Pulau Lombok, yang menyediakan akses informasi yang lengkap dan sistem yang mudah, cepat, dan efisien.</p>
        </div>
        <div class="footer-right">
            <h3>SOSIAL MEDIA</h3>
            <ul>
                <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="#"><i class="fab fa-whatsapp"></i> Whatsapp</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>©️ 2024 Edoroli Co., Ltd. All Rights Reserved.</p>
    </div>
</footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <script src="../Edorolli/js/iconHomepage.js"></script>
    <script src="../Edorolli/js/home_login.js"></script>
  </body>
</html>