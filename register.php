<?php
include_once 'user.php';
include_once 'dbhelper.php';

if (isset($_POST['submit'])) {
    $db = new Dbhelper();

    if ($db->registerUser(
        $_POST['name'],
        $_POST['lastname'],
        $_POST['tel'],
        $_POST['username'],
        $_POST['password']
    )) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error during registration!";
    }
}
?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>რეგისტრაცია</title>
</head>

<body>
    <div class="inputform">
        <form action="" method="post">
            <h2>რეგისტრაცია</h2>
            <input type="text" name="name" placeholder="სახელი" required>
            <input type="text" name="lastname" placeholder="გვარი" required>
            <input type="text" name="tel" placeholder="ტელეფონი" required>
            <input type="text" name="username" placeholder="მომხმარებელი" required>
            <input type="password" name="password" placeholder="პაროლი" required>
            <button type="submit" name="submit" class="btn">რეგისტრაცია</button>
            <a href="login.php" style="display:block; text-align:center; margin-top:10px;">უკვე გაქვთ აქაუნთი?</a>
        </form>
    </div>
</body>

</html>