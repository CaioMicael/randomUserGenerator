<?php

namespace view;

use controller\ClassControllerPais;
use lib\estClassViewManutencao;
use Exception;

require_once '../autoload.php';

/**
 * Classe de view da consulta de País.
 * 
 * @package webbased
 * @author Caio Micael Krieger
 * @since 13/02/2025
 */
class ClassViewManutencaoPais extends estClassViewManutencao {
    private object $controllerPais;


    public function __construct() {
        $this->controllerPais = new ClassControllerPais;
        $this->setTituloRotina('Consulta de País');
        $this->setTituloTelaInclusao('Incluir País');
        $this->setTituloTelaAlteracao('Alterar País');
    }


    /**
     * Este método realiza a criação de uma tela
     * para inclusão de um Estado.
     * @return HTML
     */
    public function getTelaIncluirPais() {
        return $this->getTelaInclusao($this->getCamposInclusao());
    }


    /**
     * Este método realiza a criação de uma tela de alteração de registro.
     * @param array $aDados - Dados dos campos tipados em HTML.
     * @return HTML
     */
    public function getTelaAlterarPais($aTipagem, $aDados) {
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
    public function getConsultaPaisView($aAcoes) {
        $this->getConsulta($this->controllerPais->getDadosConsultaPaisController(),$aAcoes);
        return $this->sTabelaRegistrosConsulta;
    }

    /**
     * {@inheritDoc}
     */
    protected function getCamposInclusao() {
        return [
            $this->addCampo()->setNameCampo('pais.codigo')->setNomeLabel('Código do País')->setTipagem('number')->setRequired()->setDisabled(),
            $this->addCampo()->setNameCampo('pais.nome')->setNomeLabel('Nome do País')->setTipagem('text')->setRequired()
        ];
    }

}
if ($_SERVER["REQUEST_URI"] == '/randomusergenerator/view/ClassViewManutencaoPais.php') {
    echo '<script type="module" src="viewComportamento/ClassViewComportamentoPais.js"></script>';
}

?>