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
    <title>Edoroli - Manage Users</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../Edorolli/css/manage_user.css" />
  </head>
  <body>
    <header>
      <div class="wrapper">
        <div class="logo">
          <img src="../Edorolli/image/logo.png" alt="Edoroli Logo" />
        </div>
        <div class="nama_website">
          <a href="home_login.php">Edoroli</a>
        </div>
        <div class="menu">
          <a href="#">Hallo <?php echo htmlspecialchars($nickname); ?><i class="far fa-user"></i></a>
        </div>
      </div>
    </header>

    <section class="main-title">
      <h1>All You Can Manage</h1>
      <nav>
        <a href="manage_user.php" class="nav-item active">Manage User</a>
        <a href="manage_provider.php" class="nav-item">Manage Provider</a>
        <a href="manage_content.php" class="nav-item">Manage Content</a>
      </nav>
    </section>

    <main>
      <div class="user-grid">
        <?php for ($i = 0; $i < 10; $i++): ?>
          <div class="user-card">
            <div class="user-card-content">
              <p><strong>ID User</strong></p>
              <p>USERNAME</p>
              <p>EMAIL</p>
            </div>
            <button class="detail-btn">Detail</button>
          </div>
        <?php endfor; ?>
      </div>
      <button class="next-btn">Selanjutnya</button>
    </main>

    <footer>
      <div class="footer-container">
        <div class="footer-left">
          <img src="../Edorolli/image/logo.png" alt="Edoroli Logo" />
          <div class="nama_website"><a href="#">Edoroli</a></div>
        </div>
        <div class="footer-center">
          <h3>TENTANG EDOROLI</h3>
          <p>
            Edoroli adalah portal reservasi venue pertama di Indonesia, yang
            menyediakan akses informasi yang lengkap dan sistem yang mudah,
            cepat, dan efisien.
          </p>
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

    <script src="../Edorolli/js/editUser.js"></script>
    <script src="../Edorolli/js/logout_user.js"></script>
  </body>
</html>
