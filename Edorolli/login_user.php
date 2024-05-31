<?php
session_start();
if (!isset($_SESSION['error_message'])) {
    $_SESSION['error_message'] = ''; 
  
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log In!!</title>
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
    <link rel="stylesheet" href="../Edorolli/css/login_user.css" />
  </head>

  <body>
    <section>
      <div class="form-box">
        <form id='login' action="../Edorolli/php/proses_login.php" method="post">
          <div class="gambar">
            <img src="../Edorolli/image/hallo_user.png" />
          </div>
          <h2>Login</h2>
          <div class="inputbox">
            <ion-icon name="mail-outline"></ion-icon>
            <input type="email" name="gmail" required/>
            <label>Email</label>
          </div>
          <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" name="password" required />
            <label>Password</label>
          </div>
          <div class="forget">
            <label><input type="checkbox" />Remember Me</label>
            <a href="#">Forgot Password</a>
          </div>
          <button type= 'submit' name='login'>Log In</button>
          <?php if (!empty($_SESSION['error_message'])): ?>
          <div class="error-message"><?= $_SESSION['error_message']; ?></div>
          <?php unset($_SESSION['error_message']); ?>
          <?php endif; ?>
          <div class="register">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>
