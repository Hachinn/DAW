<?php
include 'modelo/Modelo.php';

/*
echo '<pre>';
print_r(Modelo::getProdutos());
echo '</pre>';

*/

if (Modelo::verificaCliente("xan", "abc123.") ) echo "Ok";

?>