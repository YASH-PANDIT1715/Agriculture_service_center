<?php
session_start();
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['service_id'])) {
    die("Service ID not found");
}

$service_id = $_GET['service_id'];

$sql = "SELECT * FROM services WHERE service_id = $service_id";
$result = pg_query($conn, $sql);

if (!$result) {
    die("Service Query Failed: " . pg_last_error($conn));
}

$service = pg_fetch_assoc($result);

if (!$service) {
    die("Service not found");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Confirm Booking</title>

<style>
body {
    margin: 0;
    font-family: "Segoe UI", sans-serif;
    background: linear-gradient(135deg, #d4fc79, #96e6a1);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.booking-card {
    background: white;
    width: 420px;
    border-radius: 15px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    padding: 30px;
    text-align: center;
}

.booking-card h2 {
    color: #2d7a3e;
    margin-bottom: 15px;
}

.line {
    height: 3px;
    width: 60px;
    background: #2d7a3e;
    margin: 10px auto 25px;
    border-radius: 5px;
}

.info {
    text-align: left;
    margin-bottom: 20px;
}

.info p {
    margin: 12px 0;
    font-size: 16px;
    color: #333;
}

.info span {
    font-weight: bold;
    color: #000;
}

.price {
    font-size: 26px;
    color: #2d7a3e;
    font-weight: bold;
    margin: 15px 0;
}

.confirm-btn {
    background: linear-gradient(135deg, #2d7a3e, #56ab2f);
    border: none;
    color: white;
    padding: 14px;
    width: 100%;
    border-radius: 30px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
}

.confirm-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>

</head>

<body>

<div class="booking-card">
    <h2>Confirm Your Booking</h2>
    <div class="line"></div>

    <div class="info">
        <p>Service: <span><?= htmlspecialchars($service['name']) ?></span></p>
        <p>Description: <span><?= htmlspecialchars($service['description']) ?></span></p>
    </div>

    <div class="price">
        ₹<?= number_format($service['price'], 2) ?>
    </div>

    <form method="post" action="create_booking.php">
        <input type="hidden" name="service_id" value="<?= $service_id ?>">
        <input type="hidden" name="price" value="<?= $service['price'] ?>">
        <button type="submit" class="confirm-btn">Confirm Booking</button>
    </form>

</div>

</body>
</html>
