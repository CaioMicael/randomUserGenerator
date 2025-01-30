<?php

namespace lib;

use Exception;

require_once '../autoload.php';

/**
 * Classe usada para recuperar e adicionar informações
 * dentro da variável $_REQUEST. É apenas um facilitador
 * para evitar a reescrita de códigos de verificação isset.
 *
 * @author Caio Micael Krieger
 */
class estClassRequestBase {

    function __construct() {
        class_alias('estClassRequestBase', 'request');
    }


    /**
     * Este método verifica os dados enviados pela requisição GET, se estão setados ou não estão vazios.
     * 
     * @param string $key
     * @return string
     */
    public static function get($key) {
        if (isset($_GET[$key]) && ($_GET[$key] != '')) {
            return $_GET[$key];
        }
        else {
            return '';
        }
    }
 

    /**
     * Este método verifica os dados enviados pela requisição POST, se estão setados ou não estão vazios.
     * 
     * @param string $key
     * @return string
     */
    public static function post($key) {
        if (isset($_POST[$key]) && ($_POST[$key] != '')) {
            return $_POST[$key];
        }
        else {
            throw new Exception('Dados da requisição não encontrados!');
        }
    }
    

    public static function set($key, $val) {
        $val = $_REQUEST[$key];
    }
    
}