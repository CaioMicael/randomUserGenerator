<?php
namespace model;
require_once '../autoload.php';

use lib\estClassCurl;
use model\ClassModelUserGenerator;

Class ClassModelAPIUserGenerator {
    private $url;
    private $curl;
    private $modelUserGenerator;
    private $response;


    public function __construct() {
        $this->setURL('https://randomuser.me/api/1.4/?format=JSON&exc=login,dob,registered,nat,id');
        $this->modelUserGenerator = new ClassModelUserGenerator;
    }


    /**
     * Este método realiza a requisição a API e retorna os dados da API para o modelUserGenerator.
     * 
     */
    public function getDadosPessoaFromAPI() {
        $this->curl = estClassCurl::curlInit($this->url);
        $this->setResponse(estClassCurl::execCurlReturnTrasnfer($this->curl));
        estClassCurl::curlClose($this->curl);
        $this->enviaDadosModelUserGenerator($this->response);
    }


    /**
     * Este método realiza o envio dos dados da requisição para o modelUserGenerator
     * 
     * @param string $jDados
     */
    private function enviaDadosModelUserGenerator($jDados) {
        $this->modelUserGenerator->trataDadosFromRequisicao($jDados);
    }


    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 
    
    public function getURL() {
        return $this->url;
    }


    public function getResponse() {
        return $this->response;
    }


    public function setURL($url) {
        $this->url = $url;
    }


    public function setResponse($response) {
        $this->response = $response;
    }
}

$model = new ClassModelAPIUserGenerator;
$model->getDadosPessoaFromAPI();

?>