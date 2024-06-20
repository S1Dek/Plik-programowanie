<?php
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (registerUser($username, $email, $password, $role)) {
        header('Location: view_users.php');
        exit();
    } else {
        $error = "Dodanie użytkownika nie powiodło się.";
    }
}
?>

<h2>Dodaj użytkownika</h2>

<form method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required>
    <label for="role">Rola:</label>
    <select id="role" name="role">
        <option value="user">Użytkownik</option>
        <option value="moderator">Moderator</option>
        <option value="administrator">Administrator</option>
    </select>
    <button type="submit">Dodaj użytkownika</button>
</form>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
