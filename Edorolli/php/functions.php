<?php
function start_session_if_not_started() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function Logged() {
    start_session_if_not_started();
    if (!isset($_SESSION['username']) || !isset($_SESSION['name'])) {
        header("Location: http://localhost/Project-Web/Edorolli/role-selection.html");
        exit();
    }
}

function connectDatabase() {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'project_pweb';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    return $conn;
}

function registrasi($data) {
    global $conn;

    // Sanitize and validate input data
    $email = filter_var($data["gmail"], FILTER_SANITIZE_EMAIL);
    $name = strtolower(trim($data["name"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $gender = $data["gender"];
    $phone = filter_var($data["phone"], FILTER_SANITIZE_NUMBER_INT);
    $address = mysqli_real_escape_string($conn, $data["address"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Email tidak valid!';
        header("Location: http://localhost/Project-Web/Edorolli/signup.php");
        exit();
    }

    // Check email
    $result = mysqli_query($conn, "SELECT gmail FROM user WHERE gmail = '$email'");
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['error_message'] = 'Email sudah tersedia, gunakan email yang lain!';
        header("Location: http://localhost/Project-Web/Edorolli/signup.php");
        exit();
    }

    // Hash the password
    // $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Add user
    $query = "INSERT INTO user (gmail, name, password, gender, nomorhp, alamat) VALUES('$email', '$name', '$password', '$gender', '$phone', '$address')";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}

function regProv($data) {
    global $conn;

    // Sanitize and validate input data
    $email = filter_var($data["gmail"], FILTER_SANITIZE_EMAIL);
    $username = strtolower(trim($data["username"]));
    $lembaga = mysqli_real_escape_string($conn, $data["lembaga"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $phone = filter_var($data["nomorhp"], FILTER_SANITIZE_NUMBER_INT);
    $address = mysqli_real_escape_string($conn, $data["alamat"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Email tidak valid!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }

    // Check email
    $result = mysqli_query($conn, "SELECT gmail FROM provider WHERE gmail = '$email'");
    if (mysqli_fetch_assoc($result)) {
        $_SESSION['error_message'] = 'Email sudah tersedia, gunakan email yang lain!';
        header("Location: ../Provider/prov_sign.php");
        exit();
    }

    // Hash the password
    // $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Add user (without hashing)
    $query = "INSERT INTO provider (gmail, username, lembaga, password, nomorhp, alamat) VALUES('$email', '$username', '$lembaga', '$password', '$phone', '$address')";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}


function generate_pagination_files($id_provider, $total_pages, $items_per_page, $conn) {
    $directory = '../Provider';
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    for ($i = 2; $i <= $total_pages; $i++) {
        $filename = $directory . "/venue_prov_" . $id_provider . "_" . $i . ".php";
        $file_content = generate_file_content($id_provider, $i, $items_per_page, $total_pages, $conn);
        file_put_contents($filename, $file_content);
    }
}

function generate_file_content($id_provider, $page, $items_per_page, $total_pages, $conn) {
    session_start(); // Start the session to access session variables
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

    // Jumlah item di halaman pertama
    $first_page_items = 8;
    
    // Menghitung offset berdasarkan halaman saat ini
    if ($page == 2) {
        $offset = $first_page_items;
    } else {
        $offset = $first_page_items + ($page - 2) * $items_per_page;
    }

    $sql = "SELECT * FROM venue WHERE id_provider = ? LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id_provider, $items_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edoroli - Reservasi Venue Online</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/venue_prov.css">
    </head>
    <body>
        <header>
            <div class="wrapper">
                <div class="logo"><img src="../image/logo.png" alt="Logo"></div>
                <div class="nama_website"><a href="#">Edoroli</a></div>
                <div class="menu"><a href="User.php">Hallo <?php echo $_SESSION['username']; ?><i class="far fa-user"></i></a></div>
            </div>
        </header>
        <main>
            <section class="main-title">
                <nav>
                    <a href="../Provider/home_prov.php" class="nav-item" id="all-stay">All Stay</a>
                    <a href="venue_prov_<?php echo $id_provider; ?>_<?php echo $page; ?>.php" class="nav-item active" id="venue">My Venue</a>
                    <a href="events1.html" class="nav-item" id="booking">Booking Confirmation</a>
                </nav>
            </section>
            <section class="venue">
                <div class="gallery">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="card">';
                            echo '    <div class="image-container">';
                            echo '        <a href="venue_detail_' . $row["id_venue"] . '.php">';
                            echo '            <img src="'.$row["gambar"].'" alt="Venue Image">';
                            echo '        </a>';
                            echo '        <span class="heart-icon"><i class="far fa-heart" onclick="klikLike(this)"></i></span>';
                            echo '    </div>';
                            echo '    <div class="info">';
                            echo '        <p class="name">'.$row["nama_venue"].'</p>';
                            echo '        <span class="plus-icon"><i class="far fa-bookmark" onclick="klikBookmark(this)"></i></span>';
                            echo '    </div>';
                            echo '    <div class="location">';
                            echo '        <i class="fa-solid fa-location-dot"></i>';
                            echo '        <span>'.$row["kota"].'</span>';
                            echo '    </div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No venues found.";
                    }
                    ?>
                </div>
                <div class="button-container">
                    <div class="pagination">
                        <?php if($page > 2): ?>
                            <a href="venue_prov_<?php echo $id_provider; ?>_<?php echo $page - 1; ?>.php" class="pagination-button" id="prev-button">Previous</a>
                        <?php elseif($page == 2): ?>
                            <a href="venue_prov_<?php echo $id_provider; ?>_1.php" class="pagination-button" id="prev-button">Previous</a>
                        <?php endif; ?>
                        <span class="page-number"><?php echo $page; ?></span>
                        <?php if($page < $total_pages): ?>
                            <a href="venue_prov_<?php echo $id_provider; ?>_<?php echo $page + 1; ?>.php" class="pagination-button" id="next-button">Next</a>
                        <?php endif; ?>
                    </div>
                    <div class="add-venue">
                        <a href="add_venue_form.php">
                            <button class="card add-venue-btn">
                                <h3>+Add Venue</h3>
                            </button>
                        </a>
                    </div>
                </div>
            </section>
        </main>
        <footer>
            <div class="footer-container">
                <div class="footer-left">
                    <img src="../image/logo.png" alt="Edoroli Logo">
                    <div class="nama_website"><a href="#">Edoroli</a></div>
                </div>
                <div class="footer-center">
                    <h3>TENTANG EDOROLI</h3>
                    <p>Edoroli adalah portal reservasi venue pertama di Indonesia, yang menyediakan akses informasi yang lengkap dan sistem yang mudah, cepat, dan efisien.</p>
                </div>
                <div class="footer-right">
                    <h3>SOSIAL MEDIA</h3>
                    <ul>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fab fa-whatsapp"></i> Whatsapp</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2024 Edoroli Co., Ltd. All Rights Reserved.</p>
            </div>
        </footer>
        <script src="../js/iconHomepage.js"></script>
    </body>
    </html>
    <?php
    return ob_get_clean();
}



function generate_venue_detail_file($venue) {
    $filename = '../Provider/venue_detail_' . $venue['id_venue'] . '.php';
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edoroli - Edit Venue</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../css/venue_detail.css">
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
        <footer>
            <div class="footer-container">
                <div class="footer-left">
                    <img src="../image/logo.png" alt="Edoroli Logo">
                    <div class="nama_website"><a href="#">Edoroli</a></div>
                </div>
                <div class="footer-center">
                    <h3>TENTANG EDOROLI</h3>
                    <p>Edoroli adalah portal reservasi venue pertama di Indonesia, yang menyediakan akses informasi yang lengkap dan sistem yang mudah, cepat, dan efisien.</p>
                </div>
                <div class="footer-right">
                    <h3>SOSIAL MEDIA</h3>
                    <ul>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fab fa-whatsapp"></i> Whatsapp</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2024 Edoroli Co., Ltd. All Rights Reserved.</p>
            </div>
        </footer>
        <script src="../js/venue_detail_edit.js"></script>
        <script src="../js/iconHomepage.js"></script>
    </body>
    </html>
    <?php
    $file_content = ob_get_clean();
    file_put_contents($filename, $file_content);
}

function generate_all_venue_detail_files($conn) {
    $sql = "SELECT * FROM venue";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            generate_venue_detail_file($row);
        }
    }
}

function resize_and_crop_image($source_image_path, $output_image_path, $output_width, $output_height) {
    list($original_width, $original_height, $image_type) = getimagesize($source_image_path);
    
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $source_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_image = imagecreatefrompng($source_image_path);
            break;
        case IMAGETYPE_GIF:
            $source_image = imagecreatefromgif($source_image_path);
            break;
        default:
            return false;
    }
    
    $aspect_ratio = $original_width / $original_height;
    $output_aspect_ratio = $output_width / $output_height;

    if ($aspect_ratio > $output_aspect_ratio) {
        $new_height = $output_height;
        $new_width = intval($output_height * $aspect_ratio);
    } else {
        $new_width = $output_width;
        $new_height = intval($output_width / $aspect_ratio);
    }

    $output_image = imagecreatetruecolor($output_width, $output_height);
    
    imagecopyresampled($output_image, $source_image, 
        0 - ($new_width - $output_width) / 2,
        0 - ($new_height - $output_height) / 2,
        0, 0,
        $new_width, $new_height,
        $original_width, $original_height);
    
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            imagejpeg($output_image, $output_image_path, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($output_image, $output_image_path);
            break;
        case IMAGETYPE_GIF:
            imagegif($output_image, $output_image_path);
            break;
    }
    
    imagedestroy($source_image);
    imagedestroy($output_image);
    
    return $output_image_path;
}
?>
