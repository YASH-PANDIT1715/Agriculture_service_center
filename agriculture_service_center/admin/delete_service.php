<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('../config/db_connect.php');

/* Check admin */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* Check service id */
if (!isset($_GET['id'])) {
    die("Service ID missing");
}

$service_id = (int) $_GET['id'];

/* Delete related bookings first */
$deleteBookings = pg_query(
    $conn,
    "DELETE FROM bookings WHERE service_id = $service_id"
);

if ($deleteBookings === false) {
    die("Error deleting bookings: " . pg_last_error($conn));
}

/* Delete service */
$deleteService = pg_query(
    $conn,
    "DELETE FROM services WHERE service_id = $service_id"
);

if ($deleteService === false) {
    die("Error deleting service: " . pg_last_error($conn));
}

/* Redirect */
header("Location: manage_services.php?msg=deleted");
exit;
