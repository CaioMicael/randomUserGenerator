<?php
namespace controller;

use model\ClassModelPais;

require_once '../autoload.php';


class ClassControllerPais {
    private object $modelPais;


    public function __construct() {
        $this->modelPais = new ClassModelPais;
    }


    /**
     * Este método contém um array com o mapeamento entre a chave do banco
     * e a forma que deve aparecer na view.
     * 
     * @return array
     */
    public function getMapaChaveColunasPais() {
        return [
            "paiscodigo" => "Código do País",
            "paisnome"   => "Nome do País"
        ];
    }
}


?>