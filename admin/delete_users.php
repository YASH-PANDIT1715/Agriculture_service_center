<?php
session_start();
include "../config/db_connect.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("User ID missing");
}

$user_id = (int) $_GET['id'];

/* 1️⃣ Delete admin logs */
$delLogs = pg_query($conn, "DELETE FROM admin_logs WHERE admin_id = $user_id");
if (!$delLogs) {
    die("Admin logs delete error: " . pg_last_error($conn));
}

/* 2️⃣ Delete bookings (if exist) */
$delBookings = pg_query($conn, "DELETE FROM bookings WHERE user_id = $user_id");
if (!$delBookings) {
    die("Bookings delete error: " . pg_last_error($conn));
}

/* 3️⃣ Delete user */
$delUser = pg_query($conn, "DELETE FROM users WHERE user_id = $user_id");
if (!$delUser) {
    die("User delete error: " . pg_last_error($conn));
}

header("Location: manage_users.php?msg=deleted");
exit;
