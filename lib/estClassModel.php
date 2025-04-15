<?php
namespace lib;

use lib\estClassQuery;
use lib\estClassMensagem;
use lib\enum\estClassEnumMensagensWebbased;
use Exception;

require_once '../autoload.php';

/**
 * Esta classe é a base dos demais Models.
 * 
 * @package lib
 * @author Caio Micael Krieger
 * @since 06/02/2025
 */
abstract class estClassModel extends estClassQuery {
    protected string $schema;
    protected string $table;
    protected array $aChave;
    private object $controller;


    public function __construct() {
        $this->setSchema($this->schemaModelo());
        $this->setTable($this->tableModelo());
    }

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
     * Este método retorna todos os registros encontrados na tabela do modelo
     * filtrando apenas pela chave do modelo.
     * @param $aValorChave - Valor da chave a ser filtrada.
     * @return array
     */
    protected function getAllDadosByChave() {
        $this->setSql($this->getQueryAllDadosByChave());
        $this->Open();
        return $this->getNextRow();
    }

    /**
     * Esta função pode ser utilizada para excluir um registro do banco de dados.
     * Necessário que a chave esteja setada para utilizar a função.
     * @return void
     */
    protected function doExcluirRegistro() {
        $this->setSql($this->getQueryExcluirRegistro());
        if (empty(array_filter($this->getChave()))) {
            return estClassMensagem::geraMensagemAlertaTela(estClassEnumMensagensWebbased::webbased003);
        }
        try {
            $this->openFetchAll();
        }
        catch (Exception $e) {
            return new Exception($e);
        }
    }

/********************************************* Querys ***********************************************
 ****************************************************************************************************/ 
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


    /**
     * Este método retorna a query que deleta registros conforme chave da tabela.
     * @return SQL
     */
    private function getQueryExcluirRegistro() {
        $query = "DELETE FROM ".$this->getSchema().".".$this->getTable();
        foreach ($this->getChave() as $coluna => $valor) {
            if (array_key_first($this->getChave()) == $coluna) {
                $query .= " WHERE $coluna = '$valor'"; 
            }
            else {
                $query .= " AND $coluna = '$valor'";  
            }
        }
        $query .=";";
        return $query;
    }


    /**
     * Este método retorna o SQL de select de todos os dados filtrando pela chave do modelo.
     * @return SQL
     */
    private function getQueryAllDadosByChave() {
        if (empty($this->getChave())) {
            return;
        }
        $query = "SELECT * 
                    FROM ".$this->getSchema().".".$this->getTable()." 
                   WHERE ". array_keys($this->getChave())[0] ." = ". array_values($this->getChave())[0] .";";
        return $query;
    }

/**************************************** Métodos Abstratos *****************************************
 ****************************************************************************************************/ 

    /**
     * Deve retornar o nome do schema do modelo.
     * @return string $schema
     */
    abstract protected function schemaModelo(): string;

    /**
     * Deve retornar o nome da tabela do modelo.
     * @return string $table
     */
    abstract protected function tableModelo(): string;


/*************************************** GETTERS E SETTERS DOS ATRIBUTOS *****************************************
 *****************************************************************************************************************/    

    private function getSchema() {
        return $this->schema;
    }

    private function getTable() {
        return $this->table;
    }

    protected function getChave() {
        return $this->aChave;
    }

    private function setSchema($schema) {
        $this->schema = $schema;
    }

    private function setTable($table) {
        $this->table = $table;
    }

    protected function setChave($aChave) {
        $this->aChave = $aChave;
    }

    /**
     * Retorna uma nova instância do controller.
     * @return Controller
     */
    protected function getInstanceController() {
        $modelClassName = get_class($this);
        // Extrair somente o nome da classe sem o namespace
        $parts = explode('\\', $modelClassName);
        $simpleClassName = end($parts);
        
        $controllerClassName = str_replace('Controller', 'ViewManutencao', $simpleClassName);
        // Adicionar o namespace correto para views
        $fullyQualifiedControllerName = 'view\\' . $controllerClassName;
        
        return new $fullyQualifiedControllerName();
    }

    /**
     * Retorna o Controller do model.
     * @return Controller
     */
    protected function getController() {
        if (!isset($this->controller)) {
            $this->setController($this->getInstanceController());
        }
        return $this->controller;
    }

    /**
     * Seta o Controller do model.
     * @param Controller $controller
     */
    private function setController($controller) {
        $this->controller = $controller;
    }
}

?>