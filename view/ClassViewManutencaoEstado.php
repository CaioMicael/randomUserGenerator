<?php
namespace view;

use controller\ClassControllerEstado;
use lib\estClassViewManutencao;

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
        return $this->createTable('Cadastro de Estado', $this->controllerEstado->getDadosConsultaEstadoController());
    }

}

$teste = new ClassViewManutencaoEstado;
echo $teste->getConsultaEstadoView();


?>