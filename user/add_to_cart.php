<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $product = getProductById($_GET['id']);
    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = $product;
    }
}
$cartQuantity = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

header('Location: cart.php');
exit();
?>
