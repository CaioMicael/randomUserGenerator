<?php
namespace view;

use controller\ClassControllerPessoaEndereco;
use lib\estClassViewManutencao;
use lib\enum\estClassEnumAcoes;

require_once '../autoload.php';

/**
 * @package webbased
 * @author Caio Micael Krieger 
 * @since 17/01/2025
 */
class ClassViewManutencaoPessoaEndereco extends estClassViewManutencao {
    private object $controllerPessoaEndereco;


    public function __construct() {
        $this->controllerPessoaEndereco = new ClassControllerPessoaEndereco;
        $this->setTituloRotina('Consulta de Endereço de Pessoa');
    }


    /**
     * Este método retorna a consulta de Endereço completa, com as ações repassadas.
     * 
     * @param  array $aAcoes
     * @return HTML
     */
    public function getConsultaPessoaEnderecoView($aAcoes) {
        return $this->getConsulta($this->controllerPessoaEndereco->getConsultaEnderecoController(), $aAcoes);
    }
}
echo '<script type="module" src="viewComportamento/classViewComportamentoPessoaEndereco.js"></script>';
?>