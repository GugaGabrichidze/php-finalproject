<?php
class Dbhelper
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "apanel");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function loginUser($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) return $row;
        }
        return false;
    }

    public function registerUser($name, $lastname, $tel, $username, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO user (name, lastname, tel, username, password) VALUES (?, ?, ?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssss", $name, $lastname, $tel, $username, $hashedPassword);
        return $stmt->execute();
    }


    public function updateUser($id, $name, $lastname, $password, $imgpath)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE user SET name = ?, lastname = ?, password = ?, profile_img = ? WHERE UserID = ?");
        $stmt->bind_param("ssssi", $name, $lastname, $hashed, $imgpath, $id);
        return $stmt->execute();
    }


    
    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE UserID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function updateProduct($id, $name, $price, $imgPath = null)
    {
        if ($imgPath) {
            $stmt = $this->conn->prepare("UPDATE products SET productname = ?, productprice = ?, productimg = ? WHERE productid = ?");
            $stmt->bind_param("sdsi", $name, $price, $imgPath, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE products SET productname = ?, productprice = ? WHERE productid = ?");
            $stmt->bind_param("sdi", $name, $price, $id);
        }
        return $stmt->execute();
    }
    public function deleteOrder($orderId)
    {
        $stmt = $this->conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        return $stmt->execute();
    }

    public function addProduct($name, $price, $imgPath)
    {
        $stmt = $this->conn->prepare("INSERT INTO products (productname, productprice, productimg) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $imgPath);
        return $stmt->execute();
    }
    public function getAllProducts()
    {
        return $this->conn->query("SELECT * FROM products ORDER BY productid DESC")->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE productid = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteProduct($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE productid = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function placeOrder($userName, $details, $total)
    {
        $stmt = $this->conn->prepare("INSERT INTO orders (user_name, product_details, total_price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $userName, $details, $total);
        return $stmt->execute();
    }

    public function getAllOrders()
    {
        return $this->conn->query("SELECT * FROM orders ORDER BY order_date DESC")->fetch_all(MYSQLI_ASSOC);
    }
}
