<?php
namespace lib;

require_once '../autoload.php';


/**
 * Classe utilizada como base para os controllers, contém métodos que são utilizados em todos controllers.
 * 
 * @author Caio Micael Krieger
 */
class estClassController {

    /**
     * Este método é um facilitador, ele trata o retorno do Model 
     * modificando as chaves do array para nomes que devem aparecer na view.
     * 
     * @param array $aMapaChave
     * @param array $aDados
     * @return array
     */
    protected function trataDadosConsultaChave($aMapaChave, $aDados) {
        $aDadosTratado = array();
        foreach($aDados as $aDadosArray) {
            $novoRegistro = [];

            foreach($aDadosArray as $chave => $valor) {
                $novaChave = isset($aMapaChave[$chave]) ? $aMapaChave[$chave] : $chave;
                $novoRegistro[$novaChave] = $valor;
            }
            $aDadosTratado[] = $novoRegistro;
        }
        return $aDadosTratado;
    }
}


?>