<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'administrator' && $_SESSION['user']['role'] !== 'moderator')) {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

if (isset($_GET['id'])) {
    deleteProduct($_GET['id']);
}

header('Location: manage_products.php');
exit();
?>
