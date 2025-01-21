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
    }


    /**
     * Este método cria a view de consulta de Estado.
     * 
     * @return HTML
     */
    public function getConsultaEstadoView() {
        return $this->createTable('Cadastro de Estado', $this->controllerEstado->getDadosConsultaEstadoController(), [estClassEnumAcoes::INCLUIR, estClassEnumAcoes::ALTERAR, estClassEnumAcoes::EXCLUIR]);
    }

}

$teste = new ClassViewManutencaoEstado;
echo $teste->getConsultaEstadoView();
echo '<script type="module" src="viewComportamento/classViewComportamentoEstado.js"></script>';

?>