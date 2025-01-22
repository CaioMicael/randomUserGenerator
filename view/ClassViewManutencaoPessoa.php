<?php
namespace view;

use controller\ClassControllerPessoa;
use lib\estClassViewManutencao;
use lib\estClassEnumAcoes;

require_once '../autoload.php';

class ClassViewManutencaoPessoa extends estClassViewManutencao {
    public object $controllerPessoa;


    public function __construct() {
        $this->controllerPessoa = new ClassControllerPessoa;
        $this->setTituloRotina('Consulta de Pessoa');
    }


    /**
     * Este método cria uma table HTML com as ações
     * e os registros do controller.
     * 
     * @param array $aAcoes
     */
    public function setTableConsultaPessoaView($aAcoes) {
        $this->setTabelaRegistros($this->createTable($this->controllerPessoa->getDadosConsultaPessoa(), $aAcoes));
    }


    /**
     * Este método retorna a consulta de Pessoa completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaPessoaView($aAcoes) {
        $this->setTableConsultaPessoaView($aAcoes);
        return $this->sTabelaRegistrosConsulta;
    }
}

$teste = new ClassViewManutencaoPessoa;
echo $teste->getConsultaPessoaView([estClassEnumAcoes::INCLUIR, estClassEnumAcoes::ALTERAR, estClassEnumAcoes::EXCLUIR]);
echo '<script type="module" src="viewComportamento/classViewComportamentoPessoa.js"></script>';
?>