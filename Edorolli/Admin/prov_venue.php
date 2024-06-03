<?php
session_start();

if (!isset($_SESSION['email_admin'])) {
    header("Location: http://localhost/Project-Web/Edorolli/Admin/login_admin.php");
    exit();
}

require_once '../php/functions.php';
$conn = connectDatabase();

$provider_id = isset($_GET['id_provider']) ? (int)$_GET['id_provider'] : null;
if ($provider_id === null) {
    echo "Provider ID not specified.";
    exit();
}

// Ambil data provider dari database
$sql_provider = "SELECT * FROM provider WHERE id_provider = ?";
$stmt_provider = $conn->prepare($sql_provider);
$stmt_provider->bind_param("i", $provider_id);
$stmt_provider->execute();
$result_provider = $stmt_provider->get_result();
$provider = $result_provider->fetch_assoc();

if (!$provider) {
    echo "Provider not found.";
    exit();
}

// Ambil data venue dari database
$sql_venue = "SELECT * FROM venue WHERE id_provider = ?";
$stmt_venue = $conn->prepare($sql_venue);
$stmt_venue->bind_param("i", $provider_id);
$stmt_venue->execute();
$result_venue = $stmt_venue->get_result();
$venues = $result_venue->fetch_all(MYSQLI_ASSOC);

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Provider</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header>
    <div class="wrapper">
        <div class="logo-nama">
            <div class="logo"><img src="../image/logo.png" alt="Logo"></div>
            <div class="nama_website"><a href="#">Edoroli</a></div>
        </div>
        <div class="menu">
            <a href="user_manage.php?page=1">Hallo 
            <?php echo htmlspecialchars($_SESSION['username']); ?>
            <i class="far fa-user"></i></a>
        </div>
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
    <div class="container">
        <div class="sidebar">
            <div class="profile-info">
                <img src="../image/profile.jpg" alt="Profile Picture" />
                <h3><?php echo htmlspecialchars($provider['username']); ?></h3>
                <p><?php echo htmlspecialchars($provider['gmail']); ?></p>
            </div>
            <nav>
                <ul>
                    <li><a href="prov_detail.php?id_provider=<?php echo $provider_id; ?>"><i class="far fa-user"></i> Profile</a></li>
                    <li><a href="prov_booking.php?id_provider=<?php echo $provider_id; ?>"><i class="far fa-file-alt"></i> Riwayat Booking</a></li>
                    <li><a href="prov_venue.php?id_provider=<?php echo $provider_id; ?>"><i class="fas fa-building"></i> Venue</a></li>
                </ul>
            </nav>
        </div>
        <div class="content">
            <div class="main-venue">
                <h2>Make as Main Venue</h2>
                <?php foreach ($venues as $venue): ?>
                    <div class="venue-item">
                        <span><?php echo htmlspecialchars($venue['nama_venue']); ?></span>
                        <?php if ($venue['main_venue']): ?>
                            <button class="success">Success</button>
                        <?php else: ?>
                            <form action="set_main_venue.php" method="POST">
                                <input type="hidden" name="venue_id" value="<?php echo $venue['id_venue']; ?>">
                                <input type="hidden" name="provider_id" value="<?php echo $provider_id; ?>">
                                <button type="submit" class="accept-btn">Accept</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<?php require_once '../php/footer.php'; ?>
</body>
</html>
