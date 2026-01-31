<?php
include "../config/db_connect.php";

$booking_id = $_GET['booking_id'];

pg_query($conn, "UPDATE bookings SET status='pending' WHERE booking_id=$booking_id");

header("Location: payment_success.php?booking_id=$booking_id");
exit;
