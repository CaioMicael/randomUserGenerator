<?php
namespace controller;

use lib\estClassController;
use model\ClassModelEstado;

require_once '../autoload.php';


class ClassControllerEstado extends estClassController {
    private object $modelEstado;
    private object $controllerPais;


    public function __construct() {
        $this->modelEstado    = new ClassModelEstado;
        $this->controllerPais = new ClassControllerPais;
    }


    /**
     * Este método retorna os dados de Estado do Model.
     * 
     * @return array
     */
    private function getDadosConsultaEstadoFromModel() {
        return $this->modelEstado->getDadosConsultaEstado(15);
    }


    /**
     * Esta função realiza o mapeamento entre as chaves do banco e as que devem aparecer na viewEstado.
     * 
     * @param  array $aDados
     * @return array
     */
    private function trataDadosConsultaEstado($aDados) {
        $aMapaChave = array_merge($this->getMapaChaveColunasEstado(),
                                  $this->controllerPais->getMapaChaveColunasPais());
        return $this->trataDadosConsultaChave($aMapaChave, $aDados);
    }


    /**
     * Este método retorna um array com os dados 
     * do Estado tratados, prontos pra view.
     * 
     * @return array
     */
    public function getDadosConsultaEstadoController() {
        return $this->trataDadosConsultaEstado($this->getDadosConsultaEstadoFromModel());
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