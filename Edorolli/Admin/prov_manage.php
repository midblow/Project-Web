<?php
session_start();

if (!isset($_SESSION['email_admin'])) {
  header("Location: http://localhost/Project-Web/Edorolli/Admin/login_admin.php");
  exit();
}


require_once '../php/functions.php';
$conn = connectDatabase();

// Set the number of users per page
$provider_per_page = 16; // Updated to 16 users per page

// Get the current page number from the query string, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($page - 1) * $provider_per_page;

// Fetch the total number of users
$sql_count = "SELECT COUNT(*) AS total FROM provider";
$result_count = $conn->query($sql_count);
$total_provider = $result_count->fetch_assoc()['total'];

// Fetch the users for the current page
$sql = "SELECT id_provider, gmail, username, lembaga FROM provider LIMIT $provider_per_page OFFSET $offset"; 
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edoroli - Manage Users</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../css/user_manage.css" />
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
        <a href="user_manage.php?page=1" class="nav-item" id="user">Manage User</a>
        <a href="prov_manage.php?page=1" class="nav-item active" id="provider">Manage Provider</a>
        <a href="content_manage.php" class="nav-item" id="content">Manage Content</a>
    </div>
</nav>

<main>
    <div class="user-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="user-card">';
                echo '<div class="user-card-content">';
                echo '<p><strong>ID Provider: </strong>' . $row["id_provider"] . '</p>';
                echo '<p><strong>Corporation: </strong>' . $row["lembaga"] . '</p>';
                echo '<p><strong>Email: </strong>' . $row["gmail"] . '</p>';
                echo '</div>';
                echo '<a href="prov_detail.php?id=' . $row["id_provider"] . '" class="detail-btn">Detail</a>';
                echo '</div>';
            }
        } else {
            echo "No users found.";
        }
        $conn->close();
        ?>
    </div>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="prov_manage.php?page=<?php echo $page - 1; ?>" class="pagination-button">Previous</a>
        <?php endif; ?>
        <span class="page-number"><?php echo $page; ?></span>
        <?php if ($page * $provider_per_page < $total_provider): ?>
            <a href="prov_manage.php?page=<?php echo $page + 1; ?>" class="pagination-button">Next</a>
        <?php endif; ?>
    </div>
</main>
<?php require_once '../php/footer.php'; ?>
</body>
</html>
