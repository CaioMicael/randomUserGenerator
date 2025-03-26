<?php
namespace view;

use controller\ClassControllerPessoa;
use lib\estClassViewManutencao;
use lib\enum\estClassEnumAcoes;

require_once '../autoload.php';

/**
 * @package webbased
 * @author Caio Micael Krieger
 * @since 17/01/2025
 */
class ClassViewManutencaoPessoa extends estClassViewManutencao {
    public object $controllerPessoa;


    public function __construct() {
        $this->controllerPessoa = new ClassControllerPessoa;
        $this->setTituloRotina('Consulta de Pessoa');
    }


    /**
     * Este método retorna a consulta de Pessoa completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaPessoaView($aAcoes) {
        return $this->getConsulta($this->controllerPessoa->getDadosConsultaPessoa(), $aAcoes);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTelaAlteracao($aCampos, $aDados){
        return $this->getTelaAlteracao($this->getCamposAlteracao(), $aDados);
    }

    /**
     * {@inheritDoc}
     */
    protected function getCamposAlteracao() {
        $this->addCampo()->setNameCampo('pessoa.seed')->setNomeLabel('Seed')->setTipagem('text')->setDisabled();
        $this->addCampo()->setNameCampo('pessoa.codigo')->setNomeLabel('Código')->setTipagem('text')->setDisabled();
        $this->addCampo()->setNameCampo('pessoa.nome')->setNomeLabel('Nome')->setTipagem('text')->setRequired();
        $this->addCampo()->setNameCampo('pessoa.email')->setNomeLabel('E-mail')->setTipagem('email')->setRequired();
        $this->addCampo()->setNameCampo('pessoa.telefone')->setNomeLabel('Telefone')->setTipagem('text')->setRequired();
        $this->addCampo()->setNameCampo('pessoa.celular')->setNomeLabel('Celular')->setTipagem('text')->setRequired();
    }
}
if ($_SERVER["REQUEST_URI"] == '/randomusergenerator/view/ClassViewManutencaoPessoa.php') {
    echo '<script type="module" src="viewComportamento/ClassViewComportamentoPessoa.js"></script>';
}
?>