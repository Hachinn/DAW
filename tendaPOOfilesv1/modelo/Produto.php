<?php
class Produto {
    private $codigo;
    private $nome_corto;
    private $PVP;
    
    public function __construct($fila) {
        $this->codigo = $fila['cod'];
        $this->nome_corto = $fila['nome_corto'];
        $this->PVP = $fila ['PVP'];
    }
    public function getCodigo() {return $this->codigo;}
    public function getNome_Corto() {return $this->nome_corto;}
    public function getPVP() {return $this->PVP;}
    public function mostra() {
        print '<p>'.$this->codigo.'</p>';
    }  
}