<?php
session_start();
//if(!isset($_SESSION['user_id'])){
//header("LOCATION: ../user/login.php");
//exit;
//}
include('../config/db_connect.php');

/* GET user data */
if (!isset($_GET['id']) && !isset($_POST['user_id'])) {
    die("User ID missing");
}

/* user_id GET किंवा POST मधून घ्या */
$user_id = $_GET['id'] ?? $_POST['user_id'];

/* Fetch user */
$query = "SELECT * FROM users WHERE user_id = $1";
$result = pg_query_params($conn, $query, array($user_id));

if (!$result || pg_num_rows($result) == 0) {
    die("User not found");
}

$user = pg_fetch_assoc($result);

/* Update user */
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];

    $updateQuery = "
       UPDATE users SET name=$1, email=$2, contact=$3, role=$4  WHERE user_id=$5";

    $updateResult = pg_query_params(
        $conn,
        $updateQuery,
        array($name, $email, $contact, $role, $user_id)
    );

    if ($updateResult) {
        header("Location: manage_users.php");
        exit;
    } else {
        echo "Error updating user";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body { font-family: Arial; background:#f8f9fa; padding:30px; }
        form { width:400px; margin:auto; background:#fff; padding:20px; border-radius:10px; }
        input, select { width:100%; padding:10px; margin:10px 0; }
        button { background:#28a745; color:#fff; border:none; padding:10px; cursor:pointer; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit User</h2>

<form method="POST">
    <!-- IMPORTANT -->
    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

    <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
    <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
    <input type="text" name="contact" value="<?php echo $user['contact']; ?>" required>

    <select name="role" required>
        <option value="farmer" <?php if ($user['role']=="farmer") echo "selected"; ?>>Farmer</option>
        <option value="seller" <?php if ($user['role']=="seller") echo "selected"; ?>>Seller</option>
        <option value="service_provider" <?php if ($user['role']=="service_provider") echo "selected"; ?>>Service Provider</option>
    </select>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
