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
            $this->setSql($this->getQueryInsereCidade());
            $this->insertAll([$this->getCidadeNome(),
                              $this->modelEstado->getEstadoCodigo(),
                              $this->modelPais->getCodigoPais()]);
            $result = $this->getNextRow();
            if (isset($result['cidadecodigo'])) {
                $this->setCidadeCodigo($result['cidadecodigo']);
            }

        }
        else if ($this->isCidadeCadastrada()) {
            $this->setCidadeCodigo($this->getQueryCidadeCodigo('cidadenome',$this->getCidadeNome()));
            echo 'A cidade ' . $this->getCidadeNome() . ' já está cadastrada!';
        }
    }


    /**
     * Esta função verifica se a cidade já está cadastrada no banco de dados.
     * 
     * @return boolean
     */
    private function isCidadeCadastrada() {
        return $this->isRegistroCadastrado('webbased','tbcidade','cidadenome',$this->getCidadeNome());
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
        $result = $this->getNextRow();
        return $result['cidadecodigo'];
    }


    /**
     * Este método retorna o SQL de inserção de cidade com params
     * 
     * @return SQL
     */
    private function getQueryInsereCidade() {
        return "INSERT INTO webbased.tbcidade
                VALUES (nextval('webbased.tbcidade_cidadecodigo_seq'),$1,$2,$3) RETURNING cidadecodigo;";
    }


    /**
     * Este método retorna um array associativo dos dados de Cidade.
     * 
     * @param int $iLimit
     * @return array
     */
    public function getDadosConsultaCidade($iLimit) {
        $this->setSql($this->getQueryDadosConsultaCidade($iLimit));
        return $this->openFetchAll();
    }


    /**
     * Este método retorna query com consulta de cidade.
     * 
     * @param int $iLimit
     * @return SQL
     */
    private function getQueryDadosConsultaCidade($iLimit) {
        return "  SELECT cidadecodigo,
	                     cidadenome,
	                     estadonome,
	                     paisnome
                    FROM webbased.tbcidade
                    JOIN webbased.tbestado
                      ON tbcidade.estadocodigo = tbestado.estadocodigo
                    JOIN webbased.tbpais
                      ON tbpais.paiscodigo = tbcidade.paiscodigo
                ORDER BY cidadecodigo
                   LIMIT $iLimit";
    }


    public function getCidadeCodigo() {
        return $this->cidadeCodigo;
    }

    public function getCidadeNome() {
        return $this->cidadeNome;
    }

    public function setCidadeCodigo($cidadeCodigo) {
        $this->cidadeCodigo = $cidadeCodigo;
    }

    public function setCidadeNome($cidadeNome) {
        $this->cidadeNome = $cidadeNome;
    }

}


?>