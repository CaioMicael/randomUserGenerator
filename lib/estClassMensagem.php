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

    
    public static function geraMensagemTela($sMensagem) {
        return 
            "<div class='overlayEstMensagem'>
                <div class ='contentEstMensagem'>
                    <h1>Alerta</h1>
                    <p>$sMensagem</p>
                    <button onclick='toggleOverlayDisabled()'>OK</button>
                </div>
             </div>
             <script>
             toggleOverlay();
             </script>
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