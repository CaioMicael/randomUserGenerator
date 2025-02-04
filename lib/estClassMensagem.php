<?php
namespace lib;

require_once '../autoload.php';

use lib\estClassManipulateExceptions;


/**
 * Classe com funções estáticas usada como um facilitador para gerar mensagens ao usuário
 * 
 * @author Caio Micael Krieger
 */
class estClassMensagem {
    private string $sMensagem;
    private string $sTrace;


    /**
     * Função utilizada para gerar uma mensagem de
     * alerta na tela do usuário.
     * 
     * @param object $sMensagem
     * @return HTML
     */
    public static function geraMensagemAlertaTela($sMensagem) {
        return 
            "<div class='overlay'>
                <div class='container-content'>
                    <div class ='overlayConteudo'>
                        <h1>Alerta</h1>
                        <p>$sMensagem->value</p>
                        <button class='estButtonOK'>OK</button>
                    </div>
                </div>
             </div>
            ";
    }


    /**
     * Este método gera uma mensagem em tela
     * de acordo com a exception repassada no parâmetro
     * 
     * @param string $sException
     * @return HTML
     */
    public static function geraMensagemException($sException) {
        $oInstancia = new self();
        $aException = $oInstancia->trataExceptionSetaAtributos($sException);
        $html ="<div class='overlay-alerta active'>
                    <div class='container-content'>
                        <div class ='overlayConteudo'>
                            <h1>Alerta</h1>
                            <p>".$aException['mensagem']."</p>
                        </div>";
                $html .= estClassComponentesEstruturais::getFooterMensagemException($aException);   
                $html .="</div>
                    </div>
                </div>";
        return $html;
    }


    /**
     * Este método seta os atributos da classe estClassMensagem
     * pegando a mensagem da exception e o trace.
     * 
     * @param string $sException - Texto exception gerado pelo PHP.
     */
    private function trataExceptionSetaAtributos($sException) {
        $aExceptionExplode = explode(" in ",$sException);
        var_dump($aExceptionExplode);
        $aException['mensagem'] = str_replace('Exception: ', '', $aExceptionExplode[0]);
        $aException['trace']    = $aExceptionExplode[1];
        return $aException;
    }


    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 
    
    public function getMensagem() {
        return $this->sMensagem;
    }

    public function getTrace() {
        return $this->sTrace;
    }

    public function setMensagem($sMensagem) {
        $this->sMensagem = $sMensagem;
    }

    public function setTrace($sTrace) {
        $this->sTrace = $sTrace;
    }
}

?>