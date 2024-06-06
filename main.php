<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Internetowy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
require_once "navigation.php";

if (!isset($_SESSION['name'])) {
    header('Location: index.php');
    exit();
}

// pobierz nazwę użytkownika z sesji
$name = $_SESSION['name'];
?>
<div id="main">
    <?php 
    require_once "connect.php"; 
    $connect = @new mysqli($db_domain, $db_login, $db_password, $db_name);
    if($connect->connect_errno!=0){ //sprawdzenie czy polaczenie sie nie udało            
        echo "Error;" . $connect->connect_errno;
    } else {
        $sql = "SELECT * FROM products"; //pobieranie produktów z bazy
        $result = @$connect->query($sql);    //wysłanie zapytania do bazy        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $product = array(
                    'id' => $row['id_products'],
                    'name' => $row['name'],
                    'price' => $row['price']
                );
                $products[] = $product; // dodajemy produkt do tablicy
            }
        }
    ?>
    <script>
        var products = <?php echo json_encode($products); ?>; // przekazujemy produkty do zmiennej JavaScript
    </script>
    <?php }
    // Pobranie danych użytkownika z bazy danych
    $sql = "SELECT role FROM accounts WHERE name='$name'";
    $result = $connect->query($sql);
    if (!$result) {
        echo "Error: " . $connect->error;
        exit();
    }
    $role = $result->fetch_assoc()['role'];
    ?>
    <div class="list">
    <?php
    ?>
    <script>  var role = <?php echo json_encode($role); ?>; // przekazujemy role do zmiennej JavaScript</script>
    </div>
    <div class="card">
        <h1>Koszyk</h1>
        <ul class="listCard">
        </ul>
        <div class="checkOut">
            <div class="total">0</div>
            <div class="closeShopping">Zamknij</div>
            <script src="app.js"></script>
        </div>
    </div>
</div>
</body>
</html>
