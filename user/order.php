<?php
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

// Implement order functionalities here

include '../includes/footer.php';
?>
