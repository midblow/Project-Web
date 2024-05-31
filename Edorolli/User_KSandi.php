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
    <link rel="stylesheet" href="../Edorolli/css/User_Ksandi.css" />
    <script src="../Edorolli/js/ChangePass.js" ></script>
    <script src="../Edorolli/js/logout_user.js" ></script>
  </head>
  <body>
    <header>
      <div class="wrapper">
        <div class="logo">
          <img src="../Edorolli/image/logo.png" alt="Logo" />
        </div>
        <div class="nama_website">
          <a>Edoroli</a>
        </div>
        <div class="menu">
          <a href=""> Hallo <?php echo htmlspecialchars($nickname);?><i class="far fa-user"></i></a>
        </div>
      </div>
    </header>

    <section class="main-title">
      <h1>Kelola Akun Anda</h1>
      <nav>
        <a href="User.php" class="nav-item">Profile</a>
        <a href="Riwayat Reservasi" class="nav-item">Riwayat Reservasi</a>
        <a href="Kelola Akun" class="nav-item active">Kelola Akun</a>
      </nav>
    </section>

    <main>
      <div class="container">
        <div class="sidebar">
          <div class="profile-info">
            <img src="../Edorolli/image/MLBB.jpg" alt="Profile Picture" />
            <h3><?php echo $_SESSION['name']; ?></h3>
            <p><?php echo $_SESSION['gmail']; ?></p>
          </div>
          <nav>
            <ul>
              <li>
                <a href="User.php"><i class="far fa-user"></i> Profile</a>
              </li>
              <li>
                <a href="#"
                  ><i class="far fa-file-alt"></i> Riwayat Reservasi</a
                >
              </li>
              <li class="active">
                <a href="#"><i class="fas fa-cogs"></i> Kelola Akun</a>
              </li>
              <li><a href="User_KSandi.php?action=logout" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
          </nav>
        </div>

        <div class="content">
          <div class="profile-details">
            <h2>Kelola Akun</h2>
            <div class="manage-account" id="manageAccountButtons">
              <button class="manage-button" id="changePasswordBtn">
                Ganti Kata Sandi
              </button>
              <button class="manage-button" id="deleteAccountBtn">
                Hapus Akun
              </button>
            </div>
            <div
              id="changePasswordForm"
              class="change-password-form"
              style="display: none"
            >
              <form id="passwordForm" action="php/update_pass.php" method="POST">
                <label for="newPassword">Masukkan Kata Sandi Baru</label>
                <input
                  type="password"
                  id="newPassword"
                  name="newPassword"
                  required
                />
                <label for="confirmPassword">Konfirmasi Kata Sandi Baru</label>
                <input
                  type="password"
                  id="confirmPassword"
                  name="confirmPassword"
                  required
                />
                <div class="button-group">
                  <button
                    type="button"
                    id="cancelChangePasswordBtn"
                    class="cancel-btn"
                  >
                    Batal
                  </button>
                  <button type="submit" class="save-btn">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <footer>
            <div class="footer-container">
                <div class="footer-left">
                    <img src="../image/logo.png" alt="Edoroli Logo">
                    <div class="nama_website"><a href="#">Edoroli</a></div>
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

    <!-- Popup -->
    <div id="popup" class="popup" style="display: none">
      <div class="popup-content">
        <i class="fas fa-check-circle success-icon" id="popupIcon"></i>
        <i class="fas fa-times-circle error-icon" id="popupErrorIcon"></i>
        <h2 id="popupMessage"></h2>
        <button id="closePopupBtn" class="close-btn">OK</button>
      </div>
    </div>
    <!-- Popup Logout -->
    <div id="logoutPopup" class="popup_logout">
      <div class="popup-content_logout">
        <i class="fas fa-exclamation-triangle fa-3x warning-icon"></i>
        <h2>Apakah anda yakin ingin keluar?</h2>
        <div class="popup-buttons_logout">
          <a id="cancelBtnLO" class="cancel-btnLO">Tidak</a>
          <a href="../Edorolli/php/logout.php" id="confirmBtnLO" class="confirm-btnLO">Ya</a>
        </div>
      </div>
    </div>

    
  </body>
</html>
