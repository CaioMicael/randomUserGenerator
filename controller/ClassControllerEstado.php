<?php
namespace controller;

use model\ClassModelEstado;

require_once '../autoload.php';


class ClassControllerEstado {
    private object $modelEstado;


    public function __construct() {
        $this->modelEstado = new ClassModelEstado;
    }


    /**
     * Este método contém um array com o mapeamento entre a chave do banco
     * e a forma que deve aparecer na view.
     * 
     * @return array
     */
    public function getMapaChaveColunasEstado() {
        return [
            "estadocodigo" => "Código do Estado",
            "paiscodigo"   => "Código do País",
            "estadonome"   => "Nome do Estado"
        ];
    }
}

?>