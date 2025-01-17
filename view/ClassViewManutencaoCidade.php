<?php
namespace view;

use controller\ClassControllerCidade;
use lib\estClassViewManutencao;

require_once '../autoload.php';


class ClassViewManutencaoCidade extends estClassViewManutencao {
    private object $controllerCidade;


    public function __construct() {
        $this->controllerCidade = new ClassControllerCidade;
    }


    public function criaTabelaConsultaCidade() {
        return $this->createTable('Cidades Cadastradas', $this->controllerCidade->getDadosConsultaCidadeController());
    }
}

$teste = new ClassViewManutencaoCidade;
echo $teste->criaTabelaConsultaCidade();

?>