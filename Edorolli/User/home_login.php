<?php
session_start();
if (!isset($_SESSION['name'])) {
  // Jika sesi nama tidak diatur, redirect ke halaman login
  header("Location: ../User/login_user.php");
  exit();
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
          <a href="veneu.php" class="nav-item" id="venue">Venue</a>
          <a href="events1.html" class="nav-item" id="event">Event</a>
        </nav>
      </section>

      <section class="popular-venue">
        <h2>Populer Venue (Best Venue)</h2>
        <div id="venue-carousel">
          <div class="venue-item">
            <div class="card">
              <div class="image-container">
                <img src="../image/Sangkareang.jpg" alt="Taman Sangkareang" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Taman Sangkareang</p>
                <span class="plus-icon"
                  ><i class="far fa-bookmark" onclick="klikBookmark(this)"></i
                ></span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>
          </div>
          <div class="venue-item">
            <div class="card">
              <div class="image-container">
                <img src="../image/Pantai_Senggigi.jpg" alt="Pantai Senggigi" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Pantai Senggigi</p>
                <span class="plus-icon"
                  ><i class="far fa-bookmark" onclick="klikBookmark(this)"></i
                ></span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Senggigi</span>
              </div>
            </div>
          </div>
          <div class="venue-item">
            <div class="card">
              <div class="image-container">
                <img
                  src="../image/Narmada_Convention_Hall.jpg"
                  alt="Narmada Convention Hall"
                />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Narmada Convention Hall</p>
                <span class="plus-icon"
                  ><i class="far fa-bookmark" onclick="klikBookmark(this)"></i
                ></span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>
          </div>
          <div class="venue-item">
            <div class="card">
              <div class="image-container">
                <img src="../image/Hotel_Lombok_Raya.jpg" alt="Hotel Lombok Raya" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Hotel Lombok Raya</p>
                <span class="plus-icon"
                  ><i class="far fa-bookmark" onclick="klikBookmark(this)"></i
                ></span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>
          </div>
          <div class="venue-item">
            <div class="card">
              <div class="image-container">
                <img src="../image/Grand_Imperial.jpg" alt="Grand Imperial Ballroom" />
                <span class="heart-icon"
                  ><i class="far fa-heart" onclick="klikLike(this)"></i
                ></span>
              </div>
              <div class="info">
                <p class="name">Grand Imperial Ballroom</p>
                <span class="plus-icon"
                  ><i class="far fa-bookmark" onclick="klikBookmark(this)"></i
                ></span>
              </div>
              <div class="location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Mataram</span>
              </div>
            </div>
          </div>
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
        <h2>Event (Berita)</h2>
        <div id="event-carousel" class="owl-carousel owl-theme">
          <div class="event-item">
            <div class="event-card">
              <img src="../image/Dewa 19.jpg" alt="Dewa 19 Concert" />
              <div class="event-text">Dewa 19 Concert</div>
            </div>
          </div>
          <div class="event-item">
            <div class="event-card">
              <img src="../image/MLBB.jpg" alt="MLBB Tournament" />
              <div class="event-text">MLBB Tournament</div>
            </div>
          </div>
          <div class="event-item">
            <div class="event-card">
              <img src="../image/Futsal.jpg" alt="Futsal Championship" />
              <div class="event-text">Futsal Championship</div>
            </div>
          </div>
          <div class="event-item">
            <div class="event-card">
              <img src="../image/Senggigi_Sunset_Jazz.jpg" alt="Senggigi Sunset Jazz" />
              <div class="event-text">Senggigi Sunset Jazz</div>
            </div>
          </div>
          <div class="event-item">
            <div class="event-card">
              <img src="../image/Wedding.jpg" alt="Wedding Ceremony" />
              <div class="event-text">Wedding Ceremony</div>
            </div>
          </div>
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
