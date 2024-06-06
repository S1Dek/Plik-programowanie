<?php
$name=$_SESSION['name'];
?>
<div id='navigation'>
    <ol>
        <li class='li_drop'><a class='nav' href='main.php'>Strona Główna</a></li>
        <li class='li_drop'><a class='nav' href='user.php'><?php echo $name ?></a></li>
        <li class='li_drop'><a class="shopping"><img src="images/cart.png" height="200%"><span class="quantity">0</span></a></li>
        <li class='li_drop'><a class='nav' href='logout.php'>Wyloguj się</a></li>
    </ol>
</div>
</div>