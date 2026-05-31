<?php
session_start();


include('../config/db_connect.php');


if (!isset($_SESSION['admin_id'])) {
    $_SESSION['admin_id'] = 1;
}


if (!isset($_SESSION['admin_id'])) {
    header("Location: ../user/login.php");
    exit;
}


$totalQuery = "SELECT COUNT(*) AS total FROM bookings";
$totalRes = pg_query($conn, $totalQuery);
$total = $totalRes ? pg_fetch_assoc($totalRes)['total'] : 0;


$pendingQuery = "SELECT COUNT(*) AS pending FROM bookings WHERE status = 'pending'";
$pendingRes = pg_query($conn, $pendingQuery);
$pending = $pendingRes ? pg_fetch_assoc($pendingRes)['pending'] : 0;


$completedQuery = "SELECT COUNT(*) AS completed FROM bookings WHERE status = 'completed'";
$completedRes = pg_query($conn, $completedQuery);
$completed = $completedRes ? pg_fetch_assoc($completedRes)['completed'] : 0;


$incomeQuery = "
SELECT SUM(s.price) AS total_income
FROM bookings b
JOIN services s ON b.service_id = s.service_id
WHERE b.status = 'completed'
";
$incomeRes = pg_query($conn, $incomeQuery);
$total_income = $incomeRes ? pg_fetch_assoc($incomeRes)['total_income'] : 0;

?>

<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        h2 {
            text-align: center;
            color: #2e7d32;
        }
        .report-box {
            width: 400px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            background-color: #a5d6a7;
        }
        tr:nth-child(even) {
            background-color: #e8f5e9;
        }
    </style>
</head>
<body>

    <h2>Booking Summary Report</h2>

    <div class="report-box">
        <table>
            <tr>
                <th>Total Bookings</th>
                <th>Pending Bookings</th>
                <th>Completed Bookings</th>
                <th>Total Income (₹)</th>
            </tr>
            <tr>
                <td><?php echo $total; ?></td>
                <td><?php echo $pending; ?></td>
                <td><?php echo $completed; ?></td>
                <td><?php echo $total_income ? $total_income : 0; ?></td>
            </tr>
        </table>
    </div>

</body>
</html>
