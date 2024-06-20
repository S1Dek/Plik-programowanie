<?php
include '../includes/db.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'administrator') {
    header('Location: /sklep-internetowy/login.php');
    exit();
}

$user_id = $_GET['id'];

if (deleteUser($user_id)) {
    header('Location: view_users.php');
    exit();
} else {
    $error = "Usunięcie użytkownika nie powiodło się.";
}
?>

<?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
