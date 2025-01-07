<?php

require_once '../lib/estClassCurl.php';

Class ClassModelAPIUserGenerator {
    private $url;
    private $curl;
    private $modelPessoa;
    private $response;


    public function getDadosPessoa() {
        $this->setURl('https://randomuser.me/api/?format=JSON');
        $this->curl = estClassCurl::curlInit($this->url);
        estClassCurl::curlReturnTransfer($this->curl);
        $this->setResponse(estClassCurl::curlExec($this->curl));
        estClassCurl::curlClose($this->curl);
        echo $this->response;
    }


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
$model->getDadosPessoa();

?>