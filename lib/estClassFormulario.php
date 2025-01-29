<?php
namespace lib;
require_once '../autoload.php';

use lib\estClassRequestBase;
use ReflectionMethod;

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
        $sNameController = 'ClassController'.$sNameController;
        if (class_exists($sNameController, false)) {
            $reflectionMethod = new ReflectionMethod($sNameController, $sMetodo);
            return 'ok';
            //return $reflectionMethod->invoke(new $sNameController());
        }
        else {
            return 'nao ok';
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
              return 'getTelaInclusao'.$sNameController;
              break;
            case 2:
              return 'getTelaAlteracao'.$sNameController;
              break;
            case 3:
              return 'getTelaExclusao'.$sNameController;
              break;
          }
    }


    public function trataQueryStringToArray($sQueryString) {
        parse_str($sQueryString, $aQueryString); 
        return $aQueryString;
    }
}

$estClassFormulario = new estClassFormulario;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aQueryString = $estClassFormulario->trataQueryStringToArray($_SERVER['QUERY_STRING']);
    if (estClassRequestBase::post($aQueryString['Controller']) && estClassRequestBase::post($aQueryString['Acao'])) {
        echo 'ok';
        echo $estClassFormulario->callController($aQueryString['Controller'], $aQueryString['Acao']);
    }
    else {
        echo 'deu ruim menó';
    }
}


?>