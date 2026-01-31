<?php
session_start();
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    die("Login required");
}

$user_id = $_SESSION['user_id'];
$service_id = $_POST['service_id'];

$service = pg_fetch_assoc(pg_query($conn, "SELECT price FROM services WHERE service_id=$service_id"));
$price = $service['price'];

$sql = "INSERT INTO bookings (user_id, service_id, status)
        VALUES ($user_id, $service_id, 'pending')
        RETURNING booking_id";

$res = pg_query($conn, $sql);
$row = pg_fetch_assoc($res);
$booking_id = $row['booking_id'];

header("Location: upi_payment.php?booking_id=$booking_id");
exit;
