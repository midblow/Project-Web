<?php
session_start();

if (!isset($_SESSION['email_admin'])) {
  header("Location: http://localhost/Project-Web/Edorolli/Admin/login_admin.php");
  exit();
}

require_once '../php/functions.php';
$conn = connectDatabase();

// Mengambil ID user dari URL
$userId = $_GET['id'];

$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edoroli - Manage Users</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/detail_user.css" />
  <link rel="stylesheet" href="../css/footer.css" />
</head>
<body>
<header>
    <div class="wrapper">
        <div class="logo-nama">
            <div class="logo"><img src="../image/logo.png" alt="Logo"></div>
            <div class="nama_website"><a href="#">Edoroli</a></div>
        </div>
        <div class="menu"><a href="user_manage.php?page=1">Hallo <?php echo $_SESSION['username']; ?><i class="far fa-user"></i></a></div>
    </div>
</header>
<nav class="main-title">
<h1>All You Can Manage</h1>
    <div class="nav-links">
        <a href="user_manage.php?page=1" class="nav-item active" id="user">Manage User</a>
        <a href="prov_manage.php?page=1" class="nav-item" id="provider">Manage Provider</a>
        <a href="content_manage.php" class="nav-item" id="content">Manage Content</a>
    </div>
</nav>

<main>
  <div class="container">
    <div class="sidebar">
      <div class="profile-info">
        <img src="../image/MLBB.jpg" alt="Profile Picture" />
        <h3><?php echo htmlspecialchars($user['name']); ?></h3>
        <p><?php echo htmlspecialchars($user['gmail']); ?></p>
      </div>
      <nav>
        <ul>
          <li><a href="user_detail.php?id=<?php echo $id_user; ?>"><i class="far fa-user"></i> Profile</a></li>
          <li><a href="user_riwayatR.php?id_user=<?php echo $userId; ?>"><i class="far fa-file-alt"></i> Reservation History</a></li>
          <li><a href="userEvent_manage.php?id_user=<?php echo $userId; ?>&page=1"><i class="fas fa-calendar-alt"></i> Events</a></li>
        </ul>
      </nav>
    </div>

    <div class="content">
      <div class="profile-details">
        <h2>Profile</h2>
        <form id="profileForm" action="../php/update_profile.php" method="POST">

          <label for="name">Nama</label>
          <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" disabled/>

          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['gmail']); ?>" disabled/>

          <label for="gender">Jenis Kelamin</label>
          <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" disabled/>
          
          <label for="phone">Nomor Telepon</label>
          <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['nomorhp']); ?>" disabled/>

          <label for="address">Alamat</label>
          <textarea id="address" name="address" rows="4" disabled><?php echo htmlspecialchars($user['alamat']); ?></textarea>
          
          <div class="button-group">
            <button type="button" id="editBtn" class="edit-btn" onclick="deleteAccount(<?php echo $userId; ?>)">Delete Account</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php require_once '../php/footer.php'; ?>
<script>
function deleteAccount(userId) {
  if (confirm('Are you sure you want to delete this account?')) {
    window.location.href = '../php/delete_user.php?id=' + userId;
  }
}
</script>

</body>
</html>
