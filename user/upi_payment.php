<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../config/db_connect.php";

if (!isset($_GET['booking_id'])) {
    die("Booking ID missing");
}
$booking_id = (int)$_GET['booking_id'];

$sql = "
SELECT 
    b.booking_id,
    s.name AS service_name,
    s.price
FROM bookings b
JOIN services s ON b.service_id = s.service_id
WHERE b.booking_id = $booking_id
";

$result = pg_query($conn, $sql) or die(pg_last_error($conn));
$row = pg_fetch_assoc($result);

if (!$row) {
    die("Invalid Booking ID");
}

$amount = $row['price'];
$service = $row['service_name'];

/* 🔹 YOUR UPI ID HERE */
$upi_id = "9325501715@ybl";
$payee_name = "Agri Service Center";

/* UPI URL */
$upi_url = "upi://pay?pa=$upi_id&pn=" . urlencode($payee_name) .
           "&am=$amount&cu=INR&tn=Booking-$booking_id";

/* QR image */
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($upi_url);
?>
<!DOCTYPE html>
<html>
<head>
<title>UPI Payment</title>
<style>
body{
    font-family: Arial;
    background:#f4f6f8;
    margin:0;
}
.box{
    width:400px;
    margin:40px auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
    text-align:center;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
h2{ color:#2c3e50; }
.qr img{ margin:15px 0; }
.green{ color:green; font-size:18px; font-weight:bold; }
button{
    padding:12px 25px;
    background:#28a745;
    color:white;
    border:none;
    border-radius:5px;
    font-size:16px;
    cursor:pointer;
}
button:hover{ background:#218838; }
</style>
</head>

<body>

<div class="box">
    <h2>Scan QR to Pay</h2>

    <p><b>Booking ID:</b> <?php echo $booking_id; ?></p>
    <p><b>Service:</b> <?php echo $service; ?></p>
    <p class="green">Amount: ₹<?php echo $amount; ?></p>

    <div class="qr">
        <img src="<?php echo $qr_url; ?>">
    </div>

    <p>Scan this QR with PhonePe / GPay / Paytm</p>

    <a href="verify_payment.php?booking_id=<?php echo $booking_id; ?>">
        <button>I Have Paid</button>
    </a>
</div>

</body>
</html>
