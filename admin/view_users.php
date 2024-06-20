<?php
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

$users = getAllUsers();
?>

<h2>Użytkownicy</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nazwa użytkownika</th>
        <th>Email</th>
        <th>Rola</th>
        <th>Akcje</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edytuj</a>
                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">Usuń</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
