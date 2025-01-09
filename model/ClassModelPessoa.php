<?php

require_once '../lib/estClassQuery.php';

class ClassModelPessoa extends estClassQuery {
    private $seed;
    private $genero;
    private $nomePessoa;
    private $emailPessoa;
    private $telefonePessoa;
    private $celularPessoa;


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