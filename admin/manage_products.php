<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'administrator' && $_SESSION['user']['role'] !== 'moderator')) {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

$products = getAllProducts();
?>

<h2>Zarządzaj produktami</h2>
<a href="add_product.php">Dodaj nowy produkt</a>
<table>
    <tr>
        <th>Nazwa</th>
        <th>Opis</th>
        <th>Cena</th>
        <th>Obrazek</th>
        <th>Akcje</th>
    </tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?php echo htmlspecialchars($product['name']); ?></td>
        <td><?php echo htmlspecialchars($product['description']); ?></td>
        <td><?php echo htmlspecialchars($product['price']); ?></td>
        <td><img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="50"></td>
        <td>
            <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edytuj</a>
            <a href="delete_product.php?id=<?php echo $product['id']; ?>">Usuń</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
