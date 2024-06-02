<?php
require_once '../php/functions.php';

$booking_id = 1; // Example booking ID

$invoice_data = generateInvoice($booking_id);
echo "Invoice created with ID: " . $invoice_data['id_invoice'];
header("Location: ../User/invoice.php?id_user=" . $invoice_data['id_user'] . "&id_invoice=" . $invoice_data['id_invoice']);
exit();
?>