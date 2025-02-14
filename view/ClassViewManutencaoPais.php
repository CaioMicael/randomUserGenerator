<?php

namespace view;

use controller\ClassControllerPais;
use lib\estClassViewManutencao;

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
        $this->setTituloRotina('Consulta de Estado');
        $this->setTituloTelaInclusao('Incluir Estado');
    }


    /**
     * Este método retorna uma consulta dos registros
     * de país com as ações repassadas.
     * 
     * @param array $aAcoes
     * @return HTML
     */
    public function getConsultaPaisView($aAcoes) {
        return $this->getConsulta($this->controllerPais->getDadosTratadoConsultaPaisController(), $aAcoes);
    }
}

?>