<?php
require_once 'modelo/CestaCompra.php';
require_once 'modelo/Modelo.php';

session_set_cookie_params(0);
session_start();
$cesta = CestaCompra::cargaCesta();
if (isset($_SESSION['usuario'])){
     $usuario=$_SESSION['usuario'];
  
     if (isset($_POST['engadir'])) {
         $cesta->addProduto(Modelo::getProduto($_POST['codProduto']),$_POST['unidades']);
         $cesta->gardaCesta();
     }
     if (isset($_POST['vaciar'])) {
         unset($_SESSION['cesta']);
         $cesta = new CestaCompra();
     }
     if (isset($_POST['eliminar'])) {
         $cesta->removeProduto(Modelo::getProduto($_POST['cod']));
     }
     if (isset($_POST['comprar'])) {
         $cesta->gardaCesta();
         header("Location: cesta.php");
     } 
 }else{
     header("Location: login.php");
 }
 ?>
 <?php
 echo "<form  action='logoff.php' method='post'>";
 echo "Ola $usuario! &nbsp;&nbsp; <input type='submit' name ='sair' value='Pechar Sesion'>";
 echo "</form>";
 
 if  (!$cesta->estaVacia()){
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
     echo "<form  action=".$_SERVER['PHP_SELF']." method='post'>";
     echo "<input type='submit' name ='vaciar' value='Vaciar Cesta'>";
     echo "<br><br>";
     echo "<input type='submit' name ='comprar' value='Comprar'>";
     echo "</form>";
     echo "<br>";
 } 

 $mensaxe="";
 if (($produtos=Modelo::getProdutos())!== false){
     
     echo "\n<table><tr><td>Codigo</td><td>Nome</td><td>PVP</td></tr>";
     foreach ($produtos as $produto) {
         echo "<form id =".$produto->getCodigo()." action=".$_SERVER['PHP_SELF']." method='post'>";
         echo "\n<tr><td>{$produto->getCodigo()}</td><td>{$produto->getNome_Corto()}</td>";
         echo "<td>{$produto->getPVP()} €</td>";
         echo "\n<input type='hidden' name='codProduto' value='".$produto->getCodigo()."' >";
         echo "\n<input type='hidden' name='nome' value='".$produto->getNome_Corto()."' >";
         echo "\n<input type='hidden' name='pvp' value='".$produto->getPVP()."'>";
         echo "\n<td><input type='number' min='1' max='999' value='1'  name='unidades'></td>";
         echo "\n<td><input type='submit' name='engadir' value='Engadir'></td></tr>"; 
         echo "\n</form>";
     }
     echo "\n</table>";
 }else {
     $mensaxe ="Erro ao recuperar os produtos";
 }

if (isset($mensaxe)){echo $mensaxe;}
?>