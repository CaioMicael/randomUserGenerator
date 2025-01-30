<?php
namespace lib;
require_once '../autoload.php';

use lib\estClassRequestBase;
use Exception;
use ReflectionMethod;


/**
 * Esta classe é um facilitador de requisições de formulário/Ajax.
 * Responsável por chamar o controller responsável e também o método responsável
 * pela ação solicitada no ajax/formulário, assim evitando manipulação direta
 * nos controllers.
 * 
 * @author Caio Micael Krieger
 */
class estClassFormulario {


    /**
     * Este método recebe os dados da requisição
     * e chama o controller conforme parâmetro "destino".
     * 
     * @param string $sNameController
     * @return include
     */
    public function callController($sNameController, $iAcao) {
        $sMetodo         = $this->getMetodoByAcao($iAcao, $sNameController);
        $sNameController = 'controller\ClassController'.$sNameController;
        if (class_exists($sNameController, true)) {
            $reflectionMethod = new ReflectionMethod($sNameController, $sMetodo);
            return $reflectionMethod->invoke(new $sNameController());
        }
        else {
            throw new Exception('A Classe '.$sNameController. ' não foi encontrada!');
        }
    }


    /**
     * Este método retorna o nome do método que deve ser chamado 
     * pela função callController. Vai pegar o código da ação
     * e achar qual nome da função de acordo com a ação repassada.
     * 
     * @param int $iAcao
     * @return string
     */
    private function getMetodoByAcao($iAcao, $sNameController) {
        switch ($iAcao) {
            case 1:
              return 'getTelaInclusao'.$sNameController.'FromView';
              break;
            case 2:
              return 'getTelaAlteracao'.$sNameController;
              break;
            case 3:
              return 'getTelaExclusao'.$sNameController;
              break;
          }
    }


    /**
     * Este método trata a query string passando a mesma
     * para um array.
     * 
     * @param string $sQueryString
     * @return array
     */
    public function trataQueryStringToArray($sQueryString) {
        parse_str($sQueryString, $aQueryString); 
        return $aQueryString;
    }
}

$estClassFormulario = new estClassFormulario;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aQueryString = $estClassFormulario->trataQueryStringToArray($_SERVER['QUERY_STRING']);
    if ($aQueryString['Controller'] && $aQueryString['Acao']) {
        echo $estClassFormulario->callController($aQueryString['Controller'], $aQueryString['Acao']);
    }
}


?>