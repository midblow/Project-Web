<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
    <link rel="stylesheet" href="../Edorolli/css/signup.css" />
  </head>

  <body>
    <section>
      <div class="register">
        <form action="koneksiregister.php" method="post">
          <div class="gambar">
            <img src="../Edorolli/image/hallo_user.png" />
          </div>
          <h2>Signup</h2>
          <div class="inputbox">
            <ion-icon name="mail-outline"></ion-icon>
            <input type="email" required name="gmail" />
            <label>Email</label>
          </div>
          <div class="inputbox">
            <ion-icon name="person"></ion-icon>
            <input type="nama" required name="name" />
            <label>Nama</label>
          </div>
          <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" required name="password" />
            <label>Password</label>
          </div>
          <div class="forget">
            <label><input type="checkbox" />I Agree Terms & Conditions</label>
          </div>
          <button>Sign In</button>
          <!-- <?php if (!empty($_SESSION['error_message'])): ?>
        <div class="error-message"><?= $_SESSION['error_message']; ?></div>
        <?php unset($_SESSION['error_message']); // Clear the message after displaying ?>
    <?php endif; ?> -->
          <div class="login">
            <p>Already have an account! <a href="../Edorolli/css/login_user.php">Log In</a></p>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>
