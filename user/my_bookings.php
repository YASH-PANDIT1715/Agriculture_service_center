<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "../config/db_connect.php";
$uid = $_SESSION['user_id'];

$result = pg_query_params($conn,
 "SELECT b.booking_id, s.name AS service_name, s.price, b.status, b.payment_status 
  FROM bookings b 
  JOIN services s ON b.service_id=s.service_id 
  WHERE b.user_id=$1
  ORDER BY b.booking_id DESC",
 array($uid)
);
if(!$result){
die(pg_last_error($conn));
}
?>



<div class="booking-container">
    <h2>My Bookings</h2>
</div>
<table border="1">
<tr>
<th>ID</th><th>Service</th><th>Price</th><th>Status</th><th>Payment</th>
</tr>

<?php while($row=pg_fetch_assoc($result)){ ?>
<tr>
<td><?= $row['booking_id'] ?></td>
<td><?= $row['service_name'] ?></td>
<td>₹<?= $row['price'] ?></td>
<td><?= $row['status'] ?? 'active'?></td>
<td><?= $row['payment_status'] ?></td>
</tr>
<?php } ?>
</table>


<head>
<style>
    body{
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: linear-gradient(135deg, #dbeafe, #fef3c7);
    }

    .booking-container{
        width:92%;
        margin:50px auto;
        background:transparent;
    }

    h2{
        text-align:center;
        margin-bottom:25px;
        color:#1e3a8a;
        font-size:28px;
        letter-spacing:1px;
    }

    table{
        width:100%;
        border-collapse:collapse;
        background:#ffffff;
        box-shadow:0 10px 25px rgba(0,0,0,0.15);
        border-radius:12px;
        overflow:hidden;
    }

    thead{
        background: linear-gradient(90deg, #2563eb, #1d4ed8);
        color:#fff;
        font-size:15px;
    }

    th, td{
        padding:14px 16px;
        text-align:center;
    }

    tbody tr{
        transition: all 0.3s ease;
    }

    tbody tr:nth-child(even){
        background:#f8fafc;
    }

    tbody tr:hover{
        background:#e0f2fe;
        transform: scale(1.01);
    }

    /* STATUS COLORS */
    .status-paid{
        color:#16a34a;
        background:#dcfce7;
        padding:6px 12px;
        border-radius:20px;
        font-weight:600;
    }

    .status-pending{
        color:#ea580c;
        background:#ffedd5;
        padding:6px 12px;
        border-radius:20px;
        font-weight:600;
    }

    /* BUTTON */
    .btn-view{
        padding:7px 16px;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color:#fff;
        text-decoration:none;
        border-radius:20px;
        font-size:14px;
        font-weight:600;
        display:inline-block;
        transition:0.3s;
    }

    .btn-view:hover{
        background: linear-gradient(135deg, #16a34a, #15803d);
        transform: translateY(-2px);
        box-shadow:0 5px 10px rgba(0,0,0,0.2);
    }
</style>
</head>
