<?php
session_start();
include_once 'dbhelper.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = new Dbhelper();
$user_data = $db->getUserById($_SESSION['user_id']); // ვიღებთ მიმდინარე მონაცემებს
$message = "";

if (isset($_POST['update'])) {
    $target_dir = "IMG/profiles/";

    // თუ საქაღალდე არ არსებობს, ვქმნით
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $img_path = $user_data['profile_img']; // ნაგულისხმევია ძველი ფოტო

    // თუ მომხმარებელმა აირჩია ახალი ფაილი
    if (!empty($_FILES["profile_pic"]["name"])) {
        $file_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $img_path = $target_file;
        }
    }

    if ($db->updateUser($_SESSION['user_id'], $_POST['name'], $_POST['lastname'], $_POST['password'], $img_path)) {
        $_SESSION['name'] = $_POST['name'];
        $message = "პროფილი წარმატებით განახლდა!";
        $user_data = $db->getUserById($_SESSION['user_id']); // განვაახლოთ ეკრანზეც
    }
}
?>

<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>პროფილის რედაქტირება</title>
</head>

<body>
    <div class="inputform">
        <h3>პროფილის რედაქტირება</h3>

        <div style="text-align: center; margin-bottom: 20px;">
            <img src="<?php echo $user_data['profile_img']; ?>" alt="Profile" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #667eea;">
        </div>

        <?php if ($message) echo "<p style='color:green; text-align:center;'>$message</p>"; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" value="<?php echo $user_data['name']; ?>" placeholder="სახელი" required>
            <input type="text" name="lastname" value="<?php echo $user_data['lastname']; ?>" placeholder="გვარი" required>

            <label style="display: block; margin-top: 10px; font-size: 14px;">შეცვალეთ ფოტო:</label>
            <input type="file" name="profile_pic" accept="image/*">

            <input type="password" name="password" placeholder="ახალი პაროლი" required>
            <button type="submit" name="update" class="btn">შენახვა</button>
            <a href="index.php" style="display: block; text-align: center; margin-top: 10px; text-decoration: none; color: #667eea;">უკან დაბრუნება</a>
        </form>
    </div>
</body>

</html>