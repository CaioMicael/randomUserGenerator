<?php
namespace view;

use controller\ClassControllerPessoa;
use lib\estClassViewManutencao;

require_once '../autoload.php';

class ClassViewManutencaoPessoa extends estClassViewManutencao {
    public object $controllerPessoa;


    public function __construct() {
        $this->controllerPessoa = new ClassControllerPessoa;
    }


    public function criaTabelaConsultaDadosPessoa() {
        return $this->createTable('Consulta Pessoa',$this->controllerPessoa->getDadosConsultaPessoa());
    }
}

$teste = new ClassViewManutencaoPessoa;
echo $teste->criaTabelaConsultaDadosPessoa();
?>