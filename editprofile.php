<?php
session_start();
include_once 'dbhelper.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Dbhelper();
$message = "";

if (isset($_POST['update'])) {
    if ($db->updateUser($_SESSION['user_id'], $_POST['name'], $_POST['lastname'], $_POST['password'])) {
        $_SESSION['name'] = $_POST['name'];
        $message = "წარმატებით განახლდა!";
    }
}
?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>პროფილის შეცვლა</title>
</head>

<body>
    <div class="inputform">
        <h3>პროფილის რედაქტირება</h3>
        <?php if ($message) echo "<p style='color:green; text-align:center;'>$message</p>"; ?>
        <form method="post">
            <input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" required>
            <input type="text" name="lastname" placeholder="გვარი" required>
            <input type="password" name="password" placeholder="ახალი პაროლი" required>
            <button type="submit" name="update" class="btn">შენახვა</button>
            <br><br>
            <a href="adminpanel.php" style="text-align:center; display:block;">უკან დაბრუნება</a>
        </form>
    </div>
</body>

</html>