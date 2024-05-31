<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Jika sesi nama tidak diatur, redirect ke halaman login
    header("Location: http://localhost/Project-Web/Edorolli/Provider/prov_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edoroli - Reservasi Venue Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/add_venue.css">
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="logo-nama">
                <div class="logo"><img src="../image/logo.png" alt="Logo"></div>
                <div class="nama_website"><a href="#">Edoroli</a></div>
            </div>
            <div class="menu"><a href="User.php">Hallo <?php echo $_SESSION['username']; ?><i class="far fa-user"></i></a></div>
        </div>
    </header>
    <main>
        <section class="main-title">
            <nav>
                <a href="../Provider/home_prov.php" class="nav-item" id="all-stay">All Stay</a>
                <a href="../Provider/venue_prov1.php" class="nav-item active" id="venue">My Venue</a>
                <a href="events1.html" class="nav-item" id="booking">Booking Confirmation</a>
            </nav>
        </section>
        <section class="venue">
            <div class="venue-container">
                <div class="venue-form">
                    <form action="../php/add_venue.php" method="post" id="venue-form" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <label for="name_venue">Nama Venue</label>
                        <input type="text" id="name_venue" name="name_venue" required>
                        
                        <label for="deskripsi_fasilitas">Deskripsi dan Fasilitas</label>
                        <textarea id="deskripsi_fasilitas" name="deskripsi_fasilitas" rows="4" required></textarea>
                        
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat" required>
                        
                        <label for="kota">Kota</label>
                        <input type="text" id="kota" name="kota" required>
                        
                        <label for="penanggung_jawab">Nama Penanggung Jawab</label>
                        <input type="text" id="penanggung_jawab" name="penanggung_jawab" required>
                        
                        <div class="kapasitas-harga">
                            <div class="input-group">
                                <label for="kapasitas">Kapasitas</label>
                                <input type="text" id="kapasitas" name="kapasitas" required inputmode="numeric">
                            </div>
                            <div class="input-group">
                                <label for="harga">Harga Rp.</label>
                                <input type="text" id="harga" name="harga" required inputmode="numeric">
                            </div>
                        </div>
                        <div class="image-upload-container">
                            <label for="file" class="upload-label">
                                <img src="../image/map.jpg" id="preview-image" alt="Upload Preview">
                                <p>+ Tambah Foto</p>
                            </label>
                            <input type="file" name="file" id="file" accept="image/*" onchange="previewImage(event)" required>
                        </div>
                        <div class="jenis-instansi">
                            <div class="radio-container">
                                <input type="radio" id="pemerintah" name="jenis_instansi" value="Pemerintah" required>
                                <label for="pemerintah">Pemerintah</label>
                                <input type="radio" id="swasta" name="jenis_instansi" value="Swasta" required>
                                <label for="swasta">Swasta</label>
                            </div>
                        </div>
                        <button type="submit" class="submit-button">Submit</button>
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
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview-image');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function validateForm() {
            let kapasitas = document.getElementById('kapasitas').value;
            let harga = document.getElementById('harga').value;
            let pemerintah = document.getElementById('pemerintah').checked;
            let swasta = document.getElementById('swasta').checked;
            let file = document.getElementById('file').files[0];
            
            // Validate kapasitas and harga to be numbers
            kapasitas = kapasitas.replace(/\./g, '');
            harga = harga.replace(/\./g, '');

            if (isNaN(kapasitas) || isNaN(harga)) {
                alert('Kapasitas dan Harga harus berupa angka.');
                return false;
            }

            // Ensure at least one radio button is checked
            if (!pemerintah && !swasta) {
                alert('Pilih salah satu jenis instansi.');
                return false;
            }

            // Ensure an image is uploaded
            if (!file) {
                alert('Unggah gambar venue.');
                return false;
            }

            // Update form values with cleaned numbers
            document.getElementById('kapasitas').value = kapasitas;
            document.getElementById('harga').value = harga;

            return true;
        }
    </script>
</body>
</html>
