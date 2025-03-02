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
     * @param string $sRequired - Se estiver informado o campo fica required.
     * @param mixed  $lupa - Indica se o input deve ter uma lupa que abre outra view.
     * @return HTML
     */
    public static function getCampoLabelInclusao($sNomeLabel, $sTipagem, $sNameInput, $sDisabled, $xLupa, $sRequired) {
        $html = "<label for='$sNomeLabel'>$sNomeLabel</label>";
        $html .= "<div class='container-input'>
                    <input type='$sTipagem' name='$sNameInput' $sDisabled $sRequired class= 'input-tela-inclusao'>";
        if ($xLupa) {
            $html .= self::getInputLupa($xLupa, $sNameInput);
        }
        $html .= "</div>";
        return $html;
    }


    /**
     * Este método realiza a criação de uma label da tela de alteração.
     * 
     * @param string $sNomeLabel
     * @param string $sTipagem
     * @param string $sNameInput
     * @param string $sDisabled
     * @param mixed  $xLupa - Indica se o input deve ter uma lupa que abre outra view.
     * @param string $sRequired - Se estiver informado o campo fica required.
     * @param string $sValue - Valor do campo.
     * @return HTML
     */
    public static function getCampoLabelAlteracao($sNomeLabel, $sTipagem, $sNameInput, $sDisabled, $xLupa, $sRequired, $sValue) {
        $html = "<label for='$sNomeLabel'>$sNomeLabel</label>";
        $html .= "<div class='container-input'>
                    <input type='$sTipagem' name='$sNameInput' $sDisabled $sRequired value='$sValue' class= 'input-tela-inclusao'>";
        if ($xLupa) {
            $html .= self::getInputLupa($xLupa, $sNameInput);
        }
        $html .= "</div>";
        return $html;
    }


    /**
     * Este método retorna um input lupa para abrir outra view, conforme destino.
     * 
     * @param string $sDestino
     * @param string $sNameInput - Name do campo que a seleção de registro na lupa vai preencher.
     * @return HTML
     */
    private static function getInputLupa($sDestino, $sNameInput) {
        return "<input type='button' name='$sDestino' id= '$sNameInput' class= 'input-lupa'>";
    }


    public static function getTituloMensagemErro() {
        return "<div class='overlay-content-header'><h1>Erro</h1></div>";
    }


    public static function getTituloMensagemSucesso() {
        return "<div class='overlay-content-header'><h1>Sucesso!</h1></div>";
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


    /**
     * Este método retorna o footer da tela de mensagem sucesso.
     * 
     * @return HTML
     */
    public static function getFooterMensagemSucesso() {
        $html  = "<footer class ='overlay-buttons'>";                
        $html .=    estClassComponentesEstruturais::getBotaoOK();
        $html .= "</footer>"; 
        return $html;
    }
}

?>