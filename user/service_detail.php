<?php
session_start();
include '../config/db_connect.php';

if (!isset($_GET['service_id'])) {
    die("Service ID missing");
}

$service_id = (int)$_GET['service_id'];

$sql = "
SELECT service_id, name, description, service_detail, price
FROM services
WHERE service_id = $1
";

$result = pg_query_params($conn, $sql, array($service_id));

if (!$result || pg_num_rows($result) == 0) {
    die("Service not found");
}

$service = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title>Service Detail</title>

<style>

body{
font-family: Arial;
background:#f4f4f4;
}

.box{
width:600px;
margin:60px auto;
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.btn{
padding:10px 20px;
border:none;
background:green;
color:#fff;
cursor:pointer;
border-radius:5px;
text-decoration:none;
margin-right:10px;
}

.btn-back{
padding:10px 20px;
border:none;
background:gray;
color:#fff;
cursor:pointer;
border-radius:5px;
text-decoration:none;
}

.btn:hover{
background:#1e7e34;
}

.btn-back:hover{
background:#555;
}

</style>

</head>

<body>

<div class="box">

<h2><?= htmlspecialchars($service['name']) ?></h2>

<p>
<b>Short Description:</b><br>
<?= htmlspecialchars($service['description']) ?>
</p>

<p>
<b>Service Details:</b><br>
<?= nl2br(htmlspecialchars($service['service_detail'])) ?>
</p>

<p>
<b>Price:</b> ₹<?= htmlspecialchars($service['price']) ?>
</p>

<div style="margin-top:20px;">

<a href="confirm_booking.php?service_id=<?= $service['service_id'] ?>" class="btn">
Book Service
</a>

<a href="view_services.php" class="btn-back">
Back to Services
</a>

</div>

</div>

</body>
</html>
