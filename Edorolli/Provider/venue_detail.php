<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: http://localhost/Project-Web/Edorolli/Provider/prov_login.php");
    exit();
} else {
    if (!isset($_GET['id_venue'])) {
        echo "No venue ID provided.";
        exit();
    }

    $id_venue = $_GET['id_venue'];

    // Fetch the venue details using id_venue
    $sql = "SELECT * FROM venue WHERE id_venue = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_venue);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the venue details
        $venue = $result->fetch_assoc();
    } else {
        echo "No venue found with this ID.";
        exit();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Detail Venue</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/venue_detail.css">
    <link rel="stylesheet" href="../css/footer.css" />
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo-nama">
                <div class="logo"><img src="../image/logo.png" alt="Logo"></div>
                <div class="nama_website"><a href="../index.html">Edoroli</a></div>
            </div>
            <div class="menu"><a href="Provider.php">Hallo <?php echo $_SESSION['username']; ?><i class="far fa-user"></i></a></div>
        </div>
    </header>
    <main>
    <section class="main-title">
            <nav>
                <a href="home_prov.php" class="nav-item" id="all-stay">All Stay</a>
                <a href="venue_prov.php?id_provider=<?php echo $id_provider; ?>&page=1" class="nav-item active" id="venue">My Venue</a>
                <a href="booking_confirmation.php" class="nav-item" id="booking">Booking Confirmation</a>
            </nav>
        </section>
        <section class="venue">
            <div class="venue-container">
                <div class="venue-image-container">
                    <img src="<?php echo $venue['gambar']; ?>" alt="Venue Image">
                </div>
                <div class="venue-form">
                    <form action="../php/edit_venue.php" method="post" id="venue-form" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <input type="hidden" id="venue_id" name="venue_id" value="<?php echo $venue['id_venue']; ?>">
                        <label for="name_venue">Nama Venue</label>
                        <input type="text" id="name_venue" name="name_venue" value="<?php echo $venue['nama_venue']; ?>" required disabled>
                        
                        <label for="deskripsi_fasilitas">Deskripsi dan Fasilitas</label>
                        <textarea id="deskripsi_fasilitas" name="deskripsi_fasilitas" rows="4" required disabled><?php echo $venue['deskripsi_fasilitas']; ?></textarea>
                        
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" value="<?php echo $venue['alamat']; ?>" required disabled>
                        
                        <label for="kota">Kota</label>
                        <input type="text" id="kota" name="kota" value="<?php echo $venue['kota']; ?>" required disabled>
                        
                        <label for="penanggung_jawab">Nama Penanggung Jawab</label>
                        <input type="text" id="penanggung_jawab" name="penanggung_jawab" value="<?php echo $venue['penanggung_jawab']; ?>" required disabled>
                        
                        <div class="kapasitas-harga">
                            <div class="input-group">
                                <label for="kapasitas">Kapasitas</label>
                                <input type="text" id="kapasitas" name="kapasitas" value="<?php echo $venue['kapasitas']; ?>" required inputmode="numeric" disabled>
                            </div>
                            <div class="input-group">
                                <label for="harga">Harga Rp.</label>
                                <input type="text" id="harga" name="harga" value="<?php echo $venue['harga']; ?>" required inputmode="numeric" disabled>
                            </div>
                        </div>
                        <div class="image-upload-container">
                            <label for="file">
                                <img src="<?php echo $venue['gambar']; ?>" id="preview-image" alt="Upload Preview">
                                <p>+ Tambah Foto</p>
                            </label>
                            <input type="file" name="file" id="file" accept="image/*" onchange="previewImage(event)" disabled>
                        </div>
                        <div class="radio-container">
                            <div>
                                <input type="radio" id="pemerintah" name="jenis_instansi" value="Pemerintah" <?php echo ($venue['jenis_instansi'] == 'Pemerintah') ? 'checked' : ''; ?> disabled required>
                                <label for="pemerintah">Pemerintah</label>
                            </div>
                            <div>
                                <input type="radio" id="swasta" name="jenis_instansi" value="Swasta" <?php echo ($venue['jenis_instansi'] == 'Swasta') ? 'checked' : ''; ?> disabled required>
                                <label for="swasta">Swasta</label>
                            </div>
                        </div>
                        <div class="main-venue-container">
                            <input type="checkbox" id="main_venue" name="main_venue" value="1" disabled>
                            <label for="main_venue">Ajukan Sebagai Main Venue</label>
                        </div>
                        <div class="action-buttons">
                            <button type="button" class="delete-button" onclick="deleteVenue()">Delete Venue</button>
                            <button type="button" class="edit-button" onclick="enableEditing()">Edit</button>
                        </div>
                        <div class="save-cancel-buttons" style="display: none;">
                            <button type="button" class="cancel-button" onclick="cancelEditing()">Batal</button>
                            <button type="submit" class="save-button">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php require_once '../php/footer.php'; ?>
    <script src="../js/venue_detail_edit.js"></script>
    <script src="../js/iconHomepage.js"></script>
</body>
</html>
