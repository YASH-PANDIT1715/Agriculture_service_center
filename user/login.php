<?php
ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
 include('../config/db_connect.php');

if (isset($_POST['login'])) {

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $query = "SELECT user_id, email, password, role FROM users WHERE email = $1";
    $result = pg_query_params($conn, $query, array($email));

    if (pg_num_rows($result) === 1) {
        $user = pg_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role']    = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../admin/manage_users.php");
            } else {
                header("Location: ../user/view_services.php");
            }
            exit;
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<section class="form-section">
    <div class="form-box">
        <h2>Farmer Login</h2>

        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>


<form method="POST" autocomplete="off">

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" autocomplete="new-email">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" autocomplete="new-password">
    </div>

    <button type="submit" name="login" class="btn primary full-btn">
        Login
    </button>

</form>





<p style="text-align:center; margin-top:10px;">
    <a href="forget_password.php" style="color:green;">
        Forgot Password?
    </a>
</p>
    </div>
</section>

</body>
</html>
