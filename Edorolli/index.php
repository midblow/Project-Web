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
        <div class="event-item">
          <div class="event-card">
            <img src="../Edorolli/image/Dewa 19.jpg" alt="Dewa 19 Concert" />
            <div class="event-text">Dewa 19 Concert</div>
          </div>
        </div>
        <div class="event-item">
          <div class="event-card">
            <img src="../Edorolli/image/MLBB.jpg" alt="MLBB Tournament" />
            <div class="event-text">MLBB Tournament</div>
          </div>
        </div>
        <div class="event-item">
          <div class="event-card">
            <img src="../Edorolli/image/Futsal.jpg" alt="Futsal Championship" />
            <div class="event-text">Futsal Championship</div>
          </div>
        </div>
        <div class="event-item">
          <div class="event-card">
            <img
              src="../Edorolli/image/Senggigi_Sunset_Jazz.jpg"
              alt="Senggigi Sunset Jazz"
            />
            <div class="event-text">Senggigi Sunset Jazz</div>
          </div>
        </div>
        <div class="event-item">
          <div class="event-card">
            <img src="../Edorolli/image/Wedding.jpg" alt="Wedding Ceremony" />
            <div class="event-text">Wedding Ceremony</div>
          </div>
        </div>
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
            <p>Edoroli adalah portal reservasi venue pertama di Indonesia, yang menyediakan akses informasi yang lengkap dan sistem yang mudah, cepat, dan efisien.</p>
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
        <p>© 2024 Edoroli Co., Ltd. All Rights Reserved.</p>
    </div>
</footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <script src="../Edorolli/js/iconHomepage.js"></script>
    <script src="../Edorolli/js/home_login.js"></script>
  </body>
</html>