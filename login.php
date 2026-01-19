<?php
session_start();
include_once 'dbhelper.php';

if (isset($_POST['submit'])) {
    $db = new Dbhelper();
    $user = $db->loginUser($_POST['username'], $_POST['password']);
    
    if ($user) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['name'] = $user['name'];
        header("Location: adminpanel.php");
    } else {
        echo "არასწორი მომხმარებელი ან პაროლი!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="inputform">
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="submit">შესვლა</button>
            <a href="register.php">რეგისტრაცია</a>
        </form>
    </div>
</body>

</html>