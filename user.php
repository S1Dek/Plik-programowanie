<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Panel zmiany hasła</title>
</head>
<body>
<?php 
session_start();
require_once "navigation.php";

// Połączenie z bazą danych
require_once "connect.php";
$connect = new mysqli($db_domain, $db_login, $db_password, $db_name);
if ($connect->connect_errno) {
    echo "Error: " . $connect->connect_error;
    exit();
}

// Pobranie danych użytkownika z bazy danych
if (!isset($_SESSION['name'])) {
    header('Location: index.php');
    exit();
}
$name = $_SESSION['name'];
$sql = "SELECT * FROM accounts WHERE name='$name'";
$result = $connect->query($sql);
if (!$result) {
    echo "Error: " . $connect->error;
    exit();
}
$user = $result->fetch_assoc();

// obsługa zmiany hasła
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    
    // Sprawdzenie czy stare hasło jest poprawne
    if ($old_password == $user['password']) {
        // Zaktualizowanie hasła w bazie danych
        $update_sql = "UPDATE accounts SET password='$new_password' WHERE name='$name'";
        $update_result = $connect->query($update_sql);
        if (!$update_result) {
            echo "Błąd podczas zmiany hasła: " . $connect->error;
            exit();
        } else {
            echo "Zmieniono hasło!";
        }
    } else {
        echo "Niepoprawne stare hasło!";
    }
}
?>
<div id="main">
    <h1>Panel zmiany hasła</h1>
    <h2>Zmień hasło</h2>
    <form method="post">
        <label for="old_password">Stare hasło:</label><br>
        <input type="password" id="old_password" name="old_password" required><br>
        <label for="new_password">Nowe hasło:</label><br>
        <input type="password" id="new_password" name="new_password" required><br>
        <input type="submit" name="change_password" value="Zmień hasło">
    </form>
    <?php
        if(isset($_SESSION['name']) && $_SESSION['name'] === 'Admin') {
            // Jeśli tak, ustaw zmienną, która pokaże przycisk panelu administratora
            $adminButton = '<a href="admin.php"><input type="submit" value="Panel administratora"></a>';
        } else {
            // Jeśli nie, nie wyświetlaj przycisku
            $adminButton = '';
        }
        echo $adminButton;
    ?>
</div>
</body>
</html>
