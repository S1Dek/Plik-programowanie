<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'administrator' && $_SESSION['user']['role'] !== 'moderator')) {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

$product = getProductById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    if (updateProduct($product['id'], $name, $description, $price, $image_url)) {
        header('Location: manage_products.php');
        exit();
    } else {
        $error = "Edycja produktu nie powiodła się.";
    }
}
?>

<h2>Edytuj produkt</h2>

<form method="post">
    <label for="name">Nazwa produktu:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    <label for="description">Opis produktu:</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
    <label for="price">Cena:</label>
    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
    <label for="image_url">URL obrazka:</label>
    <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>">
    <button type="submit">Zapisz zmiany</button>
</form>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
