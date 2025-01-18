<?php
namespace controller;

use lib\estClassController;
use model\ClassModelPessoaEndereco;

require_once '../autoload.php';


class ClassControllerPessoaEndereco extends estClassController {
    private object $modelEndereco;
    private object $controllerPais;
    private object $controllerEstado;
    private object $controllerCidade;


    public function __construct() {
        $this->modelEndereco    = new ClassModelPessoaEndereco;
        $this->controllerPais   = new ClassControllerPais;
        $this->controllerCidade = new ClassControllerCidade;
        $this->controllerEstado = new ClassControllerEstado;
    }


    /**
     * Este método retorna os dados de consulta de endereço do model.
     * 
     * @return array
     */
    private function getDadosConsultaEnderecoFromModel() {
        return $this->modelEndereco->getDadosConsultaEndereco(15);
    }


    /**
     * Este método realiza o tratamento dos dados da consulta endereço 
     * conforme chaves passadas.
     * 
     * @param array $aDados
     * @return array
     */
    private function trataDadosConsultaEndereco($aDados) {
        $aMapaChave = array_merge($this->getMapaChaveColunasEndereco(),
                                  $this->controllerPais->getMapaChaveColunasPais(),
                                  $this->controllerEstado->getMapaChaveColunasEstado(),
                                  $this->controllerCidade->getMapaChaveColunasCidade());
        return $this->trataDadosConsultaChave($aMapaChave, $aDados);
    }


    /**
     * Este método retorna um array da consulta de endereço tratado.
     * 
     * @return array
     */
    public function getConsultaEnderecoController() {
        return $this->trataDadosConsultaEndereco($this->getDadosConsultaEnderecoFromModel());
    }


    /**
     * Este método contém um array com o mapeamento entre a chave do banco
     * e a forma que deve aparecer na view.
     * 
     * @return array
     */
    private function getMapaChaveColunasEndereco() {
        return [
            "pesenderecocodigo"    => "Código do Endereço",
            "cidadecodigo"         => "Código da Cidade",
            "pesenderecorua"       => "Rua",
            "pesenderonumero"      => "Número",
            "pesenderecolatitude"  => "Latitude",
            "pesenderecolongitude" => "Longitude",
            "pescodigo"            => "Código Pessoa"
        ];
    }


}

?>