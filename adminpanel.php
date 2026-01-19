<?php
session_start();
include_once 'dbhelper.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Dbhelper();
$message = "";


if (isset($_POST['add'])) {
    $target_dir = "IMG/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["productimg"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["productimg"]["tmp_name"], $target_file)) {
        if ($db->addProduct($_POST['productname'], $_POST['productprice'], $target_file)) {
            $message = "პროდუქტი წარმატებით დაემატა!";
        } else {
            $message = "ბაზაში ჩაწერის შეცდომა!";
        }
    } else {
        $message = "ფაილის საქაღალდეში გადატანა ვერ მოხერხდა!";
    }
}

if (isset($_GET['delete'])) {
    $db->deleteProduct($_GET['delete']);
    header("Location: adminpanel.php");
    exit();
}


if (isset($_GET['delete_order'])) {
    if ($db->deleteOrder($_GET['delete_order'])) {
        header("Location: adminpanel.php");
        exit();
    }
}

$products = $db->getAllProducts();
$orders = $db->getAllOrders();
?>

<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>ადმინ პანელი</title>
</head>

<body>
    <div class="admin-wrapper">
        <header class="admin-header">
            <h1>ადმინ პანელი</h1>
            <div>
                <a href="editprofile.php">პროფილი</a>
                <a href="index.php">მაღაზია</a>
                <a href="logout.php" style="color:#ffcccc;">გამოსვლა</a>
            </div>
        </header>

        <div class="inputform">
            <h3>პროდუქტის დამატება</h3>
            <?php if ($message): ?>
                <p class="msg" style="color: green; text-align: center;"><?php echo $message; ?></p>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="productname" placeholder="სახელი" required>
                <input type="number" step="0.01" name="productprice" placeholder="ფასი" required>
                <input type="file" name="productimg" required>
                <button type="submit" name="add" class="btn">დამატება</button>
            </form>
        </div>

        <div class="table-container">
            <h3>პროდუქტების სია</h3>
            <table>
                <thead>
                    <tr>
                        <th>ფოტო</th>
                        <th>სახელი</th>
                        <th>ფასი</th>
                        <th>მოქმედება</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td><img src="<?php echo $p['productimg']; ?>" class="thumb" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                            <td><?php echo $p['productname']; ?></td>
                            <td><?php echo $p['productprice']; ?> ₾</td>
                            <td>
                                <a href="editproduct.php?id=<?php echo $p['productid']; ?>" class="btn" style="padding: 5px 10px; background: orange; text-decoration: none; color: white; border-radius: 4px;">რედაქტირება</a>
                                <a href="?delete=<?php echo $p['productid']; ?>" class="btn btn-delete" onclick="return confirm('ნამდვილად გსურთ წაშლა?')" style="padding: 5px 10px; background: red; text-decoration: none; color: white; border-radius: 4px;">წაშლა</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container" style="margin-top:30px;">
            <h3>შემოსული შეკვეთები</h3>
            <table>
                <thead>
                    <tr>
                        <th>კლიენტი</th>
                        <th>დეტალები</th>
                        <th>ჯამი</th>
                        <th>თარიღი</th>
                        <th>მოქმედება</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?php echo $o['user_name']; ?></td>
                            <td><?php echo $o['product_details']; ?></td>
                            <td><?php echo $o['total_price']; ?> ₾</td>
                            <td><?php echo $o['order_date']; ?></td>
                            <td>
                                <a href="?delete_order=<?php echo $o['order_id']; ?>"
                                    class="btn btn-delete"
                                    onclick="return confirm('დარწმუნებული ხართ, რომ გსურთ შეკვეთის წაშლა?')"
                                    style="padding: 5px 10px; background: red; text-decoration: none; color: white; border-radius: 4px;">წაშლა</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>