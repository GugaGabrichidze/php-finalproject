<?php
session_start();
include_once 'dbhelper.php';
$db = new Dbhelper();
$products = $db->getAllProducts();
$userData = isset($_SESSION['user_id']) ? $db->getUserById($_SESSION['user_id']) : null;

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
    <title>🛍️ ონლაინ მაღაზია</title>
</head>

<body>
    <header>
        <h1>🛍️ მაღაზია</h1>
        <div style="display: flex; align-items: center; gap: 15px;">
            <?php if ($userData): ?>
                <img src="<?= !empty($userData['profile_img']) ? $userData['profile_img'] : 'IMG/profiles/default.png'; ?>"
                    style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                <span style="font-weight: 600;"><?= htmlspecialchars($userData['name']); ?></span>
                <a href="editprofile.php">⚙️ პროფილი</a>
                <a href="adminpanel.php">🛠️ ადმინი</a>
                <a href="logout.php" style="color: #fb7185;">🚪 გასვლა</a>
            <?php else: ?>
                <a href="login.php">🔑 შესვლა</a>
            <?php endif; ?>
            <a href="cart.php">🛒 კალათა (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
        </div>
    </header>

    <div class="products-grid">
        <?php foreach ($products as $p): ?>
            <div class="product-card">
                <img src="<?= $p['productimg']; ?>">
                <div class="product-info">
                    <h3><?= $p['productname']; ?></h3>
                    <p class="text-accent"><?= $p['productprice']; ?> ₾</p>
                    <a href="?add_to_cart=<?= $p['productid']; ?>" class="btn" style="margin-top: 15px; text-decoration: none;">🛒 კალათაში</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>