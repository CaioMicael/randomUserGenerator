<?php
namespace model;

use lib\estClassQuery;

require_once '../autoload.php';

class ClassModelPais extends estClassQuery {
    private int $codigoPais;
    private string $nomePais;


    public function setAttributeModel($nomePais) {
        $this->setNomePais($nomePais);
        $this->setCodigoPaisByNome($this->nomePais);
    }


    public function inserePais() {
        if (!$this->isPaisCadastrado($this->getNomePais())) {
            $this->setSql(
                "INSERT INTO webbased.tbpais 
                 VALUES (nextval('webbased.tbpais_paiscodigo_seq'),$1);"
            );
            $aDados = array();
            array_push($aDados, $this->getNomePais());
            $this->insertAll($aDados);

        }
        else {
            echo 'cidade já cadastrada';
        }
    }


    /**
     * Esta função verifica se o país já está cadastrado no banco de dados.
     * 
     * @param string $nomePais
     * @return boolean
     */
    private function isPaisCadastrado($nomePais) {
        return $this->isRegistroCadastrado('webbased','tbpais','paisnome',$nomePais,true);
    }


    public function setCodigoPaisByNome($nomePais) {
        if (!$this->isPaisCadastrado($nomePais)) {
            echo 'Pais não encontrado!';
        }
        else if ($this->isPaisCadastrado($nomePais)) {
            $this->setSql(
                "SELECT paiscodigo
                   FROM webbased.tbpais
                  WHERE paisnome = '$nomePais';"
            );
            $result = $this->openFetchAll();
            $this->setCodigoPais($result[0]);
        }
    }


    public function getCodigoPais() {
        return $this->codigoPais;
    }

    public function getNomePais() {
        return $this->nomePais;
    }

    public function setCodigoPais($pais) {
        $this->codigoPais = $pais;
    }

    public function setNomePais($nome) {
        $this->nomePais = $nome;
    }
}

?>