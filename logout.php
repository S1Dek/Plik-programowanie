<?php
session_start();
session_unset();
session_destroy();
header('Location: /sklep-internetowy/login.php');
exit();
?>
