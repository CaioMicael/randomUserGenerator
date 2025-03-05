<?php
namespace model;

use lib\estClassModel;
use lib\enum\estClassEnumMensagensWebbased;
use Exception;

require_once '../autoload.php';

class ClassModelPais extends estClassModel {
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
            $this->setSql($this->getQueryInserePais());
            $this->insertAll([$this->getNomePais()]);
            $result = $this->getNextRow();
            if (isset($result['paiscodigo'])) {
                $this->setCodigoPais($result['paiscodigo']);
            }
        }
        else {
            $this->setCodigoPais($this->getQueryCodigoPais('paisnome',$this->getNomePais()));
            throw new Exception(estClassEnumMensagensWebbased::webbased007->value);
            return;
        }
    }


    /**
     * Este método retorna os dados da consulta de país
     * 
     * @return array
     */
    public function getDadosConsultaPais() {
        $this->setSql($this->getQueryConsultaPais());
        return $this->openFetchAll();
    }


    /**
     * Esta função verifica se o país já está cadastrado no banco de dados.
     * 
     * @param string $nomePais
     * @return boolean
     */
    private function isPaisCadastrado($nomePais) {
        return $this->isRegistroCadastrado('webbased','tbpais','paisnome',$nomePais);
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


    /**
     * Este método retorna booleano se o Pais existe no BD
     * de acordo com o código repassado.
     * 
     * @param int $iCodigoPais
     * @return boolean
     */
    public function isPaisCadastradoByCodigo($iCodigoPais) {
        return $this->isRegistroCadastrado('webbased','tbpais','paiscodigo',$iCodigoPais);
    }


    /*************************************************************************************************************************************************************/
    /************************************                                        QUERYs                                        ***********************************/
    /*************************************************************************************************************************************************************/


    /**
     * Este método retorna o SQL de consulta de país
     * 
     * @return Query
     */
    private function getQueryConsultaPais() {
        return "
          SELECT paiscodigo,
  		         paisnome
            FROM webbased.tbpais
        ORDER BY paiscodigo
        ";
    }


    /**
     * Esta função retorna o código do País, podendo filtrar qualquer parâmetro.
     * @param string $column
     * @param mixed  $filter
     * 
     * @return int 
     */
    private function getQueryCodigoPais($column, $filter) {
        $this->setSql(
            "SELECT paiscodigo
               FROM webbased.tbpais
              WHERE $column = $1"
        );
        $this->openParams([$filter]);
        $result = $this->getNextRow();
        return $result['paiscodigo'];
    }


    /**
     * Este método retorna SQL de inserção no banco do Estado, utiliza query params.
     * 
     * @return SQL
     */
    private function getQueryInserePais() {
        return "INSERT INTO webbased.tbpais 
                VALUES (nextval('webbased.tbpais_paiscodigo_seq'),$1) RETURNING paiscodigo;";
    }


    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 
    
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

    /**
     * Este método retorna o atributo em forma de array associativo com o nome da coluna no BD.
     */
    public function getArrayCodigoPaisColuna() {
        return ["paiscodigo" => $this->getCodigoPais()];
    }
}

?>