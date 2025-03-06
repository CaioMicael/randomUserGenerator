<?php
namespace view;

use lib\enum\estClassEnumAcoes;
use lib\estClassViewManutencao;

require_once '../autoload.php';

/**
 * @package webbased
 * @author Caio Micael Krieger 
 * @since 17/01/2025
 */
class ClassViewManutencaoUserGenerator extends estClassViewManutencao {
  private object $controllerUserGenerator;
  

  public function __construct() {
    $this->setTituloRotina('API de Geração de Usuários');
  }

  public function getConsultaTeste() {
    return $this->getConsulta([], []);
  }


}
$teste = new ClassViewManutencaoUserGenerator;
echo $teste->getConsultaTeste();
?>