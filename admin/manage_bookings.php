<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

/* ADMIN CHECK */
if (
    !isset($_SESSION['user_id']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: ../user/login.php");
    exit;
}

/* DB CONNECTION */
require_once __DIR__ . '/../config/db_connect.php';

if (!$conn) {
    die("DB connection failed");
}

/* UPDATE BOOKING STATUS */
if (isset($_GET['complete_id'])) {
    $sid = (int) $_GET['complete_id'];

$updateQuery = "
UPDATE bookings 
SET status='completed', payment_status='paid' 
WHERE booking_id=$sid
";
    $updateResult = pg_query($conn, $updateQuery);

    if (!$updateResult) {
        die(pg_last_error($conn));
    }

    header("Location: manage_bookings.php");
    exit;
}

/* FETCH BOOKINGS WITH SERVICE NAME */
$query = "
SELECT
b.booking_id,
u.name AS user_name,
s.name AS service_name,
b.status,
b.booking_date
FROM bookings b
JOIN users u ON b.user_id = u.user_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_date DESC
";

$result = pg_query($conn, $query);

if (!$result) {
    die(pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Manage Bookings</title>

<style>

body{
font-family:Arial;
background:#f4f6f8;
}

table{
border-collapse:collapse;
width:100%;
background:#fff;
}

th,td{
border:1px solid #ccc;
padding:10px;
text-align:center;
}

th{
background:#2e7d32;
color:#fff;
}

.btn{
padding:6px 10px;
background:#1976d2;
color:#fff;
text-decoration:none;
border-radius:4px;
}

.completed{
color:green;
font-weight:bold;
}

.pending{
color:orange;
font-weight:bold;
}

</style>

</head>

<body>

<h2>Manage Bookings</h2>

<table>

<tr>
<th>Booking ID</th>
<th>User Name</th>
<th>Service</th>
<th>Status</th>
<th>Booking Date</th>
<th>Action</th>
</tr>

<?php if (pg_num_rows($result) > 0): ?>

<?php while ($row = pg_fetch_assoc($result)): ?>

<tr>

<td><?php echo $row['booking_id']; ?></td>

<td><?php echo htmlspecialchars($row['user_name']); ?></td>

<td><?php echo htmlspecialchars($row['service_name']); ?></td>

<td class="<?php echo $row['status'] === 'completed' ? 'completed' : 'pending'; ?>">
<?php echo $row['status']; ?>
</td>

<td><?php echo $row['booking_date']; ?></td>

<td>

<?php if ($row['status'] !== 'completed'): ?>

<a class="btn"
href="manage_bookings.php?complete_id=<?php echo $row['booking_id']; ?>"
onclick="return confirm('Mark booking as completed?');">
Complete
</a>

<?php else: ?>

✔ Done

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>
<td colspan="6">No bookings found</td>
</tr>

<?php endif; ?>

</table>

</body>
</html>
