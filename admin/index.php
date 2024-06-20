<?php
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}
?>

<h2>Panel Administracyjny</h2>
<ul>
    <li><a href="view_users.php">Zarządzaj użytkownikami</a></li>
    <li><a href="manage_products.php">Zarządzaj produktami</a></li>
</ul>

<?php include '../includes/footer.php'; ?>
