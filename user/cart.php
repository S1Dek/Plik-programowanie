<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<h2>Twój koszyk</h2>
<table>
    <tr>
        <th>Nazwa</th>
        <th>Opis</th>
        <th>Cena</th>
        <th>Obrazek</th>
    </tr>
    <?php foreach ($cart as $product): ?>
    <tr>
        <td><?php echo htmlspecialchars($product['name']); ?></td>
        <td><?php echo htmlspecialchars($product['description']); ?></td>
        <td><?php echo htmlspecialchars($product['price']); ?></td>
        <td><img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50"></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (!empty($cart)): ?>
    <a href="checkout.php">Przejdź do kasy</a>
<?php else: ?>
    <p>Twój koszyk jest pusty.</p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
