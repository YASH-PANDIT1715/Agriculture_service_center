<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
include "../config/db_connect.php";

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* SERVICE ID CHECK */
if (!isset($_GET['service_id'])) {
    die("Service ID not found");
}

$service_id = (int)$_GET['service_id'];

/* FETCH SERVICE */
$sql = "SELECT * FROM services WHERE service_id = $1";
$result = pg_query_params($conn,$sql,array($service_id));

if(!$result){
    die("Service Query Failed : ".pg_last_error($conn));
}

$service = pg_fetch_assoc($result);

if(!$service){
    die("Service not found");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Confirm Booking</title>

<style>

body{
margin:0;
font-family:Segoe UI;
background:linear-gradient(135deg,#a8edea,#fed6e3);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

.booking-box{
background:white;
width:420px;
padding:30px;
border-radius:15px;
text-align:center;
box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.booking-box h2{
color:#2e8b57;
}

.line{
height:3px;
width:60px;
background:#2e8b57;
margin:10px auto 20px;
border-radius:5px;
}

.info{
text-align:left;
margin-bottom:20px;
}

.info p{
font-size:16px;
margin:10px 0;
}

.info span{
font-weight:bold;
}

.price{
font-size:28px;
color:#27ae60;
font-weight:bold;
margin:20px 0;
}

.confirm-btn{
width:100%;
padding:14px;
border:none;
border-radius:25px;
background:linear-gradient(135deg,#2ecc71,#27ae60);
color:white;
font-size:18px;
cursor:pointer;
transition:0.3s;
}

.confirm-btn:hover{
transform:scale(1.05);
}

</style>

</head>

<body>

<div class="booking-box">

<h2>Confirm Your Booking</h2>

<div class="line"></div>

<div class="info">

<p>
Service :
<span>
<?php echo htmlspecialchars($service['name']); ?>
</span>
</p>

<p>
Description :
<span>
<?php echo htmlspecialchars($service['description']); ?>
</span>
</p>

</div>

<div class="price">
₹<?php echo number_format($service['price'],2); ?>
</div>

<form method="POST" action="create_booking.php">

<input type="hidden"
name="service_id"
value="<?php echo $service_id; ?>">

<input type="hidden"
name="price"
value="<?php echo $service['price']; ?>">

<button type="submit" class="confirm-btn">
Confirm Booking
</button>

</form>

</div>

</body>
</html>
