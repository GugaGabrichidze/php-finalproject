<?php
session_start();
include_once 'dbhelper.php';
$error = "";

if (isset($_POST['submit'])) {
    $db = new Dbhelper();
    $user = $db->loginUser($_POST['username'], $_POST['password']);
    if ($user) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['name'] = $user['name'];
        header("Location: adminpanel.php");
        exit();
    } else {
        $error = "არასწორი მომხმარებელი ან პაროლი!";
    }
}
?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>შესვლა</title>
</head>

<body class="auth-page">
    <div class="inputform">
        <form action="" method="post">
            <h2 style="text-align: center; margin-bottom: 20px; color: var(--primary);">🔑 შესვლა</h2>
            <?php if ($error) echo "<p style='color:#fb7185; text-align:center; font-size:14px; margin-bottom:10px;'>$error</p>"; ?>
            <input type="text" name="username" placeholder="მომხმარებელი" required>
            <input type="password" name="password" placeholder="პაროლი" required>
            <button type="submit" name="submit">შესვლა</button>
            <div style="text-align: center; margin-top: 15px;">
                <a href="register.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">რეგისტრაცია</a>
            </div>
        </form>
    </div>
</body>

</html>