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

// Pobranie listy tabel z bazy danych
$tables = $connect->query("SHOW TABLES");
if (!$tables) {
    echo "Error: " . $connect->error;
    exit();
}

// Wyświetlenie formularzy dla każdej tabeli
echo '<div id="main">';
echo '<h1>Panel administracyjny</h1>';
while ($row = $tables->fetch_row()) {
    $table_name = $row[0];
    echo "<h2>Tabela: $table_name</h2>";

    $sql = "SHOW COLUMNS FROM $table_name";
    $sql1 = "SELECT * FROM $table_name";
    $result = mysqli_query($connect, $sql);
    $result1 = mysqli_query($connect, $sql1);
    $columns = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $columns[] = $row['Field'];
    }
    echo "<br><form action='update.php' method='post'>
            <input type='hidden' name='table' value='$table_name'>
            <table border='1'>
                <thead>
                    <tr>
                        <th>Zarządzanie</th>";
    foreach ($columns as $column) {
        echo "<th>$column</th>";
    }
    echo "</tr>
                </thead>
                <tbody>";
    while ($row = mysqli_fetch_assoc($result1)) {
        $firstColumn = reset($columns);
        echo "<tr>
                <td>
                    <button type='submit' name='save' value='{$row[$firstColumn]}'>Zapisz</button>
                    <a href='delete.php?table=$table_name&firstcolumn={$row[$firstColumn]}' onclick='return confirm('Czy na pewno chcesz usunąć ten rekord?');' style='text-decoration: none; color: inherit;'>Usuń</a>
                </td>";
        foreach ($columns as $column) {
            echo "<td><input type='text' name='values[{$row[$firstColumn]}][{$column}]' value='{$row[$column]}'></td>";
        }
        echo "</tr>";
    }

    // Dodaj pusty wiersz do dodawania nowych rekordów
    echo "<tr>
            <td>
                <button type='submit' name='save_new'>Zapisz Nowy</button>
            </td>";
    foreach ($columns as $column) {
        echo "<td><input type='text' name='new_values[{$column}]' value=''></td>";
    }
    echo "</tr>";

    echo "</tbody>
            </table>
        </form>";
}
echo '</div>';
?>
</body>
</html>
