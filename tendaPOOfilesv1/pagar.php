<?php
session_start();
unset($_SESSION['cesta']);
die("Gracias pola súa compra.<br />Quere <a href='produtos.php'>comenzar de novo</a>?");
?>
