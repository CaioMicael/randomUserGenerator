<?php
namespace lib;
require_once '../autoload.php';

/**
 * Essa classe contém métodos que retornam HTMLs de
 * componentes estruturais, por exemplo botões.
 * 
 * @author Caio Micael Krieger
 * @since 01/02/2024
 */
class estClassComponentesEstruturais {


    /**
     * Este método retorna um botão no formato X que contém a mesma
     * função do botão "Fechar"
     * 
     * @return HTML
     */
    public static function getBotaoFecharX() {
        return "<button class ='estButtonFecharX'>X</button";
    }


    /**
     * Este método retorna o botão Fechar padrão estrutural.
     * 
     * @return HTML
     */
    public static function getBotaoFechar() {
        return "<button class='estButtonFechar'>Fechar</button>";
    }


    /**
     * Este método retorna o botão de incluir padrão estrutural.
     * 
     * @return HTML
     */
    public static function getBotaoIncluir() {
        return "<button class='estButtonIncluir'>Incluir</button>";
    }


    /**
     * Este método retorna o botão de incluir registro no padrão estrutural.
     * Este botão deve ser usado nas telas de inclusão de registro.
     * 
     * @return HTML
     */
    public static function getBotaoIncluirRegistro() {
        return "<button class='estButtonIncluirRegistro'>Incluir</button>";
    }


    public static function getBotaoOK() {
        return "<button class='estButtonOK'>OK</button>";
    }


    public static function getBotaoTrace() {
        return "<button class='estButtonTrace'>Trace</button>";
    }


    /**
     * Este método realiza a criação de uma label
     * com um input, conforme parâmetros repassados.
     * 
     * @param string $sNomeLabel
     * @param string $sTipagem
     * @param string $sNameInput
     * @param string $sDisabled
     * @return HTML
     */
    public static function getCampoLabelInclusao($sNomeLabel, $sTipagem, $sNameInput, $sDisabled) {
        return "<label for=''>$sNomeLabel</label>
                <input type='$sTipagem' name='$sNameInput' $sDisabled class= 'input-tela-inclusao'>";
    }

    
    /**
     * Este método retorna o footer da tela de mensagem exception
     * 
     * @param array $aException - Array associativo com keys 'mensagem' e 'trace'
     * @return HTML
     */
    public static function getFooterMensagemException($aException) {
        $html  = "<footer class ='overlay-buttons'>";                
        $html .=    estClassComponentesEstruturais::getBotaoOK()."\n";
        $html .=    estClassComponentesEstruturais::getBotaoTrace();
        $html .= "</footer>";
        $html .= "<div class='div-span-trace'>";
            $html .= "<span class='span-button-trace' style='display: none;'>".$aException['trace']. "</span>";
        $html .= "</div>";
        return $html;
    }
}

?>