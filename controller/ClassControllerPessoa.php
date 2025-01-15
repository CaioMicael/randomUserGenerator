<?php
namespace controller;

use model\ClassModelPessoa;

require_once '../autoload.php';

class ClassControllerPessoa {
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
        $mapaChave     = $this->getMapaChaveColunasBD();
        //var_dump($mapaChave);
        //echo '<br>';
        //var_dump($aDados);
        $aDadosTratado = array();
        foreach($aDados as $aDadosArray) {
            $novoRegistro = [];

            foreach($aDadosArray as $chave => $valor) {
                $novaChave = isset($mapaChave[$chave]) ? $mapaChave[$chave] : $chave;
                $novoRegistro[$novaChave] = $valor;
            }
            $aDadosTratado[] = $novoRegistro;
        }
        return $aDadosTratado;
    }


    /**
     * Este método retorna os dados de consulta pessoa tratados.
     * 
     * @return array
     */
    public function getDadosConsultaPessoa() {
        return $this->trataDadosConsultaPessoa($this->getDadosConsultaPessoaFromModel());
    }


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