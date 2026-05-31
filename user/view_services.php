<?php
session_start();
include "../config/db_connect.php";

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* FETCH SERVICES */
$result = pg_query($conn, "SELECT * FROM services ORDER BY service_id");

if (!$result) {
    die("QUERY ERROR: " . pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Available Agriculture Services</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
margin:0;
padding:0;
}

/* Top Button */
.top-bar{
position:absolute;
top:20px;
right:40px;
}

.btn-my-bookings{
background:#2e7d32;
color:white;
padding:10px 18px;
text-decoration:none;
border-radius:6px;
font-weight:bold;
}

.btn-my-bookings:hover{
background:#1b5e20;
}

/* Table */
h2{
text-align:center;
margin-top:60px;
}

table{
border-collapse:collapse;
width:90%;
margin:20px auto;
background:#fff;
}

th,td{
border:1px solid #ccc;
padding:10px;
text-align:center;
}

th{
background:#2e8b57;
color:white;
}

/* Buttons */
.btn{
padding:6px 12px;
border:none;
border-radius:4px;
cursor:pointer;
}

.btn-view{
background:#6c757d;
color:white;
}

.btn-book{
background:#2e8b57;
color:white;
}

.btn-view:hover{
background:#555;
}

.btn-book:hover{
background:#1e7e34;
}

</style>
</head>

<body>

<!-- My Bookings Button -->
<div class="top-bar">
<a href="my_bookings.php" class="btn-my-bookings">
📄 My Bookings
</a>
</div>

<h2>Available Agriculture Services</h2>

<table>

<tr>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while($row = pg_fetch_assoc($result)) { ?>

<tr>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['description']); ?></td>

<td>₹ <?php echo htmlspecialchars($row['price']); ?></td>

<td>

<a href="service_detail.php?service_id=<?php echo $row['service_id']; ?>">
<button class="btn btn-view">View Details</button>
</a>

<a href="confirm_booking.php?service_id=<?php echo $row['service_id']; ?>">
<button class="btn btn-book">Book Service</button>
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>
