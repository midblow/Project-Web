<?php
session_start();

if (!isset($_SESSION['email_admin'])) {
    header("Location: http://localhost/Project-Web/Edorolli/Admin/login_admin.php");
    exit();
}

require_once '../php/functions.php';
$conn = connectDatabase();

$id_provider = isset($_GET['id']) ? intval($_GET['id']) : 0;
$limit = 10; // Number of records per page

// Fetch provider details based on id_provider
$userName = 'Guest';
$userGmail = '';

if ($id_provider > 0) {
    $providerSql = "SELECT username, gmail FROM provider WHERE id_provider = ?";
    if ($stmt = $conn->prepare($providerSql)) {
        $stmt->bind_param('i', $id_provider);
        $stmt->execute();
        $providerResult = $stmt->get_result();

        if ($providerResult->num_rows > 0) {
            $provider = $providerResult->fetch_assoc();
            $userName = $provider['username'];
            $userGmail = $provider['gmail'];
        }
        $stmt->close();
    }
}

// Serve JSON data if requested
if (isset($_GET['action']) && $_GET['action'] == 'load_more') {
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $sql = "SELECT v.nama_venue AS venue_name, u.id AS id_user, u.gmail AS email_user, b.start_date, b.end_date
            FROM booking b
            INNER JOIN venue v ON b.id_venue = v.id_venue
            INNER JOIN provider p ON v.id_provider = p.id_provider
            INNER JOIN user u ON b.user_id = u.id
            WHERE p.id_provider = ? AND b.status = 'confirmed'
            LIMIT ?, ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('iii', $id_provider, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservations = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reservations[] = $row;
            }
        }
        echo json_encode($reservations);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edoroli - Reservasi Venue Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../css/user_riwayatR.css" />
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
        <a href="content_venue.php" class="nav-item" id="content">Manage Content</a>
    </div>
</nav>

<main>
    <div class="container">
        <div class="sidebar">
            <div class="profile-info">
                <img src="../image/MLBB.jpg" alt="Profile Picture" />
                <h3><?php echo htmlspecialchars($userName); ?></h3>
                <p><?php echo htmlspecialchars($userGmail); ?></p>
            </div>
            <nav>
                <ul>
                    <li><a href="prov_detail.php?id=<?php echo $id_provider; ?>"><i class="far fa-user"></i> Profile</a></li>
                    <li class="active"><a href="#"><i class="far fa-file-alt"></i> Riwayat Reservasi</a></li>
                    <li><a href="prov_venue.php?id=<?php echo $id_provider; ?>"><i class="fas fa-building"></i> Venue</a></li>
                </ul>
            </nav>
        </div>
        <div class="riwayat-reservasi">
            <h2>Riwayat Reservasi</h2>
            <div id="reservation-history" style="height: 400px; overflow-y: scroll;">
                <!-- Reservation history will be loaded here dynamically -->
            </div>
        </div>
    </div>
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
let offset = 0;
const limit = <?php echo $limit; ?>;
const idProvider = <?php echo $id_provider; ?>;

function loadMoreReservations() {
    fetch(`?action=load_more&id=${idProvider}&offset=${offset}&limit=${limit}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const container = document.getElementById('reservation-history');
                data.forEach(reservation => {
                    const card = document.createElement('div');
                    card.className = 'card';

                    const cardHeader = document.createElement('div');
                    cardHeader.className = 'card-header';
                    cardHeader.innerHTML = `<h3>${reservation.venue_name}</h3><p>${reservation.start_date} - ${reservation.end_date}</p>`;
                    card.appendChild(cardHeader);

                    const cardBody = document.createElement('div');
                    cardBody.className = 'card-body';
                    cardBody.innerHTML = `<p>ID User: ${reservation.id_user}</p><p>Email User: ${reservation.email_user}</p>`;
                    card.appendChild(cardBody);

                    const cardFooter = document.createElement('div');
                    cardFooter.className = 'card-footer';
                    cardFooter.innerHTML = `<a href='invoice.php?id_provider=${reservation.id_user}&id_invoice=${reservation.id_invoice}' class='btn btn-primary'>See Invoice</a>`;
                    card.appendChild(cardFooter);

                    container.appendChild(card);
                });
                offset += limit;
            } else {
                container.removeEventListener('scroll', handleScroll);
            }
        });
}

function handleScroll() {
    const container = document.getElementById('reservation-history');
    if (container.scrollTop + container.clientHeight >= container.scrollHeight - 100) {
        loadMoreReservations();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('reservation-history');
    container.addEventListener('scroll', handleScroll);
    loadMoreReservations(); // Initial load
});
</script>
</body>
</html>
