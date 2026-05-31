<?php
session_start();
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $detail = $_POST['service_detail'];
    $price = $_POST['price'];

    pg_query_params(
        $conn,
        "INSERT INTO services (name, description, service_detail, price)
         VALUES ($1,$2,$3,$4)",
        array($name, $desc, $detail, $price)
    );

    header("Location: manage_services.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Service</title></head>
<body>

<h2>Add Service</h2>

<form method="POST">
    Name:<br>
    <input type="text" name="name" required><br><br>

    Short Description:<br>
    <textarea name="description" required></textarea><br><br>

    Service Detail:<br>
    <textarea name="service_detail" required></textarea><br><br>

    Price:<br>
    <input type="number" name="price" required><br><br>

    <button type="submit">Save</button>
</form>

</body>
</html>
