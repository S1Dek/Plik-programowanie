<?php
session_start();
require_once "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = new mysqli($db_domain, $db_login, $db_password, $db_name);
    if ($connect->connect_errno) {
        echo "Error: " . $connect->connect_error;
        exit();
    }

    $table = $_POST['table'];

    //aktualizacja istniejących rekordów
    if (!empty($_POST['values'])) {
        $values = $_POST['values'];

        foreach ($values as $firstColumnValue => $columns) {
            $updates = [];
            foreach ($columns as $column => $value) {
                $updates[] = "$column='" . $connect->real_escape_string($value) . "'";
            }
            $updateString = implode(', ', $updates);//Łączy elementy tablicy w ciąg znaków
            $firstColumn = array_key_first($columns);//Pobiera pierwszy klucz tablicy

            $sql = "UPDATE $table SET $updateString WHERE $firstColumn = '" . $connect->real_escape_string($firstColumnValue) . "'";
            if ($connect->query($sql) === TRUE) {
                //Rekord zaktualizowany pomyślnie.";
            } else {
                echo "Error: " . $connect->error;
            }
        }
    }

    //dodawanie nowego rekordu jeśli są
    if (!empty($_POST['new_values'])) {
    $newValues = $_POST['new_values'];

    //Sprawdzanie czy wszystkie pola są wypełnione
    if (in_array('', $newValues)) {
        exit();
    }

    $columns = array_keys($newValues);
    $values = array_values($newValues);

    $columnsString = implode(", ", $columns);
    $valuesString = implode(", ", array_map(function($value) use ($connect) 
    {
        return "'" . $connect->real_escape_string($value) . "'";
    }, $values)
);

    $sql = "INSERT INTO $table ($columnsString) VALUES ($valuesString)";
    if ($connect->query($sql) === TRUE) {
        echo "Dodano rekord";
    } else {
        echo "Error: " . $connect->error;
    }
}


    $connect->close();
    header("Location: admin.php");
    exit();
} else {
    echo "błąd przesyłu danych";
    exit();
}
?>
