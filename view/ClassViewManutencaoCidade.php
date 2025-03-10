<?php
namespace view;

use controller\ClassControllerCidade;
use Exception;
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
        $this->setTituloTelaAlteracao('Alterar Cidade');
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
    public function getTelaAlterarCidade($aTipagem, $aDados) {
        try {
            return json_encode($this->getTelaAlteracao($aTipagem, $aDados));
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
    
}
if ($_SERVER["REQUEST_URI"] == '/randomusergenerator/view/ClassViewManutencaoCidade.php') {
    echo '<script type="module" src="viewComportamento/classViewComportamentoCidade.js"></script>';
}
?>