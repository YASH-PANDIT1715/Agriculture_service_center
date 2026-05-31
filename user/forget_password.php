<?php
include('../config/db_connect.php');

if(isset($_POST['reset'])){
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $query = "UPDATE users SET password=$1 WHERE email=$2";
    $result = pg_query_params($conn, $query, array($new_password, $email));

    if(pg_affected_rows($result) > 0){
        $msg = "Password updated successfully!";
    } else {
        $msg = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: #fff;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
        }

        h2 {
            color: #2e7d32;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2e7d32;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1b5e20;
        }

        .msg {
            margin-top: 10px;
            font-size: 14px;
        }

        .success { color: green; }
        .error { color: red; }

        a {
            display: block;
            margin-top: 15px;
            color: #2e7d32;
            text-decoration: none;
        }
    </style>

</head>

<body>

<div class="box">
    <h2>Reset Password</h2>

    <?php if(isset($msg)): ?>
        <p class="msg <?php echo ($msg == 'Password updated successfully!') ? 'success' : 'error'; ?>">
            <?php echo $msg; ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit" name="reset">Reset Password</button>
    </form>

    <a href="login.php">← Back to Login</a>
</div>

</body>
</html>
