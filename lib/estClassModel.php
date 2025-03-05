<?php
namespace lib;
use lib\estClassQuery;
use lib\estClassErrorHandler;
use Exception;

require_once '../autoload.php';

/**
 * Esta classe é a base dos demais Models.
 * 
 * @package lib
 * @author Caio Micael Krieger
 * @since 06/02/2025
 */
class estClassModel extends estClassQuery {
    protected string $schema;
    protected string $table;


    /**
     * Este método realiza a persistência de um objeto de acordo com os dados no banco de dados.
     * @param string $schema
     * @param string $table
     * @param array  $columnDado
     * @return array
     */
    protected function persisteObjeto($schema, $table, $columnDado) {
        $this->setSql($this->persisteObjetoQuery($schema, $table, $columnDado));
        return $this->openFetchAll();
    }


    /**
     * Esta função retorna o SQL para a função persisteObjeto.
     * 
     * @param string $schema
     * @param string $table
     * @param array  $columnDado
     * @return boolean
     */
    private function persisteObjetoQuery($schema, $table, $columnDado) {
        $query = "
                SELECT *
                  FROM $schema.$table
                 WHERE ";
        foreach ($columnDado as $coluna => $valor) {
            if (array_key_first($columnDado) == $coluna) {
                $query = $query. " $coluna = $valor"; 
            }
            else {
                $query = $query. " AND $coluna = $valor";  
            }
        }
        $query = $query.");";
        return $query;
    }


    /**
     * Este método realiza a alteração de um registro no banco de dados.
     * @param array $aDadosAlterar - Dados a serem alterados
     * @param array $aDadosBD - Dados do banco de dados
     * @return void
     */
    protected function doAlteraRegistro($aDadosAlterar, $aDadosBD) {
        $aRegistrosAlterar = array_diff($aDadosAlterar, $aDadosBD);
        if (empty($aRegistrosAlterar)) {
            return;
        }
        $this->setSql($this->getQueryAlteraRegistro($aRegistrosAlterar, $aDadosBD));
        try {
            $this->openFetchAll();
        }
        catch (Exception $e) {
            return new Exception($e);
        }
    }


    /**
     * Este método retorna o SQL de update de registro.
     * @param $aDados - Dados a serem alterados
     * @param $aDadosAlterar - Dados a serem filtrados no SQL
     * @return query
     */
    protected function getQueryAlteraRegistro($aDados, $aDadosAlterar) {
        $query = "UPDATE ".$this->getSchema().".".$this->getTable();
        foreach ($aDados as $coluna => $valor) {
            if (array_key_first($aDados) == $coluna) {
                $query .= " SET $coluna = '$valor'"; 
            }
            else {
                $query .= ", $coluna = '$valor'";  
            }
        }
        foreach ($aDadosAlterar as $coluna => $valor) {
            if (array_key_first($aDadosAlterar) == $coluna) {
                $query .= " WHERE $coluna = '$valor'"; 
            }
            else {
                $query .= " AND $coluna = '$valor'";  
            }
        }
        $query .=";";
        return $query;
    }


    protected function getSchema() {
        return $this->schema;
    }

    protected function getTable() {
        return $this->table;
    }

    protected function setSchema($schema) {
        $this->schema = $schema;
    }

    protected function setTable($table) {
        $this->table = $table;
    }
}

?>