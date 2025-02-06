<?php
namespace view;

use controller\ClassControllerPessoaEndereco;
use lib\estClassViewManutencao;
use lib\enum\estClassEnumAcoes;

require_once '../autoload.php';


class ClassViewManutencaoPessoaEndereco extends estClassViewManutencao {
    private object $controllerPessoaEndereco;


    public function __construct() {
        $this->controllerPessoaEndereco = new ClassControllerPessoaEndereco;
        $this->setTituloRotina('Consulta de Endereço de Pessoa');
    }


    /**
     * Este método cria uma table HTML com as ações
     * e os registros do controller.
     * 
     * @param array $aAcoes
     */
    public function setTableConsultaPessoaEnderecoView($aAcoes) {
        $this->setTabelaRegistros($this->createTable($this->controllerPessoaEndereco->getConsultaEnderecoController(), $aAcoes));
    }


    /**
     * Este método retorna a consulta de Endereço completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaPessoaEnderecoView($aAcoes) {
        $this->setTableConsultaPessoaEnderecoView($aAcoes);
        return $this->sTabelaRegistrosConsulta;
    }
}
$teste = new ClassViewManutencaoPessoaEndereco;
echo $teste->getConsultaPessoaEnderecoView([estClassEnumAcoes::INCLUIR, estClassEnumAcoes::ALTERAR, estClassEnumAcoes::EXCLUIR]);
echo '<script type="module" src="viewComportamento/classViewComportamentoPessoaEndereco.js"></script>';
?>