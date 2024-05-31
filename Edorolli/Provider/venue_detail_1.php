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
                <div class="menu"><a href="Provider.php">Hallo rewindd<i class="far fa-user"></i></a></div>
            </div>
        </header>
        <main>
            <section class="venue">
                <div class="venue-container">
                    <div class="venue-image-container">
                        <img src="" alt="Venue Image">
                    </div>
                    <div class="venue-form">
                        <form action="../php/edit_venue.php" method="post" id="venue-form" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <input type="hidden" id="venue_id" name="venue_id" value="1">
                            <label for="name_venue">Nama Venue</label>
                            <input type="text" id="name_venue" name="name_venue" value="Oke" required disabled>
                            
                            <label for="deskripsi_fasilitas">Deskripsi dan Fasilitas</label>
                            <textarea id="deskripsi_fasilitas" name="deskripsi_fasilitas" rows="4" required disabled>Banyak
Kok
Bagus
Lebih
oke
sekali</textarea>
                            
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" value="Jl. Kuranji, Gusbram" required disabled>
                            
                            <label for="kota">Kota</label>
                            <input type="text" id="kota" name="kota" value="Mataram" required disabled>
                            
                            <label for="penanggung_jawab">Nama Penanggung Jawab</label>
                            <input type="text" id="penanggung_jawab" name="penanggung_jawab" value="also " required disabled>
                            
                            <div class="kapasitas-harga">
                                <div class="input-group">
                                    <label for="kapasitas">Kapasitas</label>
                                    <input type="text" id="kapasitas" name="kapasitas" value="10000" required inputmode="numeric" disabled>
                                </div>
                                <div class="input-group">
                                    <label for="harga">Harga Rp.</label>
                                    <input type="text" id="harga" name="harga" value="1000000" required inputmode="numeric" disabled>
                                </div>
                            </div>
                            <div class="image-upload-container">
                                <label for="file">
                                    <img src="" id="preview-image" alt="Upload Preview">
                                    <p>+ Tambah Foto</p>
                                </label>
                                <input type="file" name="file" id="file" accept="image/*" onchange="previewImage(event)" disabled>
                            </div>
                            <div class="radio-container">
                                <div>
                                    <input type="radio" id="pemerintah" name="jenis_instansi" value="Pemerintah" checked disabled required>
                                    <label for="pemerintah">Pemerintah</label>
                                </div>
                                <div>
                                    <input type="radio" id="swasta" name="jenis_instansi" value="Swasta"  disabled required>
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

                // Update form values with cleaned numbers
                document.getElementById('kapasitas').value = kapasitas;
                document.getElementById('harga').value = harga;

                return true;
            }

            function enableEditing() {
                var elements = document.querySelectorAll('#venue-form input, #venue-form textarea, #venue-form input[type="file"]');
                elements.forEach(function(element) {
                    element.disabled = false;
                });
                document.querySelector('.save-cancel-buttons').style.display = 'flex';
                document.querySelector('.action-buttons').style.display = 'none';
            }

            function cancelEditing() {
                var elements = document.querySelectorAll('#venue-form input, #venue-form textarea, #venue-form input[type="file"]');
                elements.forEach(function(element) {
                    element.disabled = true;
                });
                document.querySelector('.save-cancel-buttons').style.display = 'none';
                document.querySelector('.action-buttons').style.display = 'flex';
            }

            function deleteVenue() {
                if (confirm("Are you sure you want to delete this venue?")) {
                    var venueId = document.getElementById('venue_id').value;
                    window.location.href = "../php/delete_venue.php?id=" + venueId;
                }
            }
        </script>
        <script src="../js/iconHomepage.js"></script>
    </body>
    </html>
    