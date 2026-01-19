<?php
session_start();
include_once 'dbhelper.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Dbhelper();
$id = $_GET['id'];
$product = $db->getProductById($id);

if (isset($_POST['save'])) {
    if ($db->updateProduct($id, $_POST['p_name'], $_POST['p_price'])) {
        header("Location: adminpanel.php");
    }
}

?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>პროდუქტის რედაქტირება</title>
</head>

<body>
    <div class="inputform">
        <h3>რედაქტირება</h3>
        <form action="" method="post">
            <input type="text" name="p_name" value="<?php echo $product['productname']; ?>" required>
            <input type="number" step="0.01" name="p_price" value="<?php echo $product['productprice']; ?>" required>
            <button type="submit" name="save">განახლება</button>
            <a href="adminpanel.php">გაუქმება</a>
        </form>
    </div>
</body>

</html>