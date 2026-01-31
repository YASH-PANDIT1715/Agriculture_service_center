<?php
session_start();
include "../config/db_connect.php";

/* 🔒 LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


/* SERVICES FETCH */
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
        body { font-family: Arial; background:#f4f4f4; }
        table { border-collapse: collapse; width: 90%; margin:auto; background:#fff; }
        th, td { border:1px solid #ccc; padding:10px; text-align:center; }
        th { background:#2e8b57; color:white; }
        button { padding:6px 12px; cursor:pointer; }
    </style>
</head>
<body>
<div class="top-bar">
    <a href="my_bookings.php" class="btn-my-bookings">
        📄 My Bookings
    </a>
</div>
<h2 align="center">Available Agriculture Services</h2>

<table>
<tr>
    <th>Name</th>
    <th>Description</th>
    <th>Price</th>
    <th>Action</th>
</tr>

<?php while($row = pg_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td>₹ <?php echo $row['price']; ?></td>
    <td>
        <a href="service_detail.php?service_id=<?php echo $row['service_id']; ?>">
            <button>View Details</button>
        </a>

        <a href="confirm_booking.php?service_id=<?php echo $row['service_id']; ?>">
            <button style="background:green;color:white;">Book Service</button>
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>
