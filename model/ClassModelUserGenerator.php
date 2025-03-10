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
        $this->enviaDadosToModelCidade();
        $this->enviaDadosToModelPessoa();
        $this->enviaDadosToModelPessoaEndereco();
    }


    /**
     * Esta função envia os dados para o ModelPais inserir no banco.
     * 
     */
    private function enviaDadosToModelPais() {
        $this->modelPais->setAttributeModel($this->oDadosRequisicao->results[0]->location->country);
        $this->modelPais->inserePais();
    }


    /**
     * Esta função envia os dados para o ModelEstado inserir no banco.
     * 
     */
    private function enviaDadosToModelEstado() {
        $this->modelEstado->setAttributeModel($this->oDadosRequisicao->results[0]->location->state, $this->modelPais->getCodigoPais());
        $this->modelEstado->insereEstado();
    }


    /**
     * Esta função envia dos dados para o ModelCidade inserir no banco.
     * 
     */
    private function enviaDadosToModelCidade() {
        $this->modelCidade->setAttributeModelCidade($this->oDadosRequisicao->results[0]->location->city, $this->modelPais, $this->modelEstado);
        $this->modelCidade->insereCidade(
            $this->modelCidade->getCidadeNome(),
            $this->modelEstado->getEstadoCodigo(),
            $this->modelPais->getCodigoPais()
        );
    }


    /**
     * Esta função envia os dados para o ModelPessoa inserir no banco.
     * 
     */
    private function enviaDadosToModelPessoa() {
        $this->modelPessoa->setAttributeModel($this->oDadosRequisicao->info->seed, 
                                              $this->oDadosRequisicao->results[0]->gender, 
                                              $this->oDadosRequisicao->results[0]->name->first . ' ' . $this->oDadosRequisicao->results[0]->name->last, 
                                              $this->oDadosRequisicao->results[0]->email, 
                                              $this->oDadosRequisicao->results[0]->phone, 
                                              $this->oDadosRequisicao->results[0]->cell);
        $this->modelPessoa->inserePessoa();
    }


    /**
     * Esta função envia os dados para o ModelPessoaEndereco inserir no banco.
     */
    public function enviaDadosToModelPessoaEndereco() {
        $this->modelPessoaEndereco->setAttributeModel($this->oDadosRequisicao->results[0]->location->street->name,
                                                      $this->oDadosRequisicao->results[0]->location->street->number,
                                                      $this->oDadosRequisicao->results[0]->location->coordinates->latitude,
                                                      $this->oDadosRequisicao->results[0]->location->coordinates->longitude,
                                                      $this->modelCidade,
                                                      $this->modelPessoa);
        $this->modelPessoaEndereco->inserePessoaEndereco();
    }


}

?>