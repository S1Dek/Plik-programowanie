<?php
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

$user_id = $_GET['id'];
$user = getUserById($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (updateUser($user_id, $username, $email, $role)) {
        header('Location: view_users.php');
        exit();
    } else {
        $error = "Edycja użytkownika nie powiodła się.";
    }
}
?>

<h2>Edytuj użytkownika</h2>

<form method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <label for="role">Rola użytkownika:</label>
    <select id="role" name="role">
        <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>Użytkownik</option>
        <option value="moderator" <?php if ($user['role'] === 'moderator') echo 'selected'; ?>>Moderator</option>
        <option value="administrator" <?php if ($user['role'] === 'administrator') echo 'selected'; ?>>Administrator</option>
    </select>
    <button type="submit">Edytuj użytkownika</button>
</form>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
