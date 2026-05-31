<?php
// ERROR ON (testing साठी)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// SESSION + DB
session_start();
include('../config/db_connect.php');

// ADMIN CHECK
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit;
}

/* -------------------------------
   FETCH ALL BOOKINGS (ADMIN)
--------------------------------*/
$query = "
SELECT
    b.booking_id,
    b.booking_date,
    COALESCE(b.status, 'Pending') AS status,
    b.created_at,
    u.user_id,
    u.name AS user_name,
    u.email,
    s.name AS service_name,
    s.price
FROM bookings b
LEFT JOIN users u ON b.user_id = u.user_id
LEFT JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";

$result = pg_query($conn, $query);

if (!$result) {
    die("DB Error: " . pg_last_error($conn));
}

$bookings = pg_fetch_all($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bookings | Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #2e7d32;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #2e7d32;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .status {
            font-weight: bold;
        }
        .pending { color: orange; }
        .confirmed { color: blue; }
        .completed { color: green; }
        .cancelled { color: red; }
    </style>
</head>
<body>

<div style="background:#2e7d32; padding:10px;">
    <a href="manage_users.php" style="color:white; margin-right:15px;">Users</a>
    <a href="manage_services.php" style="color:white; margin-right:15px;">Services</a>
    <a href="view_bookings.php" style="color:white; margin-right:15px;">Bookings</a>
    <a href="../user/logout.php" style="color:white;">Logout</a>
</div>





<h2>All Bookings (Admin)</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Farmer</th>
        <th>Email</th>
        <th>Service</th>
        <th>Price</th>
        <th>Booking Date</th>
        <th>Status</th>
        <th>Created At</th>
    </tr>

    <?php if ($bookings): ?>
        <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['booking_id']) ?></td>
                <td><?= htmlspecialchars($b['user_name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($b['email'] ?? '—') ?></td>
                <td><?= htmlspecialchars($b['service_name'] ?? '—') ?></td>
                <td><?= htmlspecialchars($b['price'] ?? '-') ?></td>
                <td><?= htmlspecialchars($b['booking_date']) ?></td>
                <td class="status <?= strtolower($b['status']) ?>">
                    <?= htmlspecialchars($b['status']) ?>
                </td>
                <td><?= htmlspecialchars($b['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No bookings found</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
