<?php
namespace view;

use controller\ClassControllerCidade;
use lib\estClassViewManutencao;
use lib\enum\estClassEnumAcoes;
use lib\enum\estClassEnumMensagensWebbased;
use lib\estClassMensagem;

require_once '../autoload.php';

/**
 * @package webbased
 * @author Caio Micael Krieger
 * @since 17/01/2025
 */
class ClassViewManutencaoCidade extends estClassViewManutencao {
    private object $controllerCidade;


    public function __construct() {
        $this->controllerCidade = new ClassControllerCidade;
        $this->setTituloRotina('Consulta de Cidade');
        $this->setTituloTelaInclusao('Incluir Cidade');
    }


    /**
     * Este método realiza a criação de uma tela
     * para inclusão de uma cidade.
     * 
     * @return HTML
     */
    public function getTelaIncluirCidade() {
        return $this->getTelaInclusao($this->controllerCidade->getTipagemCamposToHtml());
    }


    /**
     * Este método retorna a consulta de Cidade completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaCidadeView($aAcoes) {
        return $this->getConsulta($this->controllerCidade->getDadosConsultaCidadeController(), $aAcoes);
    }

}
echo '<script type="module" src="viewComportamento/classViewComportamentoCidade.js"></script>';

?>