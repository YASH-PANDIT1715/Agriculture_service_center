<!DOCTYPE html>
<html>
<body>

<form method="POST">
    <input type="text" name="email" placeholder="email">
    <button type="submit">Send</button>
</form>

<?php
echo "<pre>";
var_dump($_POST);
echo "</pre>";
?>

</body>
</html>
