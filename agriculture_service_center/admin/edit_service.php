<?php
session_start();
include '../config/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* ✅ 1. service id check */
if (!isset($_GET['id'])) {
    die("Service ID missing");
}

$service_id = (int) $_GET['id'];

/* ✅ 2. Fetch current service data */
$result = pg_query_params(
    $conn,
    "SELECT * FROM services WHERE service_id = $1",
    array($service_id)
);

if (pg_num_rows($result) === 0) {
    die("Service not found");
}

$service = pg_fetch_assoc($result);

/* ✅ 3. Update logic */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $description = $_POST['description'];
    $service_detail = $_POST['service_detail'];
    $price = $_POST['price'];

    pg_query_params(
        $conn,
        "UPDATE services 
         SET name=$1, description=$2, service_detail=$3, price=$4
         WHERE service_id=$5",
        array($name, $description, $service_detail, $price, $service_id)
    );

    header("Location: manage_services.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <style>
        body { font-family: Arial; }
        form { width: 400px; margin: auto; }
        input, textarea { width: 100%; margin-bottom: 10px; }
        button { padding: 8px 15px; }
    </style>
</head>
<body>

<h2 align="center">Edit Service</h2>

<form method="POST">

    <label>Name</label>
    <input type="text" name="name"
           value="<?= htmlspecialchars($service['name']) ?>" required>

    <label>Short Description</label>
    <textarea name="description" required><?= htmlspecialchars($service['description']) ?></textarea>

    <label>Service Detail</label>
    <textarea name="service_detail" required><?= htmlspecialchars($service['service_detail']) ?></textarea>

    <label>Price</label>
    <input type="number" name="price"
           value="<?= htmlspecialchars($service['price']) ?>" required>

    <button type="submit">Update Service</button>
    <br><br>
    <a href="manage_services.php">⬅ Back</a>

</form>

</body>
</html>
