<?php
session_start();
include '../config/db_connect.php';

if (!isset($_GET['service_id'])) {
    die("Service ID missing");
}

$service_id = (int)$_GET['service_id'];

$sql = "
SELECT service_id, name, description, service_detail, price
FROM services
WHERE service_id = $1
";

$result = pg_query_params($conn, $sql, array($service_id));

if (!$result || pg_num_rows($result) == 0) {
    die("Service not found");
}

$service = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service Detail</title>
    <style>
        body { font-family: Arial; background:#f4f4f4; }
        .box {
            width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            background: green;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-back {
            background: gray;
            text-decoration: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="box">
    <h2><?= htmlspecialchars($service['name']) ?></h2>

    <p><b>Short Description:</b><br>
        <?= htmlspecialchars($service['description']) ?>
    </p>

    <p><b>Service Details:</b><br>
        <?= nl2br(htmlspecialchars($service['service_detail'])) ?>
    </p>

    <p><b>Price:</b> ₹<?= htmlspecialchars($service['price']) ?></p>

    <!-- ✅ BOOK SERVICE FORM (VERY IMPORTANT) -->
    <form method="POST" action="book_services.php">
        <input type="hidden" name="service_id"
               value="<?= $service['service_id'] ?>">
        <button type="submit" class="btn">Book Service</button>
    </form>

    <br>
    <a href="view_services.php" class="btn-back">Back to Services</a>
</div>

</body>
</html>
