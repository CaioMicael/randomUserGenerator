<?php
namespace view;

use controller\ClassControllerPessoaEndereco;
use lib\estClassViewManutencao;

require_once '../autoload.php';


class ClassViewManutencaoPessoaEndereco extends estClassViewManutencao {
    private object $controllerPessoaEndereco;


    public function __construct() {
        $this->controllerPessoaEndereco = new ClassControllerPessoaEndereco;
    }


    public function getConsultaPessoaEnderecoView() {
        return $this->createTable('Consulta de Endereço de Pessoa', $this->controllerPessoaEndereco->getConsultaEnderecoController());
    }
}
$teste = new ClassViewManutencaoPessoaEndereco;
echo $teste->getConsultaPessoaEnderecoView();

?>