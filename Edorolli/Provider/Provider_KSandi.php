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
    <link rel="stylesheet" href="../css/Provider_KSandi.css">
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
            <a href="Provider.php" class="nav-item">Profile</a>
            <a href="Booking_Confirmation.php" class="nav-item">Booking Confirmation</a>
            <a href="Provider_KSandi.php" class="nav-item active">Kelola Akun</a>
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
                        <li><a href="User.php"><i class="far fa-user"></i> Profile</a></li>
                        <li><a href="prov_riwayatR.php?id_provider=<?php echo $_SESSION['id_provider']; ?>"><i class="far fa-file-alt"></i> Riwayat Reservasi</a></li>
                        <li class="active"><a href="#"><i class="fas fa-cogs"></i> Kelola Akun</a></li>
                        <li><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
                    </ul>
                </nav>
            </div>
            <div class="content">
                <div class="profile-details">
                    <h2>Kelola Akun</h2>
                    <div class="manage-account" id="manageAccountButtons">
                        <button class="manage-button" id="changePasswordBtn">Ganti Kata Sandi</button>
                        <button class="manage-button" id="deleteAccountBtn">Hapus Akun</button>
                    </div>
                    <div id="changePasswordForm" class="change-password-form" style="display: none">
                        <form id="passwordForm" action="../php/update_provider_pass.php" method="POST">
                            <label for="newPassword">Masukkan Kata Sandi Baru</label>
                            <input type="password" id="newPassword" name="newPassword" required>
                            <label for="confirmPassword">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" required>
                            <div class="button-group">
                                <button type="button" id="cancelChangePasswordBtn" class="cancel-btn">Batal</button>
                                <button type="submit" class="save-btn">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../php/footer.php'; ?>

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
                <a href="../php/logout.php" id="confirmBtnLO" class="confirm-btnLO">Ya</a>
            </div>
        </div>
    </div>
    <script src="../js/logout.js" ></script>
    <script src="../js/ChangePass.js" ></script>
</body>
</html>
