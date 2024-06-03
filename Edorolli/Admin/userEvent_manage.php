<?php
session_start();

if (!isset($_SESSION['email_admin'])) {
  header("Location: http://localhost/Project-Web/Edorolli/Admin/login_admin.php");
  exit();
}

require_once '../php/functions.php';
$conn = connectDatabase();

$user_id = isset($_GET['id_user']) ? (int)$_GET['id_user'] : null;
if ($user_id === null) {
  echo "User ID not specified.";
  exit();
}

// Ambil data pengguna dari database
$sql_user = "SELECT name, gmail FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

// Pastikan pengguna ditemukan
if (!$user) {
  echo "User not found.";
  exit();
}

// Simpan data pengguna dalam sesi jika belum ada
if (!isset($_SESSION['name'])) {
  $_SESSION['name'] = $user['name'];
}
if (!isset($_SESSION['gmail'])) {
  $_SESSION['gmail'] = $user['gmail'];
}

$events_per_page = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $events_per_page;

// Ambil jumlah total proposal acara untuk pengguna
$sql_count = "SELECT COUNT(*) AS total 
              FROM (
                  SELECT DISTINCT e.id_event
                  FROM booking b
                  JOIN venue v ON b.id_venue = v.id_venue
                  JOIN event e ON b.user_id = e.id_user
                  WHERE b.status = 'confirmed' AND e.status = 'waiting' AND e.id_user = ?
              ) AS subquery";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $user_id);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total_events = $result_count->fetch_assoc()['total'];

// Ambil proposal acara untuk halaman saat ini
$sql = "SELECT e.id_event, e.nama_event, v.nama_venue, MIN(b.start_date) AS start_date, MAX(b.end_date) AS end_date, e.status
        FROM booking b
        JOIN venue v ON b.id_venue = v.id_venue
        JOIN event e ON b.user_id = e.id_user
        WHERE b.status = 'confirmed' AND e.status = 'waiting' AND e.id_user = ?
        GROUP BY e.id_event, e.nama_event, v.nama_venue, e.status
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $events_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edoroli - Manage Events</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <link rel="stylesheet" href="../css/userEvent_manage.css" />
  <link rel="stylesheet" href="../css/footer.css" />
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
    <a href="user_manage.php?page=1" class="nav-item active" id="user">Manage User</a>
    <a href="prov_manage.php?page=1" class="nav-item" id="provider">Manage Provider</a>
    <a href="content_manage.php" class="nav-item" id="content">Manage Content</a>
  </div>
</nav>

<main>
  <div class="container">
    <div class="sidebar">
      <div class="profile-info">
        <img src="../image/MLBB.jpg" alt="Profile Picture" />
        <h3><?php echo htmlspecialchars($user['name']); ?></h3>
        <p><?php echo htmlspecialchars($user['gmail']); ?></p>
      </div>
      <nav>
        <ul>
          <li><a href="user_detail.php?id=<?php echo $user_id; ?>"><i class="far fa-user"></i> Profile</a></li>
          <li><a href="user_riwayatR.php?id_user=<?php echo $user_id; ?>"><i class="far fa-file-alt"></i> Reservation History</a></li>
          <li class="active"><a href="userEvent_manage.php?id_user=<?php echo $user_id; ?>&page=1"><i class="fas fa-calendar-alt"></i> Events</a></li>
        </ul>
      </nav>
    </div>
    <div class="content">
      <div class="events-proposal">
        <h2 class="EP">Events Proposal</h2>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<div class="event-card">';
            echo '<div class="event-details">';
            echo '<h3>' . htmlspecialchars($row['nama_venue']) . '</h3>';
            echo '<p>Event: ' . htmlspecialchars($row['nama_event']) . '</p>';
            echo '<p>Date: ' . htmlspecialchars($row['start_date']) . ' - ' . htmlspecialchars($row['end_date']) . '</p>';
            echo '</div>';
            echo '<div class="event-status">';
            if ($row['status'] === 'confirmed') {
              echo '<span class="status-success">SUCCESS!!!</span>';
            } elseif ($row['status'] === 'waiting') {
              echo '<form action="../php/approve_event.php" method="POST" style="display:inline-block;">';
              echo '<input type="hidden" name="id_event" value="' . $row['id_event'] . '">';
              echo '<button type="submit" class="approve-btn">Approve Event</button>';
              echo '</form>';
              echo '<form action="../php/decline_event.php" method="POST" style="display:inline-block;">';
              echo '<input type="hidden" name="id_event" value="' . $row['id_event'] . '">';
              echo '<button type="submit" class="decline-btn">Delete Event</button>';
              echo '</form>';
            } else {
              echo '<span class="status-rejected">REJECTED</span>';
            }
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo "No events found.";
        }
        $conn->close();
        ?>
      </div>
      <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="userEvent_manage.php?id_user=<?php echo $user_id; ?>&page=<?php echo $page - 1; ?>" class="pagination-button">Previous</a>
        <?php endif; ?>
        <span class="page-number"><?php echo $page; ?></span>
        <?php if ($page * $events_per_page < $total_events): ?>
            <a href="userEvent_manage.php?id_user=<?php echo $user_id; ?>&page=<?php echo $page + 1; ?>" class="pagination-button">Next</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>
<?php require_once '../php/footer.php'; ?>
</body>
</html>
