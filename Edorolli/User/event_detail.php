<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

if (!isset($_SESSION['id'])) {
    header("Location: ../User/login_user.php");
    exit();
}

// Mengambil ID Event dan ID Venue dari URL
$id_event = isset($_GET['id_event']) ? (int)$_GET['id_event'] : 0;
$id_venue = isset($_GET['id_venue']) ? (int)$_GET['id_venue'] : 0;

// Inisialisasi variabel event, venue, dan booking
$event = null;
$venue = null;
$booking = null;

// Mengambil data event dan booking dari database
if ($id_event == 0) {
    // Inisialisasi nilai default untuk event baru
    $event = [
        'id_venue' => $id_venue,
        'gambar' => '../image/map.jpg',
        'nama_event' => '',
        'deskripsi' => '',
        'jenis_event' => '',
        'informasi' => '',
        'rules' => '',
        'rekomendasi' => 0,
        'id_user' => $_SESSION['id']  // Mengaitkan event baru dengan pengguna yang sedang login
    ];

    // Mengambil tanggal event dari tabel booking berdasarkan id_venue
    $sql_booking = "SELECT start_date, end_date FROM booking WHERE id_venue = ? ORDER BY start_date LIMIT 1";
    $stmt_booking = $conn->prepare($sql_booking);
    if ($stmt_booking === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_booking->bind_param("i", $id_venue);
    $stmt_booking->execute();
    $result_booking = $stmt_booking->get_result();
    $booking = $result_booking->fetch_assoc();
} else {
    // Mengambil data event dari database berdasarkan ID Event
    $sql = "SELECT * FROM event WHERE id_event = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $id_event);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();

    if (!$event) {
        echo "Event not found.";
        exit();
    }

    // Mengambil data venue dari tabel venue
    $id_venue = $event['id_venue'];

    // Mengambil tanggal event dari tabel booking berdasarkan id_venue
    $sql_booking = "SELECT start_date, end_date FROM booking WHERE id_venue = ?";
    $stmt_booking = $conn->prepare($sql_booking);
    if ($stmt_booking === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_booking->bind_param("i", $id_venue);
    $stmt_booking->execute();
    $result_booking = $stmt_booking->get_result();
    $booking = $result_booking->fetch_assoc();
}

if ($id_venue > 0) {
    // Mengambil data venue dari database berdasarkan ID Venue
    $sql_venue = "SELECT nama_venue, alamat FROM venue WHERE id_venue = ?";
    $stmt_venue = $conn->prepare($sql_venue);
    if ($stmt_venue === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_venue->bind_param("i", $id_venue);
    $stmt_venue->execute();
    $result_venue = $stmt_venue->get_result();
    $venue = $result_venue->fetch_assoc();
}

$nicknameArray = explode(' ', $_SESSION['name']);
$nickname = $nicknameArray[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Detail Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/event_detail.css">
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo-nama">
                <div class="logo"><img src="../image/logo.png" alt="Logo"></div>
                <div class="nama_website"><a href="../index.html">Edoroli</a></div>
            </div>
            <div class="menu"><a href="User.php">Hallo <?php echo $_SESSION['name']; ?><i class="far fa-user"></i></a></div>
        </div>
    </header>
    <main>
        <form id="event-form" action="../php/save_event.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
            <input type="hidden" name="id_venue" value="<?php echo $id_venue; ?>">
            <section class="event-details">
                <div class="event-image">
                    <img src="<?php echo htmlspecialchars($event['gambar']); ?>" alt="<?php echo htmlspecialchars($event['nama_event']); ?>" id="preview-image">
                </div>
                <div class="event-info">
                    <h1><input type="text" id="nama_event" name="nama_event" value="<?php echo htmlspecialchars($event['nama_event']); ?>" required <?php if ($id_event != 0) echo 'readonly'; ?>>
                </h1>
                    <div class="event-card">
                        <div class="event-description">
                            <h2>Deskripsi</h2>
                            <textarea id="deskripsi" name="deskripsi" rows="6" required <?php if ($id_event != 0) echo 'readonly'; ?>><?php echo htmlspecialchars($event['deskripsi']); ?></textarea>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="event-card">
                <h2>Tanggal Event</h2>
                <?php if ($booking): ?>
                    <p><?php echo htmlspecialchars($booking['start_date']) . " - " . htmlspecialchars($booking['end_date']); ?></p>
                <?php else: ?>
                    <p>Tanggal event tidak tersedia.</p>
                <?php endif; ?>
            </section>

            <section class="event-card">
                <h2>Jenis Event</h2>
                <input type="text" id="jenis_event" name="jenis_event" value="<?php echo htmlspecialchars($event['jenis_event']); ?>" required <?php if ($id_event != 0) echo 'readonly'; ?>>
            </section>

            <section class="event-card">
                <h2>Lokasi</h2>
                <?php if ($venue): ?>
                    <p><?php echo htmlspecialchars($venue['nama_venue']); ?>, <?php echo htmlspecialchars($venue['alamat']); ?></p>
                <?php else: ?>
                    <p>Lokasi tidak tersedia.</p>
                <?php endif; ?>
            </section>

            <section class="event-card">
                <h2>Informasi</h2>
                <textarea id="informasi" name="informasi" rows="8" required <?php if ($id_event != 0) echo 'readonly'; ?>><?php echo htmlspecialchars($event['informasi']); ?></textarea>
            </section>

            <section class="event-card">
                <h2>Rules</h2>
                <textarea id="rules" name="rules" rows="8" required <?php if ($id_event != 0) echo 'readonly'; ?>><?php echo htmlspecialchars($event['rules']); ?></textarea>
            </section>

            <?php if ($event['id_user'] == $_SESSION['id'] || $id_event == 0): ?>
            <section class="event-card">
                <div class="image-upload-container">
                    <label for="file">
                        <img src="<?php echo htmlspecialchars($event['gambar']); ?>" id="preview-image-upload" alt="Upload Preview">
                        <p>+ Tambah Foto</p>
                    </label>
                    <input type="file" name="file" id="file" accept="image/*" onchange="previewImage(event)">
                </div>
                <div class="main-event-container">
                    <input type="checkbox" id="rekomendasi" name="rekomendasi" value="1" <?php echo ($event['rekomendasi'] == 1) ? 'checked' : ''; ?>>
                    <label for="rekomendasi">Ajukan Sebagai Rekomendasi</label>
                </div>
                <div class="action-buttons">
                    <?php if ($id_event > 0): ?>
                        <button type="button" class="delete-button" onclick="deleteEvent(<?php echo $id_event; ?>)">Delete</button>
                        <button type="button" class="edit-button" onclick="enableEditing()">Edit</button>
                        <button type="button" class="cancel-button" onclick="cancelEditing()">Cancel</button>
                        <button type="submit" class="submit-button">Submit</button>
                    <?php else: ?>
                        <button type="submit" class="submit-button">Submit</button>
                    <?php endif; ?>
                </div>
            </section>
            <?php endif; ?>
        </form>
    </main>
    <script src="../js/editEvent.js"></script>
</body>
</html>
