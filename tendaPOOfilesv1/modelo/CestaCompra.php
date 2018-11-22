<?php
require_once 'Modelo.php';
class CestaCompra {

    private $produtos; // array de produtos indexado polo código de produto
    private $unidadesProdutos; // array de unidades indexado polo código de produto
    
    public function addProduto($produto, $unidades){
        // se $produto xa está na cesta incrementa as unidades en $unidades
        // se non está engadeo con $unidades unidades
        // 
        if (!$this->estaVacia() &&array_key_exists($produto->getCodigo(), $this->produtos)) {
                $this->unidadesProdutos["{$produto->getCodigo()}"] += $unidades;
           }else {
               $this->produtos["{$produto->getCodigo()}"]=$produto;
                $this->unidadesProdutos["{$produto->getCodigo()}"]=$unidades;
          }  
    }
    public function getProdutos() {
        return $this -> produtos;    
    }
    public function removeProduto($produto) {
        // elimina un produto da cesta
        if (!$this->estaVacia()) {
            if (array_key_exists($produto->getCodigo(), $this->produtos)) {
                unset ($this->produtos["{$produto->getCodigo()}"]);
                unset ($this->unidadesProdutos["{$produto->getCodigo()}"]);
            } 
        }    
    }
    public function getPrezo() {
        // devolve o prezo total da cesta
        $prezo=0;
        foreach ($this->produtos as $produto) {
            $prezo += $produto->getPVP() * $this->unidadesProdutos["{$produto->getCodigo()}"];
        }
        return $prezo;
    }
    public function estaVacia() {
        // devolve true se a cesta esta baleira
        return (count ($this->produtos) == 0);
    }
    public function getUnidades($produto) {
        // devolve as unidades dun produto
        return $this->unidadesProdutos["{$produto->getCodigo()}"];
    }

    public function gardaCesta() {
        // garda a cesta na sesión (en $_SESSION['cesta'])
        $_SESSION['cesta'] = $this;
    }
    public static function cargaCesta() {
        // recupera a cesta dende a sesión (dende $_SESSION['cesta']) (ollo, é static)
        if (!isset($_SESSION['cesta'])) {return new CestaCompra();}
        else {return ($_SESSION['cesta']);}
    }
}