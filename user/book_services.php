<?php

if (!isset($_POST['service_id'])) {
    die("Service ID not received");
}

$service_id = (int)$_POST['service_id'];


session_start();
include "../config/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    die("Login required");
}

if (!isset($_POST['service_id'])) {
    die("service id missing");
}

$user_id = $_SESSION['user_id'];
$service_id = $_POST['service_id'];

/* Insert booking */
$query = "
    INSERT INTO bookings (user_id, service_id, booking_date, status)
    VALUES ($1,$2  NOW(), 'pending')
";

$result = pg_query_params($conn, $query, array($user_id, $service_id));

if ($result) {
    header("Location: confirm_booking.php?service_id=".$service_id);
    exit;
} else {
    echo "Booking Failed";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Successful</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }
        .box {
            width: 420px;
            margin: 80px auto;
            background: #fff;
            padding: 25px;
            border-radius: 6px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: green;
        }
        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 16px;
            background: green;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn-back {
            background: gray;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Booking Confirmed ✅</h2>

    <p><b>Service:</b> <?php echo htmlspecialchars($service['name']); ?></p>
   
    <p><b>Price:</b> ₹ <?php echo $service['price']; ?></p>

    <a href="view_services.php" class="btn">Back to Services</a>
</div>

</body>
</html>
