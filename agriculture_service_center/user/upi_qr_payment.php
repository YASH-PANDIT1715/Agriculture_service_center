<?php
session_start();
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['booking_id'])) {
    die("Booking ID missing");
}

$booking_id = intval($_GET['booking_id']);

# Get service price & name using JOIN
$sql = "
SELECT s.name, s.price
FROM bookings b
JOIN services s ON b.service_id = s.service_id
WHERE b.booking_id = $booking_id
";

$result = pg_query($conn, $sql);

if (!$result) {
    die("DB Error: " . pg_last_error($conn));
}

if (pg_num_rows($result) == 0) {
    die("Invalid booking");
}

$row = pg_fetch_assoc($result);

$amount = $row['price'];
$service_name = $row['service_name'];

# YOUR UPI ID
/* YOUR UPI ID */
$upi_id = "9325501715@ybl";

/* Merchant / Payee Name */
$merchant = "AgriService";

/* Note / Remark */
$note = "Booking ID $booking_id";

/* Build UPI Payment URL */
$upi_url = "upi://pay?pa=$upi_id&pn=$merchant&am=$amount&cu=INR&tn=$note";

/* Generate QR from Google API */
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($upi_url);
?>

<!DOCTYPE html>
<html>
<head>
<title>UPI Payment</title>

<style>
body{
    margin:0;
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg, #1d976c, #93f9b9);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.payment-box{
    background:#fff;
    width:420px;
    border-radius:15px;
    box-shadow:0 15px 40px rgba(0,0,0,0.25);
    padding:30px;
    text-align:center;
}

.payment-box h2{
    color:#1d976c;
    margin-bottom:10px;
}

.sub{
    color:#555;
    margin-bottom:25px;
}

.qr{
    margin:20px 0;
}

.qr img{
    width:260px;
    height:260px;
    border:8px solid #1d976c;
    border-radius:10px;
    background:white;
}

.amount{
    font-size:26px;
    color:#1d976c;
    font-weight:bold;
    margin:15px 0;
}

.booking{
    color:#555;
    margin-bottom:20px;
}

.paid-btn{
    background: linear-gradient(135deg,#1d976c,#56ab2f);
    border:none;
    color:white;
    width:100%;
    padding:14px;
    border-radius:30px;
    font-size:18px;
    cursor:pointer;
    transition:0.3s;
}

.paid-btn:hover{
    transform:scale(1.05);
    box-shadow:0 10px 20px rgba(0,0,0,0.3);
}

.note{
    font-size:13px;
    color:#777;
    margin-top:15px;
}
</style>

</head>

<body>

<div class="payment-box">
    <h2>Scan & Pay</h2>
    <div class="sub">Scan this QR with any UPI App</div>

    <div class="booking">
        Booking ID: <b><?= $booking_id ?></b>
    </div>

    <div class="qr">
        <img src="<?= $qr_code_url ?>" alt="UPI QR">
    </div>

    <div class="amount">
        ₹<?= number_format($amount,2) ?>
    </div>

    <form action="verify_payment.php" method="get">
        <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
        <button type="submit" class="paid-btn">I Have Paid</button>
    </form>

    <div class="note">
        After payment, click "I Have Paid" to verify your booking
    </div>
</div>

</body>
</html>
