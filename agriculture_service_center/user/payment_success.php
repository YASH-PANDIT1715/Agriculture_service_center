<?php
$booking_id = $_GET['booking_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Status</title>

<style>
body{
    margin:0;
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #e9f5ee, #f4f6f8);
}

.card{
    width:420px;
    margin:80px auto;
    background:#fff;
    border-radius:12px;
    padding:30px;
    text-align:center;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
}

.icon{
    font-size:60px;
    margin-bottom:10px;
}

.pending{
    color:#f39c12;
}

h2{
    margin:10px 0;
    color:#2c3e50;
}

p{
    color:#555;
    font-size:15px;
}

.info{
    background:#f8f9fa;
    border-radius:8px;
    padding:15px;
    margin:20px 0;
    text-align:left;
    font-size:14px;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 22px;
    background:#2e8b57;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-weight:600;
}

.btn:hover{
    background:#256f46;
}
</style>
</head>

<body>

<div class="card">
    <div class="icon pending">⏳</div>

    <h2>Verification Pending</h2>
    <p>Your payment has been received and is under verification.</p>

    <div class="info">
        <p><b>Status:</b> Pending</p>
        <p><b>Note:</b> Payment will be confirmed after admin verification.</p>
    </div>

    <a href="view_bill.php?booking_id=<?php echo $booking_id; ?>" class="btn">
        View Bill
    </a>
</div>

</body>
</html>

