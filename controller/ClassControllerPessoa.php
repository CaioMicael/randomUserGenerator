<?php
namespace controller;

use model\ClassModelPessoa;
use lib\estClassController;

require_once '../autoload.php';

/**
 * Esta classe é responsável por controlar as ações da pessoa.
 * @package webbased
 * @subpackage controller
 * @author Caio Micael Krieger
 * @since 17/01/2025
 */
class ClassControllerPessoa extends estClassController {
    private object $modelPessoa;

    public function __construct() {
        $this->modelPessoa = new ClassModelPessoa;
    }


    /**
     * Este método retorna os dados da consulta de pessoa do model.
     * 
     * @return array
     */
    private function getDadosConsultaPessoaFromModel() {
        return $this->modelPessoa->getDadosConsultaPessoa(25);
    }


    /**
     * Este método é responsável por tratar os dados vindos do Model da consulta de pessoa.
     * 
     * @param array $aDados
     * @return array
     */
    private function trataDadosConsultaPessoa($aDados) {
        $aMapaChave = $this->getMapaChaveColunasBD();
        return $this->trataDadosConsultaChave($aMapaChave, $aDados);
    }


    /**
     * Este método retorna os dados de consulta pessoa tratados.
     * 
     * @return array
     */
    public function getDadosConsultaPessoa() {
        return $this->trataDadosConsultaPessoa($this->getDadosConsultaPessoaFromModel());
    }


    /**
     * Esta função realiza o mapeamento entre as chaves do banco e as que devem aparecer na view.
     * 
     * @return array
     */
    public function getMapaChaveColunasBD() {
        return [
            "pescodigo" => "Código Pessoa",
            "seed"      => "Semente",
            "pesgenero" => "Gênero Pessoa",
            "pesnome"   => "Nome Pessoa",
            "pesmail"   => "Email Pessoa",
            "pesphone"  => "Telefone Pessoa",
            "pescell"   => "Celular Pessoa"
        ];
    }

}

?>