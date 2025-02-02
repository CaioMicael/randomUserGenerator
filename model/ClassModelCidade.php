<?php
namespace model;

use Exception;
use lib\estClassEnumMensagens;
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
     * Esta função insere a cidade no banco de dados conforme dados da API.
     * 
     */
    public function insereCidade($sCidadeNome, $iEstadoCodigo, $iPaisCodigo) {
        if (!$this->isCidadeCadastrada()) {
            $this->setSql($this->getQueryInsereCidade());
            $this->insertAll([$sCidadeNome,
                              $iEstadoCodigo,
                              $iPaisCodigo]);
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
     * Esta função insere cidade no banco de dados
     * conforme parâmetros repassados e retorna para o front end
     * a inserção da cidade.
     * 
     * @param string $sCidadeNome
     * @param int    $iEstadoCodigo
     * @param int    $iPaisCodigo
     */
    public function processaDadosIncluir($sCidadeNome, $iEstadoCodigo, $iPaisCodigo) {
        if (!$this->modelEstado->isEstadoCadastradoByCodigo($iEstadoCodigo)) {
            throw new Exception(estClassEnumMensagens::webbased004->value);
            return;
        }
        if (!$this->modelPais->isPaisCadastradoByCodigo($iPaisCodigo)) {
            throw new Exception(estClassEnumMensagens::webbased005->value);
            return;   
        }

        $this->setCidadeNome($sCidadeNome);
        $this->insereCidade($sCidadeNome, $iEstadoCodigo, $iPaisCodigo);
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
     * Este método retorna um array associativo dos dados de Cidade.
     * 
     * @param int $iLimit
     * @return array
     */
    public function getDadosConsultaCidade($iLimit) {
        $this->setSql($this->getQueryDadosConsultaCidade($iLimit));
        return $this->openFetchAll();
    }
    
    
    /**************************************************************************************************************************************************************
     *************************************                                        QUERYs                                        ***********************************
     **************************************************************************************************************************************************************/
    

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
    

    /**
     * Este método retorna o SQL de inserção de cidade com params
     * 
     * @return SQL
     */
    private function getQueryInsereCidade() {
        return "INSERT INTO webbased.tbcidade
                VALUES (nextval('webbased.tbcidade_cidadecodigo_seq'),$1,$2,$3) RETURNING cidadecodigo;";
    }


    /**************************************************************************************************************************************************************
     *************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************
     **************************************************************************************************************************************************************/    
    
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