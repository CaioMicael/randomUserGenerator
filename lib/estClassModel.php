<?php
namespace lib;
use lib\estClassQuery;

require_once '../autoload.php';

/**
 * Esta classe é a base dos demais Models.
 * 
 * @package lib
 * @author Caio Micael Krieger
 * @since 06/02/2025
 */
class estClassModel extends estClassQuery {



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
}

?>