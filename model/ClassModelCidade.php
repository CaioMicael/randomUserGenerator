<?php
namespace model;

use lib\estClassQuery;

require_once '../autoload.php';


class ClassModelCidade extends estClassQuery {
    private int    $cidadeCodigo;
    private string $cidadeNome;
    private object $modelEstado;
    private object $modelPais;


    public function __construct() {
        parent::__construct();
        $this->modelEstado = new ClassModelEstado;
        $this->modelPais   = new ClassModelPais;
    }


    /**
     * Esta função seta os atributos do Model.
     * 
     * @param string $cidadeNome
     * @param object $modelPais
     * @param object $modelEstado
     * 
     */
    public function setAttributeModelCidade($cidadeNome, $modelPais, $modelEstado) {
        $this->setCidadeNome($cidadeNome);
        $this->modelPais   = $modelPais;
        $this->modelEstado = $modelEstado;
    }


    /**
     * Esta função insere a cidade no banco de dados.
     * 
     */
    public function insereCidade() {
        if (!$this->isCidadeCadastrada()) {
            $this->setSql(
                "INSERT INTO webbased.tbcidade
                  VALUES (nextval(tbcidade_cidadecodigo_seq),$1,$2,$3) RETURNING cidadecodigo;"
            );
            $aDados = array();
            array_push($aDados,$this->getCidadeNome());
            array_push($aDados,$this->getEstadoCodigo());
            array_push($aDados,$this->getPaisCodigo());
            $this->insertAll($aDados);
            $result = $this->getNextRow();
            $this->setCidadeCodigo($result['cidadecodigo']);

        }
        else if ($this->isCidadeCadastrada()) {
            echo 'A cidade ' . $this->getCidadeNome() . ' já está cadastrada!';
        }
    }


    /**
     * Esta função verifica se a cidade já está cadastrada no banco de dados.
     * 
     * @return boolean
     */
    private function isCidadeCadastrada() {
        return $this->isRegistroCadastrado('webbased','tbcidade','cidadenome',$this->getCidadeNome(),true);
    }


    /**
     * Esta função retorna o código da cidade, podendo filtrar qualquer parâmetro.
     * 
     * @param string $column
     * @param mixed  $filter
     * 
     * @return int
     */
    private function getQueryCidadeCodigo($column,$filter) {
        $this->setSql(
            "SELECT cidadecodigo
               FROM webbased.tbcidade
              WHERE $column = $1"
        );
        $this->openParams([$filter]);
        return $this->getNextRow();
    }


    public function getCidadeCodigo() {
        return $this->cidadeCodigo;
    }

    public function getCidadeNome() {
        return $this->cidadeNome;
    }

    public function getEstadoCodigo() {
        return $this->modelEstado->getEstadoCodigo();
    }

    public function getPaisCodigo() {
        return $this->modelPais->getPaisCodigo();
    }

    public function setCidadeCodigo($cidadeCodigo) {
        $this->cidadeCodigo = $cidadeCodigo;
    }

    public function setCidadeNome($cidadeNome) {
        $this->cidadeNome = $cidadeNome;
    }

}


?>