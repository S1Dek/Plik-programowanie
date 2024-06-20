<?php
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (registerUser($username, $email, $password)) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Rejestracja nie powiodła się.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Rejestracja</h2>

<form method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Zarejestruj się</button>
</form>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
