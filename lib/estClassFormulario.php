<?php
namespace lib;
require_once '../autoload.php';

use Exception;
use ReflectionMethod;
use lib\enum\estClassEnumMensagensWebbased;
use lib\enum\estClassEnumAcoes;

/**
 * Esta classe é um facilitador de requisições de formulário/Ajax.
 * Responsável por chamar o controller responsável e também o método responsável
 * pela ação solicitada no ajax/formulário, assim evitando manipulação direta
 * nos controllers.
 * 
 * @author Caio Micael Krieger
 * @since 28/01/2025
 */
class estClassFormulario {


    /**
     * Este método recebe os dados da requisição
     * e chama o controller conforme parâmetro "destino".
     * 
     * @param string $sNameController
     * @param int    $iAcao
     * @param int    $iProcessaDados
     * @param array  $aDados
     * @return include
     */
    public function callController($sNameController, $iAcao, $iProcessaDados, $aDados) {
        if ($iProcessaDados == '1') {
            $sPrefixoMetodo = 'processaDados';
        }
        else if ($iProcessaDados == '0') {
            $sPrefixoMetodo = 'getTela';
        }
        else {
            throw new Exception(estClassEnumMensagensWebbased::webbased003->mensagem);
            return;
        }

        $sMetodo         = $this->getMetodoByAcao($sPrefixoMetodo, $iAcao, $sNameController);
        $sNameController = 'controller\ClassController'.$sNameController;
        if (class_exists($sNameController, true)) {
            $reflectionMethod = new ReflectionMethod($sNameController, $sMetodo);
            return $reflectionMethod->invokeArgs(new $sNameController(), array($aDados));
        } 
        else {
            throw new Exception('A Classe '.$sNameController. ' não foi encontrada!');
        }
    }


    /**
     * Este método retorna o nome do método que deve ser chamado 
     * pela função callController. Vai pegar o código da ação
     * e montar o nome da função de acordo com a ação repassada.
     * 
     * @param int    $iAcao
     * @param string $sNameController
     * @return string
     */
    private function getMetodoByAcao($sPrefixoMetodo, $iAcao, $sNameController) {
        $oAcaoTratada = estClassEnumAcoes::tryFrom($iAcao);
        $sAcaoTratada = mb_convert_case($oAcaoTratada->name, MB_CASE_TITLE, "UTF-8");
        return $sPrefixoMetodo.$sAcaoTratada.$sNameController;
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
    $aDados = json_decode(file_get_contents("php://input"), true);

    if (isset($aQueryString['processaDados']) && isset($aQueryString['destino']) && isset($aQueryString['Acao'])) {
        echo $estClassFormulario->callController(
            $aQueryString['destino'], 
            $aQueryString['Acao'], 
            $aQueryString['processaDados'],
            $aDados);
    }
    else {
        throw new Exception(estClassEnumMensagensWebbased::webbased003->value);
    }
}


?>