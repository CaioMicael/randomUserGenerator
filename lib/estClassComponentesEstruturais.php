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


}

?>