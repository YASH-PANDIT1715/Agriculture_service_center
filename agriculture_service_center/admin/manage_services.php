<?php
session_start();
include '../config/db_connect.php';

/* Admin login check */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* Fetch services */
$result = pg_query($conn, "SELECT * FROM services ORDER BY service_id ASC");
if (!$result) {
    die("Database error");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
        }
        .btn {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-edit {
            color: #0d6efd;
        }
        .btn-delete {
            color: red;
        }
        .add-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 12px;
            background: green;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<h2>Manage Services</h2>

<a href="add_service.php" class="add-btn">+ Add New Service</a>

<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price (₹)</th>
        <th>Action</th>
    </tr>

    <?php if (pg_num_rows($result) > 0): ?>
        <?php while ($row = pg_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['description']); ?></td>
                <td>₹<?= htmlspecialchars($row['price']); ?></td>
                <td>
                    <a class="btn btn-edit"
                       href="edit_service.php?id=<?= $row['service_id']; ?>">
                        Edit
                    </a>
                    |
                    <a class="btn btn-delete"
                       href="delete_service.php?id=<?= $row['service_id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this service?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No services found.</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>
