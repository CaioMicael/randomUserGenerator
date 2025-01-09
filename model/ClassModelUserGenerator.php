<?php

require_once '../lib/estClassQuery.php';
require_once 'ClassModelPessoa.php';
require_once 'ClassModelPessoaEndereco.php';

Class ClassModelUserGenerator extends estClassQuery {
    private object $oDadosRequisicao;
    private array $aDadosPessoa = array();
    private array $aDadosPessoaEndereco = array();
    private object $modelPessoa;
    private object $modelPessoaEndereco;


    public function __construct() {
        $this->modelPessoa         = new ClassModelPessoa;
        $this->modelPessoaEndereco = new ClassModelPessoaEndereco;
    }


    /**
     * Esta função recebe a response da API e chama os métodos responsáveis por tratar o dado e enviar aos respectivos models.
     * 
     * @param string $jDados
     */
    public function trataDadosFromRequisicao($jDados) {
        $this->oDadosRequisicao = json_decode($jDados);
        echo '<pre>';
        print_r($this->oDadosRequisicao);
        echo '</pre>';
        $this->enviaDadosToModelPessoa();
        $this->trataDadosToModelPessoaEndereco();
        var_dump($this->aDadosPessoa);
        echo '<br>';
        var_dump($this->aDadosPessoaEndereco);
    }


    /**
     * Esta função alimenta o array de dadosPessoaEndereco com os dados de endereço da pessoa.
     * 
     */
    private function trataDadosToModelPessoaEndereco() {
        array_push($this->aDadosPessoaEndereco, $this->oDadosRequisicao->results[0]->location->street->name);
    }


    /**
     * Esta função envia os dados para o ModelPessoa inserir no banco.
     * 
     */
    private function enviaDadosToModelPessoa() {
        $this->modelPessoa->setAttributeModel($this->oDadosRequisicao->info->seed, 
                                              $this->oDadosRequisicao->results[0]->gender, 
                                              $this->oDadosRequisicao->results[0]->name->title . ' ' . $this->oDadosRequisicao->results[0]->name->first . ' ' . $this->oDadosRequisicao->results[0]->name->last, 
                                              $this->oDadosRequisicao->results[0]->email, 
                                              $this->oDadosRequisicao->results[0]->phone, 
                                              $this->oDadosRequisicao->results[0]->cell);
        $this->modelPessoa->inserePessoa();
    }


}

?>