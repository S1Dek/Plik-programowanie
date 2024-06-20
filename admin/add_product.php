<?php
session_start();
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'administrator' && $_SESSION['user']['role'] !== 'moderator')) {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    if (addProduct($name, $description, $price, $image_url)) {
        header('Location: manage_products.php');
        exit();
    } else {
        $error = "Dodanie produktu nie powiodło się.";
    }
}
?>

<h2>Dodaj nowy produkt</h2>

<form method="post">
    <label for="name">Nazwa produktu:</label>
    <input type="text" id="name" name="name" required>
    <label for="description">Opis produktu:</label>
    <textarea id="description" name="description" required></textarea>
    <label for="price">Cena:</label>
    <input type="text" id="price" name="price" required>
    <label for="image_url">URL obrazka:</label>
    <input type="text" id="image_url" name="image_url">
    <button type="submit">Dodaj produkt</button>
</form>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
