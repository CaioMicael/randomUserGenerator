<?php
namespace view;

use controller\ClassControllerEstado;
use lib\estClassViewManutencao;
use Exception;

require_once '../autoload.php';

/**
 * Classe da consulta de Estado.
 * @package webbased
 * @author Caio Micael Krieger
 * @since 17/01/2025
 */
class ClassViewManutencaoEstado extends estClassViewManutencao {
    private object $controllerEstado;


    public function __construct() {
        $this->controllerEstado = new ClassControllerEstado;
        $this->setTituloRotina('Consulta de Estado');
        $this->setTituloTelaInclusao('Incluir Estado');
        $this->setTituloTelaAlteracao('Alterar Estado');
    }


    /**
     * Este método realiza a criação de uma tela
     * para inclusão de um Estado.
     * @return HTML
     */
    public function getTelaIncluirEstado() {
        return $this->getTelaInclusao($this->getCamposInclusao());
    }


    /**
     * Este método realiza a criação de uma tela de alteração de registro.
     * @param array $aDados - Dados dos campos tipados em HTML.
     * @return HTML
     */
    public function getTelaAlterarEstado($aTipagem, $aDados) {
        try {
            return json_encode($this->getTelaAlteracao($aTipagem, $aDados));
        }
        catch (Exception $e) {
            return $e;
        }
    }


    /**
     * Este método retorna a consulta de Estado completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaEstadoView($aAcoes) {
        $this->getConsulta($this->controllerEstado->getDadosConsultaEstadoController(),$aAcoes);
        return $this->sTabelaRegistrosConsulta;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCamposInclusao() {
        return [
            $this->addCampo()->setNomeLabel('Código do Estado')->setTipagem('number')->setNameCampo('estado.codigo')->setRequired()->setDisabled(),
            $this->addCampo()->setNomeLabel('Nome do Estado')->setTipagem('text')->setNameCampo('estado.nome')->setRequired(),
            $this->addCampo()->setNomeLabel('Código do País')->setTipagem('number')->setNameCampo('pais.codigo')->setRequired()->setLupa('Pais'),
            $this->addCampo()->setNomeLabel('Nome do País')->setTipagem('text')->setNameCampo('pais.nome')->setRequired()->setDisabled()
        ];
    }

}
if ($_SERVER["REQUEST_URI"] == '/randomusergenerator/view/ClassViewManutencaoEstado.php') {
    echo '<script type="module" src="viewComportamento/ClassViewComportamentoEstado.js"></script>';
}

?>