<?php
session_start();
require_once '../php/functions.php';
$conn = connectDatabase();

// Get id_user and id_invoice from the URL parameters
$id_user = isset($_GET['id_user']) ? intval($_GET['id_user']) : 0;
$id_invoice = isset($_GET['id_invoice']) ? intval($_GET['id_invoice']) : 0;

// Fetch invoice details using id_invoice from URL parameters
$sql_invoice = "SELECT i.*, b.*, v.nama_venue, v.alamat as venue_address, v.harga, p.gmail as provider_email, p.lembaga, u.name as user_name, u.gmail as user_email, u.nomorhp as user_phone
                FROM invoice i
                JOIN booking b ON i.booking_id = b.id
                JOIN venue v ON b.id_venue = v.id_venue
                JOIN provider p ON v.id_provider = p.id_provider
                JOIN user u ON b.user_id = u.id
                WHERE i.id_invoice = ? AND u.id = ?";
$stmt_invoice = $conn->prepare($sql_invoice);
$stmt_invoice->bind_param("ii", $id_invoice, $id_user);
$stmt_invoice->execute();
$result_invoice = $stmt_invoice->get_result();
$invoice = $result_invoice->fetch_assoc();

if (!$invoice) {
    die("Invoice not found.");
} 

// Calculate totals
$date1 = new DateTime($invoice['start_date']);
$date2 = new DateTime($invoice['end_date']);
$interval = $date1->diff($date2);
$days = $interval->days + 1;

$price_per_day = $invoice['harga'];
$total_price = $price_per_day * $days;
$service_fee = $invoice['service_fee'];
$grand_total = $invoice['total_amount'];

$metode_pembayaran = $invoice['payment_method'];
if (in_array($metode_pembayaran, ['bri', 'bca', 'mandiri', 'bni'])) {
    $metode = 'Bank';
    $nama_metode = strtoupper($metode_pembayaran);
} elseif (in_array($metode_pembayaran, ['alfamart', 'indomart'])) {
    $metode = 'Gerai';
    $nama_metode = ucfirst($metode_pembayaran);
} elseif (in_array($metode_pembayaran, ['dana', 'ovo', 'shopeepay', 'linkaja'])) {
    $metode = 'E-Wallet';
    $nama_metode = ucfirst($metode_pembayaran);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="../css/invoice.css">
</head>

<body>
    <div class="invoice-wrapper">
        <div class="invoice-header">
            <h1>INVOICE</h1>
            <h2>LUNAS</h2>
        </div>
        <div class="invoice-content">
            <table class="invoice-details">
                <tr>
                    <td>
                        <div class="invoice-label">Nama:</div> <?php echo htmlspecialchars($invoice['user_name']); ?><br>
                        <div class="invoice-label">Email:</div> <?php echo htmlspecialchars($invoice['user_email']); ?><br>
                        <div class="invoice-label">No Telp:</div> <?php echo htmlspecialchars($invoice['user_phone']); ?>
                    </td>
                    <td>
                        <div class="invoice-label">No Invoice:</div> <?php echo sprintf('%06d', $invoice['id_invoice']); ?><br>
                        <div class="invoice-label">Tanggal:</div> <?php echo date('d F Y', strtotime($invoice['date'])); ?><br>
                        <div class="invoice-label">Venue:</div> <?php echo htmlspecialchars($invoice['nama_venue']); ?>
                    </td>
                </tr>
            </table>

            <table class="invoice-details">
                <tr>
                    <th>No</th>
                    <th>Nama Venue</th>
                    <th>Email Provider</th>
                    <th>Corporation</th>
                    <th>Date Duration</th>
                    <th>Price each Day (Rp)</th>
                    <th>Jumlah (Rp)</th>
                </tr>
                <tr>
                    <td>01</td>
                    <td><?php echo htmlspecialchars($invoice['nama_venue']); ?></td>
                    <td><?php echo htmlspecialchars($invoice['provider_email']); ?></td>
                    <td><?php echo htmlspecialchars($invoice['lembaga']); ?></td>
                    <td><?php echo $days . " days"; ?></td>
                    <td><?php echo number_format($price_per_day, 0, ',', '.'); ?></td>
                    <td><?php echo number_format($total_price, 0, ',', '.'); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="6">Biaya Layanan</td>
                    <td><?php echo number_format($service_fee, 0, ',', '.'); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="6">Total</td>
                    <td><?php echo number_format($grand_total, 0, ',', '.'); ?></td>
                </tr>
            </table>

            <table class="payment-details">
                <tr>
                    <th>Metode</th>
                    <td><?php echo $metode; ?></td>
                </tr>
                <tr>
                    <th>Nama <?php echo $metode; ?></th>
                    <td><?php echo $nama_metode; ?></td>
                </tr>
                <tr>
                    <th>Nominal</th>
                    <td>Rp. <?php echo number_format($grand_total, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Atas Nama</th>
                    <td><?php echo htmlspecialchars($invoice['lembaga']); ?></td>
                </tr>
            </table>
        </div>
        <div class="invoice-footer">
            <div class="invoice-buttons">
                <button class="download" onclick="window.print()">Unduh Invoice</button>
                <button class="complete" onclick="window.location.href='../User/User.php'">Selesai</button>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>
