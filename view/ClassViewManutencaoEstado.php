<?php
namespace view;

use controller\ClassControllerEstado;
use lib\estClassViewManutencao;
use lib\estClassEnumAcoes;

require_once '../autoload.php';


class ClassViewManutencaoEstado extends estClassViewManutencao {
    private object $controllerEstado;


    public function __construct() {
        $this->controllerEstado = new ClassControllerEstado;
        $this->setTituloRotina('Consulta de Estado');
        $this->setTituloTelaInclusao('Incluir Estado');
    }


    /**
     * Este método cria uma table HTML com as ações
     * e os registros do controller.
     * 
     * @param array $aAcoes
     */
    private function setTableConsultaEstadoView($aAcoes) {
        $this->setTabelaRegistros($this->createTable($this->controllerEstado->getDadosConsultaEstadoController(), $aAcoes));
    }


    /**
     * Este método retorna a consulta de Estado completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaEstadoView($aAcoes) {
        $this->setTableConsultaEstadoView($aAcoes);
        return $this->sTabelaRegistrosConsulta;
    }

}

$teste = new ClassViewManutencaoEstado;
echo $teste->getConsultaEstadoView([estClassEnumAcoes::INCLUIR, estClassEnumAcoes::ALTERAR, estClassEnumAcoes::EXCLUIR]);
echo '<script type="module" src="viewComportamento/classViewComportamentoEstado.js"></script>';

?>