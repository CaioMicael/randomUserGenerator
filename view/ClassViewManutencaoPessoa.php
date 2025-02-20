<?php
namespace view;

use controller\ClassControllerPessoa;
use lib\estClassViewManutencao;
use lib\enum\estClassEnumAcoes;

require_once '../autoload.php';

/**
 * @package webbased
 * @author Caio Micael Krieger
 * @since 17/01/2025
 */
class ClassViewManutencaoPessoa extends estClassViewManutencao {
    public object $controllerPessoa;


    public function __construct() {
        $this->controllerPessoa = new ClassControllerPessoa;
        $this->setTituloRotina('Consulta de Pessoa');
    }


    /**
     * Este método retorna a consulta de Pessoa completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaPessoaView($aAcoes) {
        return $this->getConsulta($this->controllerPessoa->getDadosConsultaPessoa(), $aAcoes);
    }
}
echo '<script type="module" src="viewComportamento/classViewComportamentoPessoa.js"></script>';
?>