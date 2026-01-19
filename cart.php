<?php
session_start();
include_once 'dbhelper.php';
$db = new Dbhelper();
$message = "";

if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit();
}

if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    $details = ""; $total = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $p = $db->getProductById($id);
        if ($p) {
            $details .= $p['productname'] . " (x$qty), ";
            $total += $p['productprice'] * $qty;
        }
    }
    if ($db->placeOrder($_SESSION['name'] ?? "სტუმარი", $details, $total)) {
        unset($_SESSION['cart']);
        $message = "შეკვეთა გაფორმდა!";
    }
}
?>
<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>კალათა</title>
</head>
<body>
    <header>
        <h1>🛒 კალათა</h1>
        <a href="index.php">🏠 მაღაზია</a>
    </header>

    <div class="admin-card" style="width: 100%; max-width: 900px; margin: 0 auto;">
        <?php if ($message) echo "<p style='color: var(--accent); text-align: center; margin-bottom: 20px;'>$message</p>"; ?>
        <table class="admin-table">
            <thead>
                <tr><th>პროდუქტი</th><th>რაოდენობა</th><th>ფასი</th><th>მართვა</th></tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                if (!empty($_SESSION['cart'])):
                    foreach ($_SESSION['cart'] as $id => $qty):
                        $p = $db->getProductById($id);
                        if ($p):
                            $sum = $p['productprice'] * $qty; $grand_total += $sum;
                ?>
                            <tr>
                                <td><?= htmlspecialchars($p['productname']); ?></td>
                                <td><?= $qty; ?></td>
                                <td class="text-accent"><?= $sum; ?> ₾</td>
                                <td><a href="?remove=<?= $id; ?>" style="color: #fb7185; text-decoration: none;">🗑️</a></td>
                            </tr>
                <?php endif; endforeach; 
                else: echo "<tr><td colspan='4' style='text-align:center;'>კალათა ცარიელია</td></tr>";
                endif; ?>
            </tbody>
        </table>
        <?php if ($grand_total > 0): ?>
            <div style="text-align: right; margin-top: 20px;">
                <h3>ჯამი: <span class="text-accent"><?= $grand_total; ?> ₾</span></h3>
                <form method="post" style="margin-top: 15px;">
                    <button type="submit" name="checkout" class="btn" style="width: 220px;">შეკვეთა</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>