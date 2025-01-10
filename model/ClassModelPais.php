<?php
namespace model;

use lib\estClassQuery;

require_once '../autoload.php';

class ClassModelPais extends estClassQuery {
    private int $codigoPais;
    private string $nomePais;


    public function setAttributeModel($nomePais) {
        $this->setNomePais($nomePais);
    }


    public function inserePais() {
        if (!$this->isCidadeCadastrada($this->getNomePais())) {
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
     * Esta função verifica se a cidade já está cadastrada no banco de dados.
     * 
     * @param string $nomePais
     * @return boolean
     */
    private function isCidadeCadastrada($nomePais) {
        return $this->isRegistroCadastrado('webbased','tbpais','paisnome',$nomePais,true);
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