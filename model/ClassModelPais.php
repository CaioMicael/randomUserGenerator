<?php
namespace model;

use lib\estClassQuery;

require_once '../autoload.php';

class ClassModelPais extends estClassQuery {
    private int    $codigoPais;
    private string $nomePais;


    /**
     * Esta função seta os atributos do model.
     * 
     * @param string $nomePais
     */
    public function setAttributeModel($nomePais) {
        $this->setNomePais($nomePais);
    }


    /**
     * Esta função insere o país no banco de dados.
     * 
     */
    public function inserePais() {
        if (!$this->isPaisCadastrado($this->getNomePais())) {
            $this->setSql(
                "INSERT INTO webbased.tbpais 
                 VALUES (nextval('webbased.tbpais_paiscodigo_seq'),$1) RETURNING paiscodigo;"
            );
            $aDados = array();
            array_push($aDados, $this->getNomePais());
            $this->insertAll($aDados);
            $result = $this->getNextRow();
            if (isset($result['paiscodigo'])) {
                $this->setCodigoPais($result['paiscodigo']);
            }
        }
        else {
            echo 'O país ' . $this->getNomePais() . ' já está cadastrado.';
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


    /**
     * @deprecated
     * Esta função é utilizada para setar o código do país, procurando o mesmo pelo nome no banco de dados.
     * Se o país ainda não estiver no banco, ele simplesmente não seta o código no modelo pois ainda não tem um código.
     * 
     * @param string $nomePais
     */
    public function setCodigoPaisByNome($nomePais) {
        if ($this->isPaisCadastrado($nomePais)) {
            $this->setSql(
                "SELECT paiscodigo
                   FROM webbased.tbpais
                  WHERE paisnome = '$nomePais';"
            );
            $this->Open();
            $result = $this->getNextRow();
            $this->setCodigoPais($result['paiscodigo']);
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