<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config/db_connect.php');

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contact = trim($_POST['contact']);
    $role = 'farmer';

    // Check if email already exists
    $checkQuery = "SELECT user_id FROM users WHERE email = $1";
    $checkResult = pg_query_params($conn, $checkQuery, array($email));

    if (pg_num_rows($checkResult) > 0) {
        echo "<script>alert('Email already registered');</script>";
    } else {

        $query = "INSERT INTO users (name, email, password, contact, role)
                  VALUES ($1, $2, $3, $4, $5)";

        $result = pg_query_params(
            $conn,
            $query,
            array($name, $email, $password, $contact, $role)
        );

        if ($result) {
            header("Location: login.php");
            exit;
        } else {
            echo "<script>alert('Registration failed');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Farmer Registration | Agriculture Service Center</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<section class="form-section">
  <div class="form-box">
    <h2>Farmer Registration</h2>
    <p class="form-subtext">
      Create your account to access agriculture services easily.
    </p>

    <form method="POST" action="">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>

      <div class="form-group">
        <label>Contact Number</label>
        <input type="text" name="contact" required>
      </div>

      <button type="submit" name="register" class="btn primary full-btn">
        Register
      </button>
    </form>

    <p class="form-footer-text">
      Already have an account?
      <a href="login.php">Login here</a>
    </p>
  </div>
</section>

</body>
</html>
