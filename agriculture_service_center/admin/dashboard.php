<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../user/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome Admin</h2>
    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_services.php">Manage Services</a></li>
        <li><a href="view_bookings.php">View Bookings</a></li>
        <a href="manage_bookings.php">Manage Bookings</a>
        <li><a href="reports.php">Reports</a></li>
    </ul>
</body>
</html>
