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
    <title>Venue Detail</title>
    <link rel="stylesheet" href="../Edorolli/css/venue_detail.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
      rel="stylesheet"
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
          <a href="User.php"> Hallo <?php echo htmlspecialchars($nickname); ?><i class="far fa-user"></i></a>
        </div>
      </div>
    </nav>

    <div class="image-card">
      <div class="image-container">
        <img src="../Edorolli/image/Sangkareang.jpg" alt="Edoroli Logo" />
        <div class="overlay">
          <h1>TAMAN SANGKAREANG</h1>
        </div>
      </div>
    </div>

    <div class="content-container">
      <div class="details-container">
        <div class="left-section">
          <div class="header-section">
            <h2>Taman Sangkareang</h2>
            <div class="address-box">
              <p>
                Jl. Pendidikan, Dasan Agung Baru, Kec. Selaparang, Kota Mataram,
                Nusa Tenggara Barat
              </p>
            </div>
          </div>
          <div class="permissions">
            <h3>Perizinan</h3>
            <div class="permissions-box">
              <ul>
                <li>Izin Operasional</li>
                <li>Izin Lingkungan</li>
                <li>Izin Acara</li>
              </ul>
            </div>
          </div>
          <div class="event-venue">
            <h3>About event venue</h3>
            <div class="images">
              <div class="image-card">
                <img src="../Edorolli/image/ven_1.jpg" alt="Event 1" />
              </div>
              <div class="image-card">
                <img src="../Edorolli/image/ven_2.jpg" alt="Event 2" />
              </div>
              <div class="image-card">
                <img src="../Edorolli/image/ven_3.jpg" alt="Event 3" />
              </div>
            </div>
          </div>
        </div>
        <div class="right-section">
          <form id="booking-form">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" />

            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" />

            <button type="button" class="book-button" id="bookButton" disabled>
              Book
            </button>
            <button type="button" class="whatsapp-button">WhatsApp</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Calendar Container -->
    <div class="calendar-wrapper">
      <div class="calendar-container">
        <div class="calendar-navigation">
          <button id="prevMonth">Prev</button>
          <h2 id="calendar-title"></h2>
          <button id="nextMonth">Next</button>
        </div>
        <div id="calendar"></div>
      </div>
    </div>

    <!-- Payment Method Popup -->
    <div id="paymentPopup" class="popup">
      <div class="popup-content">
          <span class="close" id="closePopup">&times;</span>
          <h2>Pilih Metode Transaksi</h2>
          <div class="dropdown-container">
              <div class="dropdown">
                  <button class="dropbtn">
                      Bank <i class="fas fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content" id="bankMethods"></div>
              </div>
              <div class="dropdown">
                  <button class="dropbtn">
                      Gerai <i class="fas fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content" id="geraiMethods"></div>
              </div>
              <div class="dropdown">
                  <button class="dropbtn">
                      E-Wallet <i class="fas fa-caret-down"></i>
                  </button>
                  <div class="dropdown-content" id="ewalletMethods"></div>
              </div>
          </div>
          <button id="pilihButton" class="confirm-payment">Pilih</button>
      </div>
  </div>

    
    <script src="../Edorolli/js/veneu_calender.js"></script>
    <script src="../Edorolli/js/venue_popup.js"></script>
  </body>
</html>
