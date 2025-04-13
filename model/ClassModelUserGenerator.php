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
    private object $Pessoa;
    private object $PessoaEndereco;
    private object $Pais;
    private object $Estado;
    private object $Cidade;

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
        $this->getPais()->setAttributeModel($this->oDadosRequisicao->results[0]->location->country);
        $this->getPais()->inserePais();
    }


    /**
     * Esta função envia os dados para o ModelEstado inserir no banco.
     * 
     */
    private function enviaDadosToModelEstado() {
        $this->getEstado()->setAttributeModel($this->oDadosRequisicao->results[0]->location->state, $this->getPais()->getCodigoPais());
        $this->getEstado()->insereEstado();
    }


    /**
     * Esta função envia dos dados para o ModelCidade inserir no banco.
     * 
     */
    private function enviaDadosToModelCidade() {
        $this->getCidade()->setAttributeModelCidade($this->oDadosRequisicao->results[0]->location->city, $this->getPais(), $this->getEstado());
        $this->getCidade()->insereCidade(
            $this->getCidade()->getCidadeNome(),
            $this->getEstado()->getEstadoCodigo(),
            $this->getPais()->getCodigoPais()
        );
    }


    /**
     * Esta função envia os dados para o ModelPessoa inserir no banco.
     * 
     */
    private function enviaDadosToModelPessoa() {
        $this->getPessoa()->setAttributeModel($this->oDadosRequisicao->info->seed, 
                                              $this->oDadosRequisicao->results[0]->gender, 
                                              $this->oDadosRequisicao->results[0]->name->first . ' ' . $this->oDadosRequisicao->results[0]->name->last, 
                                              $this->oDadosRequisicao->results[0]->email, 
                                              $this->oDadosRequisicao->results[0]->phone, 
                                              $this->oDadosRequisicao->results[0]->cell);
        $this->getPessoa()->inserePessoa();
    }


    /**
     * Esta função envia os dados para o ModelPessoaEndereco inserir no banco.
     */
    public function enviaDadosToModelPessoaEndereco() {
        $this->getPessoaEndereco()->setAttributeModel($this->oDadosRequisicao->results[0]->location->street->name,
                                                      $this->oDadosRequisicao->results[0]->location->street->number,
                                                      $this->oDadosRequisicao->results[0]->location->coordinates->latitude,
                                                      $this->oDadosRequisicao->results[0]->location->coordinates->longitude,
                                                      $this->getCidade(),
                                                      $this->getPessoa());
        $this->getPessoaEndereco()->inserePessoaEndereco();
    }

    /**
     * Retorna o ModelPessoa
     * @return ClassModelPessoa
     */
    public function getPessoa() {
        if (! isset($this->Pessoa)) {
            $this->setPessoa(new ClassModelPessoa());
        }
        return $this->Pessoa;
    }

    /**
     * Seta o ModelPessoa
     * @param ClassModelPessoa $Pessoa
     */
    public function setPessoa(ClassModelPessoa $Pessoa) {
        $this->Pessoa = $Pessoa;
    }

    /**
     * Retorna o ModelPessoaEndereco
     * @return ClassModelPessoaEndereco
     */
    public function getPessoaEndereco() {
        if (! isset($this->PessoaEndereco)) {
            $this->setPessoaEndereco(new ClassModelPessoaEndereco());
        }
        return $this->PessoaEndereco;
    }

    /**
     * Seta o ModelPessoaEndereco
     * @param ClassModelPessoaEndereco $PessoaEndereco
     */
    public function setPessoaEndereco(ClassModelPessoaEndereco $PessoaEndereco) {
        $this->PessoaEndereco = $PessoaEndereco;
    }

    /**
     * Retorna o Modelo de Cidade
     * @return ClassModelCidade
     */
    public function getCidade() {
        if (! isset($this->Cidade)) {
            $this->setCidade(new ClassModelCidade());
        }
        return $this->Cidade;
    }

    /**
     * Seta o ModelCidade
     * @param ClassModelCidade $Cidade
     */
    public function setCidade(ClassModelCidade $Cidade) {
        $this->Cidade = $Cidade;
    }

    /**
     * Retorna o ModelEstado
     * @return ClassModelEstado
     */
    public function getEstado() {
        if (! isset($this->Estado)) {
            $this->setEstado(new ClassModelEstado());
        }
        return $this->Estado;
    }

    /**
     * Seta o ModelEstado
     * @param ClassModelEstado $Estado
     */
    public function setEstado(ClassModelEstado $Estado) {
        $this->Estado = $Estado;
    }

    /**
     * Retorna o ModelPais
     * @return ClassModelPais
     */
    public function getPais() {
        if (! isset($this->Pais)) {
            $this->setPais(new ClassModelPais());
        }
        return $this->Pais;
    }

    /**
     * Seta o ModelPais
     * @param ClassModelPais $Pais
     */
    public function setPais(ClassModelPais $Pais) {
        $this->Pais = $Pais;
    }
}

?>