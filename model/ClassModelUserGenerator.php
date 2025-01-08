<?php

require_once '../lib/estClassQuery.php';

Class ClassModelUserGenerator extends estClassQuery {
    private $aDadosRequisicao;
    private $aDadosPessoa;
    private $modelPessoa;

    public function trataDadosFromRequisicao($jDados) {
        //$this->aDadosRequisicao = json_decode($jDados,true);
        $this->aDadosRequisicao = json_decode($jDados);
        echo '<pre>';
        //print_r($this->aDadosRequisicao);
        print_r($this->aDadosRequisicao->results[0]->gender);
        echo '</pre>';
        //echo $this->aDadosRequisicao['results'][0]['gender'];
        //var_dump($this->aDadosRequisicao->results);
    }


    private function enviaDadosToModelPessoa() {

    }
}

?>