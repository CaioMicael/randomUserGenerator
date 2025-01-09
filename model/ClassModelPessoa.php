<?php

require_once '../lib/estClassQuery.php';

class ClassModelPessoa extends estClassQuery {
    private $seed;
    private $genero;
    private $nomePessoa;
    private $emailPessoa;
    private $telefonePessoa;
    private $celularPessoa;


    /**
     * Este método seta os atributos do model.
     * 
     * @param string $seed
     * @param string $genero
     * @param string $nomePessoa
     * @param string $emailPessoa
     * @param string $telefonePessoa
     * @param string $celularPessoa
     */
    public function setAttributeModel($seed, $genero, $nomePessoa, $emailPessoa, $telefonePessoa, $celularPessoa) {
        $this->setSeed($seed);
        $this->setGenero($genero);
        $this->setnomePessoa($nomePessoa);
        $this->setEmailPessoa($emailPessoa);
        $this->setTelefonePessoa($telefonePessoa);
        $this->setCelularPessoa($celularPessoa);
    }


    /**
     * Esta função realiza a inserção de pessoa no banco de dados.
     * 
     */
    public function inserePessoa() {
        if ($this->isPessoaJaCadastrada($this->seed)) {
            echo 'deu algo ruim!';
        }
        else {
            echo 'deu boa!';
        }
    }


    /**
     * Esta função verifica pelo seed se a pessoa já está inserida no banco de dados.
     * 
     * @param string $seed
     * @return boolean
     */
    public function isPessoaJaCadastrada($seed) {
        $this->setSql(
            "SELECT EXISTS (
                            SELECT *
                              FROM webbased.tbpessoa
                             WHERE seed = '$seed');"
        );
        $result = $this->openFetchAll();
        if ($result == 'true') {
            return true;
        }
        else {
            return false;
        }

    }


    public function getSeed() {
        return $this->seed;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getnomePessoa() {
        return $this->nomePessoa;
    }

    public function getEmailPessoa() {
        return $this->emailPessoa;
    }

    public function getTelefonePessoa() {
        return $this->telefonePessoa;
    }

    public function getCelularPessoa() {
        return $this->celularPessoa;
    }

    public function setSeed($seed) {
        $this->seed = $seed;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function setnomePessoa($nome) {
        $this->nomePessoa = $nome;
    }

    public function setEmailPessoa($email) {
        $this->emailPessoa = $email;
    }    

    public function setTelefonePessoa($telefone) {
        $this->telefonePessoa = $telefone;
    }    

    public function setCelularPessoa($celular) {
        $this->celularPessoa = $celular;
    }    

}

?>