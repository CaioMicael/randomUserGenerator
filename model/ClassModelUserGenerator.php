<?php

namespace model;

use lib\estClassQuery;
use model\ClassModelPessoa;
use model\ClassModelPessoaEndereco;
use model\ClassModelPais;
use model\ClassModelCidade;

require_once '../autoload.php';

Class ClassModelUserGenerator extends estClassQuery {
    private object $oDadosRequisicao;
    private array  $aDadosPessoa         = array();
    private array  $aDadosPessoaEndereco = array();
    private object $modelPessoa;
    private object $modelPessoaEndereco;
    private object $modelPais;
    private object $modelEstado;
    private object $modelCidade;


    public function __construct() {
        $this->modelPessoa         = new ClassModelPessoa;
        $this->modelPessoaEndereco = new ClassModelPessoaEndereco;
        $this->modelPais           = new ClassModelPais;
        $this->modelEstado         = new ClassModelEstado;
        $this->modelCidade         = new ClassModelCidade;
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

        $this->enviaDadosToModelPais();
        $this->enviaDadosToModelEstado();
        $this->enviaDadosToModelPessoa();
        
        var_dump($this->aDadosPessoa);
        echo '<br>';
        var_dump($this->aDadosPessoaEndereco);
    }


    /**
     * Esta função envia os dados para o ModelPais inserir no banco.
     * 
     */
    private function enviaDadosToModelPais() {
        $this->modelPais->setAttributeModel($this->oDadosRequisicao->results[0]->location->country);
        $this->modelPais->inserePais();
        $this->modelPais->setCodigoPaisByNome($this->modelPais->getNomePais());
    }


    /**
     * Esta função envia os dados para o ModelEstado inserir no banco.
     * 
     */
    private function enviaDadosToModelEstado() {
        $this->modelEstado->setAttributeModel($this->oDadosRequisicao->results[0]->location->state, $this->modelPais->getCodigoPais());
        $this->modelEstado->insereEstado();
        $this->modelEstado->setCodigoEstadoByNome($this->modelEstado->getEstadoNome());
    }


    private function enviaDadosToModelCidade() {
        $this->modelCidade->setAttributeModelCidade();
        $this->modelCidade->insereCidade();
        $this->modelCidade->setCodigoCidadeByNome($this->modelCidade->getCidadeNome());
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