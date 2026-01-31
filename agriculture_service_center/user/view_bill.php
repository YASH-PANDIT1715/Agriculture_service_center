<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../config/db_connect.php";

$booking_id = $_GET['booking_id'];

$q = "SELECT b.booking_id, s.name, s.price,b.Payment_status
      FROM bookings b
      JOIN services s ON b.service_id = s.service_id
      WHERE b.booking_id = $booking_id";

$data = pg_fetch_assoc(pg_query($conn,$q));
?>




<!DOCTYPE html>
<html>
<head>
    <title>Bill</title>
    <style>
        body{
            margin:0;
            font-family: Arial, sans-serif;
            background:#f4f6f8;
        }

        .container{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .bill-card{
            width:420px;
            background:#fff;
            border-radius:12px;
            padding:25px 30px;
            box-shadow:0 8px 25px rgba(0,0,0,0.1);
        }

        .bill-card h2{
            text-align:center;
            margin-bottom:20px;
            color:#2c3e50;
        }

        .row{
            display:flex;
            justify-content:space-between;
            margin:12px 0;
            font-size:16px;
        }

        .label{
            color:#555;
            font-weight:600;
        }

        .value{
            color:#222;
        }

        .amount{
            font-size:20px;
            font-weight:bold;
            color:#27ae60;
        }

        .status{
            display:inline-block;
            padding:6px 14px;
            border-radius:20px;
            font-size:14px;
            font-weight:bold;
        }

        .paid{
            background:#d4edda;
            color:#155724;
        }

        .pending{
            background:#fff3cd;
            color:#856404;
        }

        .actions{
            margin-top:25px;
            text-align:center;
        }

        .btn{
            display:inline-block;
            padding:10px 22px;
            background:#3498db;
            color:#fff;
            border-radius:6px;
            text-decoration:none;
            font-size:15px;
        }

        .btn:hover{
            background:#2980b9;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="bill-card">

        <h2>🧾 Bill Details</h2>

        <div class="row">
            <span class="label">Booking ID</span>
            <span class="value"><?php echo $data['booking_id']; ?></span>
        </div>

        <div class="row">
            <span class="label">Service</span>
            <span class="value"><?php echo $data['name']; ?></span>
        </div>

        <div class="row">
            <span class="label">Amount</span>
            <span class="amount">₹<?php echo $data['price']; ?></span>
        </div>

        <div class="row">
            <span class="label">Status</span>
            <span class="status <?php echo ($data['payment_status']=='paid') ? 'paid' : 'pending'; ?>">
                <?php echo ucfirst($data['payment_status'] ?? 'pending'); ?>
            </span>
        </div>

        <div class="actions">
            <a href="my_bookings.php" class="btn">⬅  My Bookings</a>
        </div>

    </div>
</div>

</body>
</html>
