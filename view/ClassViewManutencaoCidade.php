<?php
namespace view;

use controller\ClassControllerCidade;
use lib\estClassViewManutencao;
use lib\estClassEnumAcoes;
use lib\estClassEnumMensagens;
use lib\estClassMensagem;

require_once '../autoload.php';


class ClassViewManutencaoCidade extends estClassViewManutencao {
    private object $controllerCidade;


    public function __construct() {
        $this->controllerCidade = new ClassControllerCidade;
        $this->setTituloRotina('Consulta de Cidade');
    }

    /**
     * Este método cria uma table HTML com as ações
     * e os registros do controller.
     * 
     * @param array $aAcoes
     */
    public function setTableConsultaCidadeView($aAcoes) {
        $this->setTabelaRegistros($this->createTable($this->controllerCidade->getDadosConsultaCidadeController(), $aAcoes));
    }


    /**
     * Este método retorna a consulta de Cidade completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaCidadeView($aAcoes) {
        $this->setTableConsultaCidadeView($aAcoes);
        return $this->sTabelaRegistrosConsulta;
    }

}
$teste = new ClassViewManutencaoCidade;
echo $teste->getConsultaCidadeView([estClassEnumAcoes::INCLUIR, estClassEnumAcoes::ALTERAR, estClassEnumAcoes::EXCLUIR]);
echo estClassMensagem::geraMensagemAlertaTela(estClassEnumMensagens::webbased001);
echo '<script type="module" src="viewComportamento/classViewComportamentoCidade.js"></script>';

?>