<?php
namespace controller;

use lib\estClassController;
use model\ClassModelCidade;
use controller\ClassControllerEstado;
use controller\ClassControllerPais;

require_once '../autoload.php';


class ClassControllerCidade extends estClassController {
    private object $modelCidade;
    private object $controllerEstado;
    private object $controllerPais;


    public function __construct() {
        $this->modelCidade      = new ClassModelCidade;
        $this->controllerEstado = new ClassControllerEstado;
        $this->controllerPais   = new ClassControllerPais;
    }


    /**
     * Este método busca os dados de cidade do model.
     * 
     * @return array
     */
    private function getDadosConsultaCidadeFromModel() {
        return $this->modelCidade->getDadosConsultaCidade(25);
    }


    /**
     * Este método é responsável por tratar os dados vindo do model.
     * 
     */
    private function trataDadosConsultaCidade($aDados) {
        $aMapaChave = array_merge($this->getMapaChaveColunasCidade(), 
                                  $this->controllerEstado->getMapaChaveColunasEstado(), 
                                  $this->controllerPais->getMapaChaveColunasPais());
       return $this->trataDadosConsultaChave($aMapaChave, $aDados);
    }


    /**
     * Este método retorna os dados de consulta pessoa tratados.
     * 
     * @return array
     */
    public function getDadosConsultaCidadeController() {
        return $this->trataDadosConsultaCidade($this->getDadosConsultaCidadeFromModel());
    }


    /**
     * Este método contém um array com o mapeamento entre a chave do banco
     * e a forma que deve aparecer na view.
     * 
     * @return array
     */
    private function getMapaChaveColunasCidade() {
        return [
            "cidadecodigo" => "Código da Cidade",
            "cidadenome"   => "Nome da Cidade",
            "estadocodigo" => "Código do Estado",
            "paiscodigo"   => "Código do País"
        ];
    }

}


?>