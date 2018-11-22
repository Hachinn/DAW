<?php
require_once 'config.php';
require_once  'Produto.php';
class Modelo {
    
    public static function getProdutos() {
        if (($produtosFich = file_get_contents(PRODUCTS_FILENAME)) !== false) {
            $produtos = array();
            $produtosArray=array();
            $produtosArray = json_decode($produtosFich, true);
            foreach ($produtosArray as $indice=>$arrayProduto) {
                $produto = new Produto($arrayProduto);
                $produtos[]=$produto;
            }
            return $produtos;
        }else {
            return false;
        }
    }
    public static function getProduto($cod) {
        $produtos = self::getProdutos();
        foreach ($produtos as $produto) {
            if (($produto->getCodigo())== $cod) {
                return $produto;
            }
        }
        return false;
    }
    public static function verificaUsuario($usuario, $contrasinal) {
      if (file_exists(USERS_FILENAME)) {  
        $usuariosFich = json_decode(file_get_contents(USERS_FILENAME), true);
        $usuarioAtopado=false;
        foreach ($usuariosFich as $usuarioFich) {
            if ($usuarioFich['user'] == $usuario) {
                $usuarioAtopado = 
                array ("user"=>$usuarioFich['user'],"pass" =>$usuarioFich['pass']);
            }
        }
        if ($usuarioAtopado){
            if(password_verify($contrasinal, $usuarioAtopado['pass'])){
                return true; 
            }else {
                return false;
            }
        }
      }else return false;   
    } 
}
?>