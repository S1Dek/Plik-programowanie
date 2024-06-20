<?php
function registerUser($username, $email, $password, $role = 'user') {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$username, $email, $hashed_password, $role]);
}

function loginUser($username, $password) {
    global $pdo;
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function getUserById($id) {
    global $pdo;
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateUser($id, $username, $email, $role) {
    global $pdo;
    $sql = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$username, $email, $role, $id]);
}

function deleteUser($id) {
    global $pdo;
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

function getAllUsers() {
    global $pdo;
    $sql = "SELECT * FROM users";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllProducts() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM products');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addProduct($name, $description, $price, $image_url) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO products (name, description, price, image_url) VALUES (:name, :description, :price, :image_url)');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image_url', $image_url);
    return $stmt->execute();
}

function updateProduct($id, $name, $description, $price, $image_url) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE products SET name = :name, description = :description, price = :price, image_url = :image_url WHERE id = :id');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image_url', $image_url);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function deleteProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function createOrder($userId, $total) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total) VALUES (:user_id, :total)');
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':total', $total);
    if ($stmt->execute()) {
        return $pdo->lastInsertId();
    }
    return false;
}

function addOrderItem($orderId, $productId, $quantity, $price) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)');
    $stmt->bindParam(':order_id', $orderId);
    $stmt->bindParam(':product_id', $productId);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':price', $price);
    return $stmt->execute();
}
?>
