<?php
include_once 'dbhelper.php';
$error = "";

if (isset($_POST['submit'])) {
    $db = new Dbhelper();
    if ($db->registerUser($_POST['name'], $_POST['lastname'], $_POST['tel'], $_POST['username'], $_POST['password'])) {
        header("Location: login.php");
        exit();
    } else {
        $error = "რეგისტრაცია ვერ მოხერხდა!";
    }
}
?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>რეგისტრაცია</title>
</head>

<body class="auth-page">
    <div class="inputform">
        <form action="" method="post">
            <h2 style="text-align: center; margin-bottom: 20px; color: var(--primary);">📝 რეგისტრაცია</h2>
            <?php if ($error) echo "<p style='color:#fb7185; text-align:center; font-size:14px; margin-bottom:10px;'>$error</p>"; ?>
            <input type="text" name="name" placeholder="სახელი" required>
            <input type="text" name="lastname" placeholder="გვარი" required>
            <input type="text" name="tel" placeholder="ტელეფონი" required>
            <input type="text" name="username" placeholder="მომხმარებელი" required>
            <input type="password" name="password" placeholder="პაროლი" required>
            <button type="submit" name="submit">რეგისტრაცია</button>
            <div style="text-align: center; margin-top: 15px;">
                <a href="login.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">უკვე გაქვთ ანგარიში?</a>
            </div>
        </form>
    </div>
</body>

</html>