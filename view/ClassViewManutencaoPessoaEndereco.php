<?php
namespace view;

use controller\ClassControllerPessoaEndereco;
use lib\estClassViewManutencao;
use lib\estClassEnumAcoes;

require_once '../autoload.php';


class ClassViewManutencaoPessoaEndereco extends estClassViewManutencao {
    private object $controllerPessoaEndereco;


    public function __construct() {
        $this->controllerPessoaEndereco = new ClassControllerPessoaEndereco;
    }


    public function getConsultaPessoaEnderecoView() {
        return $this->createTable('Consulta de Endereço de Pessoa', $this->controllerPessoaEndereco->getConsultaEnderecoController(), [estClassEnumAcoes::INCLUIR, estClassEnumAcoes::ALTERAR, estClassEnumAcoes::EXCLUIR]);
    }
}
$teste = new ClassViewManutencaoPessoaEndereco;
echo $teste->getConsultaPessoaEnderecoView();
echo '<script type="module" src="viewComportamento/classViewComportamentoPessoaEndereco.js"></script>';
?>