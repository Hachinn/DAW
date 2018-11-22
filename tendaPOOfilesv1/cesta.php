<?php
require_once ('modelo/CestaCompra.php');

session_set_cookie_params(0);
session_start();
if (isset($_SESSION['usuario'])){
    $usuario=$_SESSION['usuario'];
    $cesta = CestaCompra::cargaCesta();
    
    if (isset($_POST['eliminar'])) {
        $cesta->removeProduto(Modelo::getProduto($_POST['cod']));
    }  
}else{
    header("Location: login.php");
}
?>
<?php 
echo "<form  action='logoff.php' method='post'>";
echo "Ola $usuario! &nbsp;&nbsp; <input type='submit' name ='sair' value='Pechar Sesion'>";
echo "</form>";


if (!$cesta->estaVacia()){
    $produtosCesta = $cesta->getProdutos();
    echo "Cesta";
    echo "<table><tr><td>Codigo</td><td>Nome</td><td>Uds</td><td>Prezo</td><td></td></tr>";
    foreach  ($produtosCesta as $produto) {
        echo "<tr><td>{$produto->getCodigo()}</td><td>{$produto->getNome_Corto()}</td><td>{$cesta->getUnidades($produto)}</td><td>{$produto->getPVP()} €</td>";
        echo "<td><form id ='".$produto->getCodigo()."' action=".$_SERVER['PHP_SELF']." method='post'>";
        echo "\n<input type='hidden' name='cod' value='{$produto->getCodigo()}'>";
        echo "<input type='submit' name='eliminar' value='Eliminar'>";
        echo "</form></td>";
        echo "</tr>";
    }
    echo "<tr><td></td><td></td><td>Total</td><td>{$cesta->getPrezo()} €</td></tr>";
    echo "</table>";   
    
    echo "<form  action='pagar.php' method='post'>";
    echo "<input type='submit' name ='pagar' value='Pagar'>";
    echo "</form>";
    echo "<form  action='produtos.php' method='post'>";
    echo "<input type='submit' name ='' value='Continuar enchendo a Cesta'>";
    echo "</form>";
    echo "<br>";
   
}else {
    header("Location: produtos.php");
}

?>