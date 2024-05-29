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
    <link rel="stylesheet" href="../Edorolli/css/User.css" />
  </head>
  <body>
    <header>
      <div class="wrapper">
        <div class="logo">
          <img src="../Edorolli/image/logo.png" />
        </div>
        <div class="nama_website">
          <a href="home_login.php">Edoroli</a>
        </div>
        <div class="menu">
          <a href=""> Hallo <?php echo htmlspecialchars($nickname); ?><i class="far fa-user"></i></a>
        </div>
      </div>
    </header>

    <section class="main-title">
      <h1>Kelola Akun Anda</h1>
      <nav>
        <a href="User.php" class="nav-item active">Profile</a>
        <a href="Riwayat Reservasi" class="nav-item">Riwayat Reservasi</a>
        <a href="User_KSandi.php" class="nav-item">Kelola Akun</a>
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
              <li class="active"><a href="User.php"><i class="far fa-user"></i> Profile</a></li>
              <li><a href="#"><i class="far fa-file-alt"></i> Riwayat Reservasi</a></li>
              <li><a href="User_KSandi.php"><i class="fas fa-cogs"></i> Kelola Akun</a></li>
              <li><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
          </nav>
        </div>

        <div class="content">
          <div class="profile-details">
            <h2>Profile</h2>
            <form id="profileForm" action="php/update_profile.php" method="POST">

              <label for="name">Nama</label>
              <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" disabled/>

              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="<?php echo $_SESSION['gmail']; ?>" disabled/>

              <label for="gender">Jenis Kelamin</label>
              <input type="text" id="gender" name="gender" value="<?php echo $_SESSION['gender']; ?>" disabled/>
              
              <label for="phone">Nomor Telepon</label>
              <input type="text" id="phone" name="phone" value="<?php echo $_SESSION['phone']; ?>" disabled/>

              <label for="address">Alamat</label>
              <textarea id="address" name="address" rows="4" disabled><?php echo $_SESSION['alamat']; ?></textarea>
              
              <div class="button-group">
                <button type="button" id="editBtn" class="edit-btn">Edit</button>
                <button type="button" id="cancelBtn" class="cancel-btn" style="display: none"> Batal </button>
                <button type="submit" id="saveBtn" class="save-btn" style="display: none"> Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>

    <!-- Popup Logout -->
    <div id="logoutPopup" class="popup_logout">
      <div class="popup-content_logout">
        <i class="fas fa-exclamation-triangle fa-3x warning-icon"></i>
        <h2>Apakah anda yakin ingin keluar?</h2>
        <div class="popup-buttons_logout">
          <button id="cancelBtnLO" class="cancel-btnLO">Tidak</button>
          <button id="confirmBtnLO" class="confirm-btnLO">Ya</button>
        </div>
      </div>
    </div>

    <script src="../Edorolli/js/logoutUser.js"></script>
    <script src="../Edorolli/js/editUser.js"></script>
  </body>
</html>
