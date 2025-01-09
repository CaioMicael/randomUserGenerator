<?php

require_once '../lib/estClassQuery.php';
require_once 'ClassModelPessoa.php';

Class ClassModelUserGenerator extends estClassQuery {
    private object $oDadosRequisicao;
    private array $aDadosPessoa = array();
    private $modelPessoa;


    public function __construct() {
        $this->modelPessoa = new ClassModelPessoa;
    }


    /**
     * Esta função recebe a response da API e chama os métodos responsáveis por tratar o dado e enviar aos respectivos models.
     * 
     * @param string $jDados
     */
    public function trataDadosFromRequisicao($jDados) {
        //$this->aDadosRequisicao = json_decode($jDados,true);
        $this->oDadosRequisicao = json_decode($jDados);
        echo '<pre>';
        print_r($this->oDadosRequisicao);
        echo '</pre>';
        $this->trataDadosToModelPessoa();
        $this->trataDadosToModelPessoaEndereco();
        var_dump($this->aDadosPessoa);
    }


    /**
     * Esta função alimenta o array de DadosPessoa com os dados da pessoa.
     * 
     */
    private function trataDadosToModelPessoa() {
        array_push($this->aDadosPessoa, $this->oDadosRequisicao->info->seed);
        array_push($this->aDadosPessoa, $this->oDadosRequisicao->results[0]->gender);
        array_push($this->aDadosPessoa, $this->oDadosRequisicao->results[0]->name->title . ' ' . $this->oDadosRequisicao->results[0]->name->first . ' ' . $this->oDadosRequisicao->results[0]->name->last);
        array_push($this->aDadosPessoa, $this->oDadosRequisicao->results[0]->email);
        array_push($this->aDadosPessoa, $this->oDadosRequisicao->results[0]->phone);
        array_push($this->aDadosPessoa, $this->oDadosRequisicao->results[0]->cell);
    }


    private function trataDadosToModelPessoaEndereco() {
        
    }


    /**
     * Esta função envia os dados para o ModelPessoa inserir no banco.
     * 
     * @param array $aDadosPessoa
     */
    private function enviaDadosToModelPessoa($aDadosPessoa) {

    }


}

?>