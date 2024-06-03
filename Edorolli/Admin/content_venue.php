    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/Project-Web/Edorolli/login_user.php");
    exit();
    }

    include '../php/functions.php';
    $conn = connectDatabase();

    // Fetch user event data from the database
    $sql = "SELECT provider.id_provider, provider.gmail, venue.nama_venue 
            FROM venue 
            INNER JOIN provider ON venue.id_provider = provider.id_provider";
    $result = $conn->query($sql);

    if (!$result) {
    die("Query failed: " . $conn->error);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edoroli - Manage Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../css/manage_content.css" />
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
        <a href="prov_manage.php?page=1" class="nav-item" id="provider">Manage Provider</a>
        <a href="content_venue.php" class="nav-item active" id="content">Manage Content</a>
    </div>
</nav>

    <main>
    <div class="container">
        <div class="sidebar">
        <div class="profile-info">
            <img src="../image/MLBB.jpg" alt="Profile Picture" />
            <h3>Admin</h3>
            <p>anonymous@gmail.com</p>
        </div>
        <nav>
            <ul>
            <li class="active"><a href="content_venue.php"><i class="far fa-user"></i> Rekomendasi Venue</a></li>
            <li><a href="content_event.php"><i class="far fa-file-alt"></i> Rekomendasi Event</a></li>
            </ul>
        </nav>
        </div>
        <div class="content">
        <table>
            <thead>
            <tr>
                <th>ID Provider</th>
                <th>Email</th>
                <th>List Venue</th>
                <th>Rekomendasikan</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_provider']}</td>";
                echo "<td>{$row['gmail']}</td>";
                echo "<td>{$row['nama_venue']}</td>";
                echo "<td><input type='checkbox' /></td>";
                echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No events found</td></tr>";
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
    </main>
    <?php require_once '../php/footer.php'; ?>

    </body>
    </html>
