<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <link rel="stylesheet" href="/Edorolli/css/signup.css" />
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
  </head>
  <body>
    <section>
      <div class="register">
        <form action="/Edorolli/php/BUAT_DAH.php" method="post">
          <div class="gambar">
            <img src="/Edorolli/image/hallo_user.png"/>
          </div>
          <h2>Sign Up</h2>
          <div class="inputbox">
            <ion-icon name="mail-outline"></ion-icon>
            <input type="email" required name="gmail" />
            <label>Email</label>
          </div>
          <div class="inputbox">
            <ion-icon name="person-outline"></ion-icon>
            <input type="text" required name="name" />
            <label>Nama</label>
          </div>
          <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" required name="password" />
            <label>Password</label>
          </div>
          <div class="inputbox">
            <ion-icon name="call-outline"></ion-icon>
            <input type="tel" required name="phone" />
            <label>Nomor Telepon</label>
          </div>
          <div class="inputbox">
            <ion-icon name="location-outline"></ion-icon>
            <input type="text" required name="address" />
            <label>Alamat</label>
          </div>
          <div class="forget">
            <label
              ><input type="checkbox" required /> I Agree to the Terms &
              Conditions</label
            >
          </div>
          <button type="submit" name="register">Sign Up</button>

          <?php if (!empty($_SESSION['error_message'])): ?>
          <div class="error-message"><?= $_SESSION['error_message']; ?></div>
          <?php unset($_SESSION['error_message']);?>
          <?php endif; ?>

          <div class="login">
            <p>Already have an account! <a href="/Provider/prov_login.php">Log In</a></p>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>
