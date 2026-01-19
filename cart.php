<?php
session_start();
include_once 'dbhelper.php';
$db = new Dbhelper();
$message = "";

if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    $details = ""; $total = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $p = $db->getProductById($id);
        $details .= $p['productname'] . " (x$qty), ";
        $total += $p['productprice'] * $qty;
    }
    $customer = $_SESSION['name'] ?? "სტუმარი";
    if ($db->placeOrder($customer, $details, $total)) {
        unset($_SESSION['cart']);
        $message = "შეკვეთა წარმატებით გაფორმდა!";
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
    <div class="admin-wrapper">
        <div class="table-container">
            <h2>თქვენი კალათა</h2>
            <?php if($message) echo "<p style='color:green'>$message</p>"; ?>
            <table>
                <tr><th>პროდუქტი</th><th>რაოდენობა</th><th>ფასი</th></tr>
                <?php 
                $grand_total = 0;
                if(!empty($_SESSION['cart'])):
                    foreach($_SESSION['cart'] as $id => $qty):
                        $p = $db->getProductById($id);
                        $sum = $p['productprice'] * $qty; $grand_total += $sum;
                ?>
                <tr><td><?php echo $p['productname']; ?></td><td><?php echo $qty; ?></td><td><?php echo $sum; ?> ₾</td></tr>
                <?php endforeach; endif; ?>
            </table>
            <h3>სულ: <?php echo $grand_total; ?> ₾</h3>
            <form method="post" style="margin-top:20px;">
                <a href="index.php" class="btn" style="background:#888;">უკან</a>
                <button type="submit" name="checkout" class="btn" style="background:green;">შეკვეთა</button>
            </form>
        </div>
    </div>
</body>
</html>