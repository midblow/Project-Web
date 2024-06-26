<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edoroli - About Us</title>
    <link rel="stylesheet" href="../Edorolli/css/about.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
</head>
<body>
    <?php
    session_start();
    include('../Edorolli/php/functions.php'); // Make sure to include your database connection

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $is_valid_user = false;

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $query = "SELECT id FROM user WHERE id = $user_id AND gmail = '{$_SESSION['email']}' AND name = '{$_SESSION['name']}' AND nomorhp = '{$_SESSION['nomorhp']}'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $is_valid_user = true;
            }
        }

        if (isset($_SESSION['provider_id'])) {
            $provider_id = $_SESSION['provider_id'];
            $query = "SELECT id_provider FROM provider WHERE id_provider = $provider_id AND gmail = '{$_SESSION['email']}' AND username = '{$_SESSION['name']}' AND nomorhp = '{$_SESSION['nomorhp']}'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $is_valid_user = true;
            }
        }

        if (!$is_valid_user) {
            echo "<script>alert('Anda harus memiliki akun untuk mengisi formulir ini.');</script>";
            echo "<script>window.location.href='login.php';</script>";
            exit;
        }
    }
    ?>
    <nav>
        <div class="wrapper">
            <div class="logo">
                <img src="../Edorolli/image/logo.png" alt="Edoroli Logo" />
            </div>
            <div class="nama_website">
                <a>Edoroli</a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="role-selection.html" class="login">Get Started</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        <section id="about">
            <h1>About Us</h1>
            <p>We're here to help you find your venue and event since 2024.</p>
            <div class="about-cards">
                <div class="about-card">
                    <h2>Our Story</h2>
                    <p>
                        Kisah Edoroli dimulai dari satu ide sederhana: Menghadirkan
                        kebahagiaan dalam perencanaan acara. Kami tahu bahwa mencari
                        tempat yang sempurna atau mengatur acara bisa sangat melelahkan.
                        Oleh karena itu, kami memutuskan untuk mengubah cara orang
                        merayakan. Dengan inovasi, kerja keras, dan hasrat untuk merayakan
                        kehidupan, kami membangun Edoroli sebagai sarana yang memudahkan
                        dan memperkaya pengalaman perayaan. Kami bangga menjadi bagian
                        dari setiap momen istimewa dalam hidup Anda.
                    </p>
                    <p>
                        Kami memahami bahwa momen yang istimewa tercipta melalui
                        pertemuan, perayaan, dan kebahagiaan bersama. Dengan tekad dan
                        kerja keras, kami membangun Edoroli sebagai wadah bagi semua yang
                        mencari tempat untuk merayakan, berbagi, dan menghadirkan
                        kebahagiaan dalam hidup mereka. Setiap acara adalah cerita, dan
                        kami berkomitmen untuk menjadikan setiap cerita itu luar biasa.
                    </p>
                </div>
                <div class="about-card">
                    <h2>Our Vision</h2>
                    <p>
                        Di Edoroli, kami memiliki visi besar untuk mengubah bagaimana
                        orang merayakan dan berbagai momen berharga dalam hidup mereka.
                        Kami berinovasi untuk menciptakan platform yang memungkinkan
                        setiap orang menemukan dan merencanakan pengalaman tak terlupakan
                        dengan mudah. Visi kami adalah menjadi pilihan pertama bagi setiap
                        perayaan, dari pernikahan yang romantis hingga acara olahraga yang
                        seru, dan membantu setiap orang menjadikan setiap momen berharga
                        itu istimewa.
                    </p>
                    <p>
                        Di Edoroli, kami berkomitmen untuk memberikan yang terbaik untuk
                        Anda. Kami berusaha untuk terus berinovasi, memberikan kenyamanan,
                        dan menyediakan akses mudah ke tempat-tempat yang menakjubkan.
                        Kami ingin memastikan bahwa setiap acara yang Anda rencanakan
                        dengan kami adalah sukses besar, penuh kebahagiaan, dan tak
                        terlupakan. Karena kami percaya bahwa setiap momen adalah alasan
                        untuk merayakan, dan kami hadir untuk membuat perayaan Anda lebih
                        istimewa.
                    </p>
                </div>
            </div>

            <h2>Our Team Edoroli</h2>
            <div class="team">
                <div class="team-member">
                    <img src="../Edorolli/image/Alfin.jpeg" alt="Nama" />
                    <h3>M. Alfin Nashirul Haq</h3>
                    <p>Programmer</p>
                </div>
                <div class="team-member">
                    <img src="../Edorolli/image/Erwin.jpeg" alt="Nama" />
                    <h3>Muhamad Erwin Hariadinata</h3>
                    <p>Programmer</p>
                </div>
                <div class="team-member">
                    <img src="../Edorolli/image/Bram.jpeg" alt="Nama" />
                    <h3>Ida Bagus Brahmanta</h3>
                    <p>Programmer</p>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <img src="../Edorolli/image/logo.png" alt="Edoroli Logo" />
                <div class="nama_website">
                    <a>Edoroli</a>
                </div>
            </div>
            <div class="footer-center">
                <h3>TENTANG EDOROLI</h3>
                <p>
                    Edoroli adalah portal reservasi veneu pertama di Indonesia, yang
                    menyediakan akses informasi yang lengkap dan sistem yang mudah,
                    cepat, dan efisien.
                </p>
            </div>
            <div class="footer-right">
                <h3>SOSIAL MEDIA</h3>
                <ul>
                    <li>
                        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                    </li>
                    <li>
                        <a href="#"><i class="fab fa-whatsapp"></i> Whatsapp</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 Edoroli Co., Ltd. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
