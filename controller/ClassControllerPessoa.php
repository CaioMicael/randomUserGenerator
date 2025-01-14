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
    public function getDadosConsultaPessoaFromModel() {
        return $this->modelPessoa->getDadosConsultaPessoa(25);
    }

}

?>