<?php
session_start();
include_once 'dbhelper.php';
$db = new Dbhelper();
$products = $db->getAllProducts();

if (isset($_GET['add_to_cart'])) {
    $pid = $_GET['add_to_cart'];
    $_SESSION['cart'][$pid] = ($_SESSION['cart'][$pid] ?? 0) + 1;
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>მაღაზია</title>
</head>

<body>
    <div class="admin-wrapper">
        <header class="admin-header">
            <h1>🛍️ მაღაზია</h1>
            <div>
                <a href="cart.php">🛒 კალათა (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
                <a href="adminpanel.php">ადმინ პანელი</a>
            </div>
        </header>

        <div class="products-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="<?php echo $p['productimg']; ?>" alt="Product Image">
                    <div class="product-info">
                        <h3><?php echo $p['productname']; ?></h3>
                        <p class="price"><?php echo $p['productprice']; ?> ₾</p>
                        <a href="?add_to_cart=<?php echo $p['productid']; ?>" class="btn">კალათაში დამატება</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>