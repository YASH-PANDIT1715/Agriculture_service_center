<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['booking_id'])) {
    die("Booking ID missing");
}

$booking_id = (int) $_POST['booking_id'];
$user_id = $_SESSION['user_id'];

/* Update payment */
pg_query_params(
    $conn,
    "UPDATE bookings
     SET status = 'paid'
     WHERE booking_id = $1 AND user_id = $2",
    [$booking_id, $user_id]
);

header("Location: my_bookings.php");
exit;
<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <style>
        body { font-family: Arial; text-align:center; background:#f5f5f5; }
        .box {
            background:white;
            width:400px;
            margin:80px auto;
            padding:25px;
            border-radius:8px;
        }
        a {
            display:inline-block;
            margin-top:15px;
            background:green;
            color:white;
            padding:10px 16px;
            text-decoration:none;
            border-radius:5px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2 style="color:green;">Payment Successful ✔</h2>
    <p>Your booking has been confirmed.</p>
    <a href="my_bookings.php">Go to My Bookings</a>
</div>

</body>
</html>
