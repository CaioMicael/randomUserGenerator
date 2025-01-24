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