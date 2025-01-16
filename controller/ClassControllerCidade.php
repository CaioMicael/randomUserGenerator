<?php
namespace controller;

use lib\estClassController;
use model\ClassModelCidade;

require_once '../autoload.php';


class ClassControllerCidade extends estClassController {
    private object $modelCidade;


    public function __construct() {
        $this->modelCidade = new ClassModelCidade;
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
     * Este método é responsável por tratar os dados 
     */
    private function trataDadosConsultaCidade() {
        $this->trataDadosConsultaChave($this->getDadosConsultaCidadeFromModel());
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