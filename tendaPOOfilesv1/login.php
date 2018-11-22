<?php
require_once 'modelo/Modelo.php';
$erro=0;
$mensaxe="";
if (isset ($_POST['enviarLogin'])){
    if ((!empty($_POST['usuario']))&&(!empty($_POST['contrasinal']))) {
        $usuario=$_POST['usuario']; $contrasinal=$_POST['contrasinal'];
            if (Modelo::verificaUsuario($usuario, $contrasinal)) {
                session_set_cookie_params(0);
                session_start();
                $_SESSION['usuario']=$usuario;
                header("Location: produtos.php");
            }else {
                $erro=1;
                $mensaxe="Usuario ou contrasinal incorrectos";
            }       
    }else {
        $erro=2;
        $mensaxe="Debe introducir usuario e contrasinal";
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
Usuario:<input type="text" name="usuario"><br><br>
Contrasinal:<input type="password" name="contrasinal"><br><br>
<input type="submit" name="enviarLogin" value="Entrar">
</form>

<?php 
if (($produtos = Modelo::getProdutos())!== false){

    echo "\n<br><br>Produtos para mercar:<br><br>";
    echo "\n<table><tr><td>Codigo</td><td>Nome</td><td>PVP</td></tr>";
    foreach ($produtos as $produto) {
        echo "\n<tr><td>{$produto->getCodigo()}</td><td>{$produto->getNome_Corto()}</td>";
        echo "<td>{$produto->getPVP()} €</td>";
    }
    echo "\n</table>";
}else {
    $mensaxe ="Erro ao recuperar os produtos";
}
if (isset($mensaxe)){echo '<br><br>'.$mensaxe;}

?>











