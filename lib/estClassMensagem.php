<?php
namespace lib;

require_once '../autoload.php';


/**
 * Classe com funções estáticas usada como um facilitador para gerar mensagens ao usuário
 * 
 * @author Caio Micael Krieger
 */
class estClassMensagem {
    private string $sMensagem;


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
        var_dump($aException['mensagem'] = explode("\n",$sException));
        return 
        "<div class='overlay-alerta active'>
            <div class='container-content'>
                <div class ='overlayConteudo'>
                    <h1>Alerta</h1>
                    <p>$sException</p>
                    <button class='estButtonOK'>OK</button>
                </div>
            </div>
         </div>
        ";
    }


    private function trataException($sException) {
        $aException['mensagem'] = explode("\n",$sException);
        return $aException;
    }


    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 
    
    public function getMensagem() {
        return $this->sMensagem;
    }

    public function setMensagem($sMensagem) {
        $this->sMensagem = $sMensagem;
    }
}

?>