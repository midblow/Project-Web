<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../User/login_user.php");
    exit();
}

require_once '../php/functions.php';
$conn = connectDatabase();

// Mengambil ID Venue dari URL
$id_venue = isset($_GET['id_venue']) ? (int)$_GET['id_venue'] : 0;

if ($id_venue <= 0) {
    echo "Invalid venue ID.";
    exit();
}

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data venue dari database berdasarkan ID Venue
$sql = "SELECT * FROM venue WHERE id_venue = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $id_venue);
$stmt->execute();
$result = $stmt->get_result();
$venue = $result->fetch_assoc();

if (!$venue) {
    echo "Venue not found.";
    exit();
}

// Mengambil booking dengan status confirmed untuk id_user yang sedang mengakses
$user_id = $_SESSION['id']; // Assuming user ID is stored in session
$sqlBooking = "SELECT start_date, end_date FROM booking WHERE id_venue = ? AND status = 'confirmed' AND user_id = ?";
$stmtBooking = $conn->prepare($sqlBooking);

if ($stmtBooking === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmtBooking->bind_param("ii", $id_venue, $user_id);
$stmtBooking->execute();
$resultBooking = $stmtBooking->get_result();
$bookings = [];
while ($row = $resultBooking->fetch_assoc()) {
    $bookings[] = $row;
}

error_log("Booking query for id_venue = $id_venue and user_id = $user_id");
error_log("Booking results: " . print_r($bookings, true));

$nicknameArray = explode(' ', $_SESSION['name']);
$nickname = $nicknameArray[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Reservasi Venue Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/venue_book.css">
    <link rel="stylesheet" href="../css/footer.css" />
    <script src="../js/venue_calendar.js"></script>
    <script src="../js/venue_popup.js"></script>
</head>
<body data-venue-id="<?php echo htmlspecialchars($id_venue); ?>">
    <header>
        <div class="wrapper">
            <div class="logo">
                <img src="../image/logo.png" alt="Logo" />
            </div>
            <div class="nama_website">
                <a href="#">Edoroli</a>
            </div>
            <div class="menu">
                <a href="User.php">Hallo <?php echo htmlspecialchars($nickname); ?><i class="far fa-user"></i></a>
            </div>
        </div>
    </header>

    <div class="main-nav">
        <div class="wrapper">
            <a href="home_login.php" class="nav-item" id="all-stay">All Stay</a>
            <a href="venue.php" class="nav-item active" id="venue">Venue</a>
            <a href="events1.html" class="nav-item" id="event">Event</a>
        </div>
    </div>

    <section class="image-card">
        <div class="image-container">
            <img src="<?php echo htmlspecialchars($venue['gambar']); ?>" alt="Image">
            <div class="overlay">
                <h1><?php echo htmlspecialchars(strtoupper($venue['nama_venue'])); ?></h1>
            </div>
        </div>
    </section>

    <div class="content-container">
        <div class="details-container">
            <div class="left-section">
                <div class="header-section">
                    <h2><?php echo htmlspecialchars(strtoupper($venue['nama_venue'])); ?></h2>
                </div>
                <div class="desc-box">
                    <h3>Deskripsi & Fasilitas:</h3>
                    <p><?php echo nl2br(htmlspecialchars($venue['deskripsi_fasilitas'])); ?></p>
                </div>
                <div class="alamat-box">
                    <h3>Alamat:</h3>
                    <p><?php echo htmlspecialchars($venue['alamat']); ?></p>
                </div>
                <div class="kapasitas-harga-container">
                    <div class="kapasitas-box">
                        <h3>Kapasitas:</h3>
                        <p><?php echo number_format($venue['kapasitas'], 0, ',', '.'); ?> Orang</p>
                    </div>
                    <div class="harga-box">
                        <h3>Harga:</h3>
                        <p>Rp <?php echo number_format($venue['harga'], 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="right-section">
                <form id="booking-form">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date">
                    <label for="end_date">End Date</label>
                    <input type="date" id="end_date" name="end_date">
                    <button type="button" class="book-button" id="bookButton" disabled>Book</button>
                    <button type="button" class="whatsapp-button">WhatsApp</button>
                </form>
                  <div class="confirmed-container-wrapper">
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <?php if (isset($booking['start_date']) && isset($booking['end_date'])): ?>
                                <div class="confirmed-container">
                                    <span class="date-label">Tanggal Mulai</span>
                                    <p><?php echo htmlspecialchars($booking['start_date']); ?></p>
                                    <span class="date-label">Tanggal Selesai</span>
                                    <p><?php echo htmlspecialchars($booking['end_date']); ?></p>
                                    <a href="add_event.php">Buat Event</a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="calendar-wrapper">
        <div class="calendar-container">
            <div class="calendar-navigation">
                <button id="prevMonth">Prev</button>
                <h2 id="calendar-title"></h2>
                <button id="nextMonth">Next</button>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

    <div id="paymentPopup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopup">&times;</span>
            <h2>Pilih Metode Transaksi</h2>
            <div class="dropdown-container">
                <div class="dropdown">
                    <button class="dropbtn">
                        Bank <i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content" id="bankMethods"></div>
                </div>
                <div class="dropdown">
                    <button class="dropbtn">
                        Gerai <i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content" id="geraiMethods"></div>
                </div>
                <div class="dropdown">
                    <button class="dropbtn">
                        E-Wallet <i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content" id="ewalletMethods"></div>
                </div>
            </div>
            <button id="pilihButton" class="confirm-payment">Pilih</button>
        </div>
    </div>
    <?php require_once '../php/footer.php'; ?>
</body>
</html>
