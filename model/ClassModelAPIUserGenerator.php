<?php
namespace model;
require_once '../autoload.php';

use lib\estClassCurl;
use model\ClassModelUserGenerator;

/**
 * Esta classe é responsável por realizar a requisição a API de geração de usuários e enviar os dados para o modelUserGenerator.
 * @package model
 * @author Caio Micael Krieger
 * @since 07/01/2025
 */
Class ClassModelAPIUserGenerator {
    private $url;
    
    private $curl;

    /** @var ClassModelUserGenerator */
    private $UserGenerator;

    private $response;


    public function __construct() {
        $this->setURL('https://randomuser.me/api/1.4/?format=JSON&exc=login,dob,registered,nat,id');
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
        $this->getUserGenerator()->trataDadosFromRequisicao($jDados);
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

    /**
     * Retorna o ModelUserGenerator, instanciando um automaticamente se não existir
     * @return ClassModelUserGenerator
     */
    private function getUserGenerator(): ClassModelUserGenerator {
        if (! isset($this->UserGenerator)) {
            $this->setUserGenerator(new ClassModelUserGenerator());
        }
        return $this->UserGenerator;
    }


    public function setURL($url) {
        $this->url = $url;
    }


    public function setResponse($response) {
        $this->response = $response;
    }

    /**
     * Este método seta o modelUserGenerator
     * @param ClassModelUserGenerator $UserGenerator
     */
    public function setUserGenerator(ClassModelUserGenerator $UserGenerator) {
        $this->UserGenerator = $UserGenerator;
    }
}

$model = new ClassModelAPIUserGenerator;
$model->getDadosPessoaFromAPI();

?>