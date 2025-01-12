<?php

namespace lib;

use lib\estClassConexaoBD;
use Exception;

require_once '../autoload.php';

/**
 * Classe usada para realizar as querys no
 * banco de dados através do atributo sql.
 * 
 * @author Caio Micael Krieger
 */
Class estClassQuery {
    private $conexaoBD;
    protected $sql;
    protected $lastQuery;
    protected $quantidadeLinhas;

    public function __construct() {
        $this->conexaoBD = new estClassConexaoBD();
    }

    /**
     * Este método realiza a abertura de conexão e execução do SQL no banco de dados. Necessário setar o SQL. Para pegar resultado, usar o getNextRow
     * 
     * 
     */
    public function Open() {
        if ($this->conexaoBD->conectaDB()) {
            $this->lastQuery = pg_query($this->conexaoBD->getInternalConnection(), $this->sql);
            if($this->lastQuery) {
                $this->setQuantidadeLinhas(pg_num_rows($this->lastQuery));
            }
        }
    }


    /**
     * Este método realiza a abertura de conexão e execução do SQL por params ($1,$2...).
     * Necessário setar o SQL e para pegar o resultado usar o getNextRow
     * 
     * @param array $aDados
     */
    protected function openParams($aDados) {
        try {
            $this->conexaoBD->conectaDB();
            $this->lastQuery = pg_query_params($this->conexaoBD->getInternalConnection() , $this->sql,$aDados);
            if ($this->lastQuery) {
                $this->setQuantidadeLinhas(pg_num_rows($this->lastQuery));
            }
        } catch (Exception $e) {
            echo $e;
        }
    }


    /**
     * Este método realiza uma consulta ao banco de dados e realiza pg_fetch_all. Necessário setar o SQL.
     * 
     * 
     */
    protected function openFetchAll() {
        $this->conexaoBD->conectaDB();
        $result = pg_query($this->conexaoBD->getInternalConnection(), $this->sql);
        if ($result) {
            $rows = pg_fetch_all($result);
            return $rows;
        }
        else {
            return 'Dados não encontrados!';
        }
    }

    /**
     * Este método realiza a inserção de dados no banco de dados. Necessário setar o SQL.
     * 
     * @param Array $aDados
     */
    protected function insertAll($aDados) {
        try {
            $this->conexaoBD->conectaDB();
            $this->lastQuery = pg_query_params($this->conexaoBD->getInternalConnection() , $this->sql,$aDados);
            if ($this->lastQuery) {
                $this->setQuantidadeLinhas(pg_num_rows($this->lastQuery));
            }
        } catch (Exception $e) {
            echo $e;
        }
    }


    /**
     * Este método realiza o pg_fetch_assoc do SQL executado no método Open.
     * 
     * @return array
     */
    public function getNextRow() {
        return pg_fetch_assoc($this->lastQuery);
    }


    /**
     * Esta função verifica se o registro passado existe no banco de dados. Serve como um facilitador de código.
     * 
     * @param string $schema
     * @param string $table
     * @param string $column
     * @param mixed  $pk
     *
     * @return boolean
     */
    protected function isRegistroCadastrado($schema, $table, $column, $pk) {
        $aDados = array();
        array_push($aDados,$pk);
        $this->setSql (
                "SELECT EXISTS (
                                SELECT 1
                                  FROM $schema.$table
                                 WHERE $column = $1);"
        );
        $this->openParams($aDados);
        $result = $this->getNextRow();
        if ($result['exists'] === 't') {
            return true;
        }
        else {
            return false;
        }
    }


    public function getSql() {
        return $this->sql;
    }

    public function getQuantidadeLinhas() {
        return $this->quantidadeLinhas;
    }

    public function setSql($sql) {
        $this->sql = $sql;
    }

    public function setQuantidadeLinhas($qtde) {
        $this->quantidadeLinhas = $qtde;
    }

    private function setLastQuery($last) {
        $this->lastQuery = $last;
    }
}

?>