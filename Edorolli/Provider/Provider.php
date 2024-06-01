<?php
session_start();

if (!isset($_SESSION['username'])) {
  // Jika sesi nama tidak diatur, redirect ke halaman login
  header("Location: http://localhost/Project-Web/Edorolli/Provider/prov_login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Reservasi Venue Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/Provider.css">
    <link rel="stylesheet" href="../css/footer.css" />
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo">
                <img src="../image/logo.png" alt="Logo">
            </div>
            <div class="nama_website">
                <a href="home_prov.php">Edoroli</a>
            </div>
            <div class="menu">
                <a href="Provider.php">Hallo <?php echo $_SESSION['username']; ?><i class="far fa-user"></i></a>
            </div>
        </div>
    </header>
    <section class="main-title">
        <h1>Kelola Akun Anda</h1>
        <nav>
            <a href="Provider.php" class="nav-item active">Profile</a>
            <a href="Booking_Confirmation.php" class="nav-item">Booking Confirmation</a>
            <a href="Provider_KSandi.php" class="nav-item">Kelola Akun</a>
        </nav>
    </section>
    <main>
        <div class="container">
            <div class="sidebar">
                <div class="profile-info">
                    <img src="../image/MLBB.jpg" alt="Profile Picture">
                    <h3><?php echo $_SESSION['lembaga']; ?></h3>
                    <p><?php echo $_SESSION['gmail']; ?></p>
                </div>
                <nav>
                    <ul>
                        <li class="active"><a href="Provider.php"><i class="far fa-user"></i> Profile</a></li>
                        <li><a href="#"><i class="far fa-file-alt"></i> Booking</a></li>
                        <li><a href="Provider_KSandi.php"><i class="fas fa-cogs"></i> Kelola Akun</a></li>
                        <li><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                    </ul>
                </nav>
            </div>
            <div class="content">
                <div class="profile-details">
                    <h2>Profile</h2>
                    <form id="profileForm" action="../php/update_provider.php" method="POST">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" disabled>

                        <label for="gmail">Email</label>
                        <input type="email" id="gmail" name="gmail" value="<?php echo $_SESSION['gmail']; ?>" disabled>

                        <label for="lembaga">Lembaga</label>
                        <input type="text" id="lembaga" name="lembaga" value="<?php echo $_SESSION['lembaga']; ?>" disabled>

                        <label for="nomorhp">Nomor Telepon</label>
                        <input type="text" id="nomorhp" name="nomorhp" value="<?php echo $_SESSION['phone']; ?>" disabled>

                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="4" disabled><?php echo $_SESSION['alamat']; ?></textarea>

                        <div class="button-group">
                            <button type="button" id="editBtn" class="edit-btn">Edit</button>
                            <button type="button" id="cancelBtn" class="cancel-btn" style="display: none">Batal</button>
                            <button type="submit" id="saveBtn" class="save-btn" style="display: none">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <?php require_once '../php/footer.php'; ?>

    <!-- Popup Logout -->
    <div id="logoutPopup" class="popup_logout">
        <div class="popup-content_logout">
            <i class="fas fa-exclamation-triangle fa-3x warning-icon"></i>
            <h2>Apakah anda yakin ingin keluar?</h2>
            <div class="popup-buttons_logout">
                <a id="cancelBtnLO" class="cancel-btnLO">Tidak</a>
                <a href="../php/logout.php" id="confirmBtnLO" class="confirm-btnLO">Ya</a>
            </div>
        </div>
    </div>
    <script src="../js/logout.js"></script>
    <script src="../js/editProvider.js"></script>
</body>
</html>
