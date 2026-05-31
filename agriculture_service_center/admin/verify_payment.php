<?php
require_once __DIR__ . '/../config/connect.php';

if (isset($_GET['booking_id'], $_GET['payment_id'])) {
    $booking_id = intval($_GET['booking_id']);
    $transaction_id = $_GET['payment_id'];
}
elseif (isset($_POST['booking_id'], $_POST['transaction_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $transaction_id = trim($_POST['transaction_id']);
}
else {
    die("Invalid payment request");
}

$sql = "
UPDATE bookings
SET payment_status = 'paid',
    transaction_id = $1
WHERE booking_id = $2
";

$result = pg_query_params($conn, $sql, [
    $transaction_id,
    $booking_id
]);

if (!$result) {
    die("Payment update failed");
}

header("Location: ../user/my_bookings.php");
exit;
