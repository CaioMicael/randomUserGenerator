<?php

namespace lib;

use CurlHandle;

/**
 * Classe estática utilizada como um facilitador para requisições cURL
 * com funções prontas para consumos de API.
 * 
 */
class estClassCurl {

    /**
     * Função utilizada para executar o cURL com return transfer.
     * Esta função já executa e retorna o resultado.
     * 
     * @param CurlHandle $curl
     * @return string
     */
    public static function execCurlReturnTrasnfer($curl) {
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curl);
    }


    /**
     * Função utilizada para iniciar sessão curl.
     * 
     * @param string $url
     */
    public static function curlInit($url) {
        return curl_init($url);
    }


    /**
     * Função utilizada para definir o response como string.
     * 
     * @param CurlHandle $curl
     */
    public static function curlReturnTransfer($curl) {
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    }


    /**
     * Função utilizada para executar o cURL, o retorno é o response.
     * 
     * @param CurlHandle $curl
     */
    public static function curlExec($curl) {
        return curl_exec($curl);
    }


    /**
     * Função utilizada para fechar conexão curl.
     * 
     * @param CurlHandle $curl
     */
    public static function curlClose($curl) {
        curl_close($curl);
    }
}

?>