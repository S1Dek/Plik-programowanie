<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

$products = getAllProducts();
?>

<h2>Produkty</h2>
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
            <a href="add_to_cart.php?id=<?php echo $product['id']; ?>">Dodaj do koszyka</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
