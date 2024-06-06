<?php
session_start();
require_once "connect.php";

if (!isset($_SESSION['name'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['table']) && isset($_GET['firstcolumn'])) {
    $table = $_GET['table'];
    $firstColumnValue = $_GET['firstcolumn'];

    //Connect z bazą
    $connect = new mysqli($db_domain, $db_login, $db_password, $db_name);
    if ($connect->connect_errno) {
        echo "Error: " . $connect->connect_error;
        exit();
    }

    //Pobranie pierwszej kolumny
    $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'";
    $result = $connect->query($sql);
    if (!$result) {
        echo "Error: " . $connect->error;
        exit();
    }
    $primaryKey = $result->fetch_assoc()['Column_name'];

    //Usuwanie rekordu zbazy
    $sql = "DELETE FROM $table WHERE $primaryKey = ?";
    $stmt = $connect->prepare($sql); //Zabezpieczenie przed SQLinjection
    if (!$stmt) {
        echo "Error: " . $connect->error;
        exit();
    }
    $stmt->bind_param('s', $firstColumnValue); //Przypisywanie wartości s-string do placeholdera
    if ($stmt->execute()) {
        echo "Rekord został pomyślnie usunięty.";
    } else {
        echo "Błąd przy usuwaniu rekordu: " . $stmt->error;
    }
    $stmt->close();
    $connect->close();
} else {
    echo "Nieprawidłowe dane.";
}
?>