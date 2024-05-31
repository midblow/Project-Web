<?php
session_start();
if (!isset($_SESSION['name'])) {
  // Jika sesi nama tidak diatur, redirect ke halaman login
  header("Location: http://localhost/Project-Web/Edorolli/login_user.php");
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
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../Edorolli/css/veneu.css" />
  </head>
  <body>
    <header>
      <div class="wrapper">
        <div class="logo">
          <img src="../Edorolli/image/logo.png" />
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
        <a href="veneu.php" class="nav-item active" id="venue">Venue</a>
        <a href="events1.html" class="nav-item" id="event">Event</a>
      </nav>
    </section>
    <section class="veneu">
      <div class="gallery">
        <div class="card">
          <div class="image-container">
            <a href="venue_book.php">
              <img src="../Edorolli/image/Sangkareang.jpg" />
            </a>
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
        <!-- NANTI GANTI GAMBARNYA YANG INI YAAAAAAAAA -->

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
            <img src="../Edorolli/image/Gelanggang_Pemuda.png" />
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
      <div class="pagination">
        <button class="pagination-button" id="prev-button">Previous</button>
        <span class="page-number">1</span>
        <button class="pagination-button" id="next-button">Next</button>
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
          <p>
            Edoroli adalah portal reservasi veneu pertama di Indonesia, yang
            menyediakan akses informasi yang lengkap dan sistem yang mudah,
            cepat, dan efisien.
          </p>
        </div>
        <div class="footer-right">
          <h3>SOSIAL MEDIA</h3>
          <ul>
            <li>
              <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
            </li>
            <li>
              <a href="#"><i class="fab fa-whatsapp"></i> Whatsapp</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2024 Edoroli Co., Ltd. All Rights Reserved.</p>
      </div>
    </footer>

    <script src="../Edorolli/js/iconHomepage.js"></script>
  </body>
</html>
