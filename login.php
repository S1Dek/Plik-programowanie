<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = loginUser($username, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        if ($user['role'] == 'administrator') {
            header('Location: /sklep-internetowy/admin/index.php');
        } elseif ($user['role'] == 'moderator') {
            header('Location: /sklep-internetowy/admin/manage_products.php');
        } else {
            header('Location: /sklep-internetowy/user/index.php');
        }
        exit();
    } else {
        $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2>Logowanie</h2>

<form method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" required>
    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Zaloguj się</button>
</form>

<?php if (isset($error)): ?>
<script>
    alert("<?php echo $error; ?>");
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
