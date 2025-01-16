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


    /**
     * Método responsável por carregar uma tabela com 15 registros de pessoas.
     * 
     * @return html
     */
    public function criaTabelaConsultaDadosPessoa() {
        return $this->createTable('Consulta Pessoa',$this->controllerPessoa->getDadosConsultaPessoa());
    }
}

$teste = new ClassViewManutencaoPessoa;
echo $teste->criaTabelaConsultaDadosPessoa();
?>