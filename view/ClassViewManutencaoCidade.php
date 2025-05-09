<?php
namespace view;

use controller\ClassControllerCidade;
use Exception;
use lib\estClassViewManutencao;

require_once '../autoload.php';

/**
 * @package View
 * @author Caio Micael Krieger
 * @since 17/01/2025
 */
class ClassViewManutencaoCidade extends estClassViewManutencao {
    private object $controllerCidade;


    public function __construct() {
        $this->controllerCidade = new ClassControllerCidade;
        $this->setTituloRotina('Consulta de Cidade');
        $this->setTituloTelaInclusao('Incluir Cidade');
        $this->setTituloTelaAlteracao('Alterar Cidade');
    }


    /**
     * Este método realiza a criação de uma tela
     * para inclusão de uma cidade.
     * @return HTML
     */
    public function getTelaIncluirCidade() {
        return $this->getTelaInclusao($this->getCamposInclusao());
    }


    /**
     * Este método realiza a criação de uma tela de alteração de registro.
     * @param array $aDados - Dados a serem apresentados na tela de alteração.
     * @return HTML
     */
    public function getTelaAlterarCidade($aDados) {
        try {
            return json_encode($this->getTelaAlteracao($this->getCamposAlteracao(), $aDados));
        }
        catch (Exception $e) {
            return $e;
        }
    }


    /**
     * Este método retorna a consulta de Cidade completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaCidadeView($aAcoes) {
        return $this->getConsulta(
            $this->controllerCidade->getDadosConsultaCidadeController(), 
            $aAcoes);
    }

    /**
     * {@inheritDoc}
     */
    protected function getCamposAlteracao() {
        return [
            $this->addCampo()->setNomeLabel('Código da Cidade')->setTipagem('text')->setNameCampo('cidade.codigo')->setDisabled(),
            $this->addCampo()->setNomeLabel('Nome da Cidade')->setTipagem('text')->setNameCampo('cidade.nome')->setRequired(),
            $this->addCampo()->setNomeLabel('Código do Estado')->setTipagem('text')->setNameCampo('estado.codigo')->setRequired()->setLupa('Estado'),
            $this->addCampo()->setNomeLabel('Código do País')->setTipagem('text')->setNameCampo('pais.codigo')->setRequired()->setLupa('Pais')
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getCamposInclusao() {
        return [
            $this->addCampo()->setNomeLabel('Código da Cidade')->setTipagem('text')->setNameCampo('cidade.codigo')->setDisabled(),
            $this->addCampo()->setNomeLabel('Nome da Cidade')->setTipagem('text')->setNameCampo('cidade.nome')->setRequired(),
            $this->addCampo()->setNomeLabel('Código do Estado')->setTipagem('text')->setNameCampo('estado.codigo')->setRequired()->setLupa('Estado'),
            $this->addCampo()->setNomeLabel('Código do País')->setTipagem('text')->setNameCampo('pais.codigo')->setRequired()->setLupa('Pais')
        ];
    }
    
}
if ($_SERVER["REQUEST_URI"] == '/randomusergenerator/view/ClassViewManutencaoCidade.php') {
    echo '<script type="module" src="viewComportamento/classViewComportamentoCidade.js"></script>';
}
?>