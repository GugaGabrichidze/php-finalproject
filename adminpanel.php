<?php
session_start();
include_once 'dbhelper.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Dbhelper();
$message = "";

// პროდუქტის დამატება
if (isset($_POST['add'])) {
    $target_dir = "IMG/";
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
    $file_name = time() . "_" . basename($_FILES["productimg"]["name"]);
    $target_file = $target_dir . $file_name;
    if (move_uploaded_file($_FILES["productimg"]["tmp_name"], $target_file)) {
        if ($db->addProduct($_POST['productname'], $_POST['productprice'], $target_file)) $message = "წარმატებით დაემატა!";
    }
}

// პროდუქტის წაშლა
if (isset($_GET['delete'])) {
    $db->deleteProduct($_GET['delete']);
    header("Location: adminpanel.php");
    exit();
}

// შეკვეთის წაშლა (ეს ნაწილი გჭირდებოდათ)
if (isset($_GET['delete_order'])) {
    $db->deleteOrder($_GET['delete_order']);
    header("Location: adminpanel.php");
    exit();
}

$products = $db->getAllProducts();
$orders = $db->getAllOrders();
?>
<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Admin Panel</title>
</head>

<body class="admin-body-reset">
    <div class="admin-page-container">
        <aside class="admin-sidebar">
            <div class="sidebar-box">
                <h2>Dashboard</h2>
                <form method="post" enctype="multipart/form-data" class="sidebar-add-form" style="margin-top: 20px;">
                    <h4 style="margin-bottom: 15px;">➕ პროდუქტის დამატება</h4>
                    <input type="text" name="productname" placeholder="სახელი" required>
                    <input type="number" step="0.01" name="productprice" placeholder="ფასი" required>
                    <input type="file" name="productimg" id="file" hidden required>
                    <label for="file" class="file-label-btn" style="margin-bottom: 10px;">📷 აირჩიეთ ფოტო</label>
                    <button type="submit" name="add">შენახვა</button>
                    <?php if ($message) echo "<p style='color: var(--accent); text-align: center; margin-top: 10px;'>$message</p>"; ?>
                </form>

                <nav class="admin-nav">
                    <a href="index.php">🏠 მაღაზია</a>
                    <a href="editprofile.php">⚙️ პროფილი</a>
                    <a href="logout.php" style="color: #fb7185;">🚪 გასვლა</a>
                </nav>
            </div>
        </aside>

        <main class="admin-content">
            <div class="admin-card">
                <h3>📦 პროდუქცია</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ფოტო</th>
                            <th>სახელი</th>
                            <th>ფასი</th>
                            <th>მართვა</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><img src="<?= $p['productimg']; ?>" class="mini-img"></td>
                                <td><?= htmlspecialchars($p['productname']); ?></td>
                                <td class="text-accent"><?= $p['productprice']; ?> ₾</td>
                                <td>
                                    <a href="editproduct.php?id=<?= $p['productid']; ?>" style="text-decoration: none;">✏️</a>
                                    <a href="?delete=<?= $p['productid']; ?>" style="text-decoration: none; margin-left: 10px;" onclick="return confirm('წავშალოთ?')">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="admin-card">
                <h3>🛒 შეკვეთები</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>კლიენტი</th>
                            <th>დეტალები</th>
                            <th>ჯამი</th>
                            <th>თარიღი</th>
                            <th>მართვა</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><?= htmlspecialchars($o['user_name'] ?? 'სტუმარი'); ?></td>

                                    <td style="font-size: 13px; color: var(--text-muted);">
                                        <?= htmlspecialchars($o['product_details'] ?? 'ინფორმაცია არაა'); ?>
                                    </td>

                                    <td class="text-accent"><?= $o['total_price']; ?> ₾</td>

                                    <td><?= isset($o['order_date']) ? date('d.m.Y', strtotime($o['order_date'])) : date('d.m.Y'); ?></td>

                                    <td>
                                        <a href="?delete_order=<?= $o['order_id']; ?>"
                                            onclick="return confirm('ნამდვილად გსურთ შეკვეთის წაშლა?')"
                                            style="text-decoration: none;">❌</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 20px;">შეკვეთები არ მოიძებნა</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>