<?php
session_start();
include "../config/db_connect.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    die("Login required");
}

if (!isset($_POST['service_id'])) {
    die("Service ID missing");
}

$user_id = $_SESSION['user_id'];
$service_id = (int)$_POST['service_id'];

/* Get service price */
$res = pg_query_params(
    $conn,
    "SELECT price FROM services WHERE service_id = $1",
    array($service_id)
);

if (!$res) {
    die("Service query error: " . pg_last_error($conn));
}

$service = pg_fetch_assoc($res);

if (!$service) {
    die("Service not found");
}

$price = $service['price'];

/* Insert booking */
$sql = "
INSERT INTO bookings (user_id, service_id, status,payment_status)
VALUES ($1, $2, 'pending','unpaid')
RETURNING booking_id
";

$res = pg_query_params($conn, $sql, array($user_id, $service_id));

if (!$res) {
    die("Booking failed: " . pg_last_error($conn));
}

$row = pg_fetch_assoc($res);
$booking_id = $row['booking_id'];

/* Redirect to payment */
header("Location: upi_payment.php?booking_id=$booking_id");
exit;
?>
