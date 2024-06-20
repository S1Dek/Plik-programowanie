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
if (empty($cart)) {
    header('Location: cart.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user']['id'];
    $total = array_reduce($cart, function($sum, $product) {
        return $sum + $product['price'];
    }, 0);

    $orderId = createOrder($userId, $total);
    if ($orderId) {
        foreach ($cart as $product) {
            addOrderItem($orderId, $product['id'], 1, $product['price']);
        }
        unset($_SESSION['cart']);
        header('Location: order_success.php');
        exit();
    } else {
        $error = "Wystąpił problem podczas składania zamówienia.";
    }
}
?>

<h2>Podsumowanie zamówienia</h2>
<table>
    <tr>
        <th>Nazwa</th>
        <th>Opis</th>
        <th>Cena</th>
    </tr>
    <?php foreach ($cart as $product): ?>
    <tr>
        <td><?php echo htmlspecialchars($product['name']); ?></td>
        <td><?php echo htmlspecialchars($product['description']); ?></td>
        <td><?php echo htmlspecialchars($product['price']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><strong>Łączna kwota: </strong><?php echo array_reduce($cart, function($sum, $product) { return $sum + $product['price']; }, 0); ?> PLN</p>

<form method="post">
    <button type="submit">Zamów</button>
</form>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
