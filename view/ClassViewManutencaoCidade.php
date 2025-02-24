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
     * @param array $aDados - Dados dos campos tipados em HTML.
     * @return HTML
     */
    public function getTelaIncluirCidade($aDados) {
        return $this->getTelaInclusao($aDados);
    }


    /**
     * Este método realiza a criação de uma tela de alteração de registro.
     * @param array $aDados - Dados dos campos tipados em HTML.
     * @return HTML
     */
    public function getTelaAlterarCidade($aDados) {
        return $this->getTelaAlteracao($aDados);
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