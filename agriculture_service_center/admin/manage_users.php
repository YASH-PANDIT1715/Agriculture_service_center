<?php

include('../config/db_connect.php'); 
if(!$conn){
die("database connect failed");
}

$query = "SELECT * FROM users ORDER BY user_id ASC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>






<div style="background:#2e7d32; padding:10px;">
    <a href="manage_users.php" style="color:white; margin-right:15px;">Users</a>
    <a href="manage_services.php" style="color:white; margin-right:15px;">Services</a>
<a href="manage_bookings.php" style="color:white; margin-right:15px;">Bookings</a>
    <a href="../user/logout.php" style="color:white;">Logout</a>
</div>







<div class="container mt-5">
    <h2 class="text-center mb-4">Manage Users</h2>
    




   <div style="margin-bottom:15px;">
    <a href="manage_services.php" class="btn btn-success">
        Manage Services
    </a>

    <a href="view_bookings.php" class="btn btn-primary">
        View Bookings
    </a>
</div>











    <table class="table table-bordered table-striped">

        <thead class="bg-success text-white">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Role</th>
                <th>Registered On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (pg_num_rows($result) > 0) {
                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['user_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['role']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='edit_users.php?id={$row['user_id']}' class='btn btn-primary btn-sm'>Edit</a>
      <a href='delete_users.php?id={$row['user_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
