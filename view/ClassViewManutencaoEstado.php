<?php
namespace view;

use controller\ClassControllerEstado;
use lib\estClassViewManutencao;
use lib\enum\estClassEnumAcoes;

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

}
echo '<script type="module" src="viewComportamento/classViewComportamentoEstado.js"></script>';

?>