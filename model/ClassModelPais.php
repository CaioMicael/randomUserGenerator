<?php
namespace model;

use lib\estClassModel;
use lib\enum\estClassEnumMensagensWebbased;
use Exception;

require_once '../autoload.php';

class ClassModelPais extends estClassModel {
    private int    $codigoPais;
    private string $nomePais;


    public function __construct() {
        parent::__construct();
        $this->setChave(['paiscodigo' => '']);
    }


    /**
     * {@InheritDoc}
     * @see estClassModel::schemaModelo()
     */
    protected function schemaModelo(): string {
        return 'webbased';
    }
    

    /**
     * {@InheritDoc}
     * @see estClassModel::tableModelo()
     */
    protected function tableModelo(): string {
        return 'tbpais';
    }


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
     * Esta função processa os dados de inclusão do País.
     * @param string $sPaisNome
     * @return void
     */
    public function processaDadosIncluir($sPaisNome) {
        if (isset($sPaisNome) && empty($sPaisNome)) {
            throw new Exception(estClassEnumMensagensWebbased::webbased003->value);
            return;
        }
        $this->setNomePais($sPaisNome);
        try {
            $this->inserePais();
        }
        catch (Exception $e) {
            throw new Exception(estClassEnumMensagensWebbased::webbased003->value);
            return;
        }
    }


    /**
     * Esta função exclui o País do banco de dados conforme parâmetro.
     * @param int $iPaisCodigo
     */
    public function processaDadosExcluir($iPaisCodigo) {
        $this->setCodigoPais($iPaisCodigo);
        $this->setChave($this->getArrayCodigoPaisColuna());
        if ($this->isPaisCadastradoByCodigo($this->getCodigoPais())) {
            try {
                $this->doExcluirRegistro();
            }
            catch (Exception $e) {
                throw new Exception(estClassEnumMensagensWebbased::webbased003->value);
                return;
            }
        }
    }


    /**
     * Este método realiza as validações de alteração de dados e chama o método
     * responsável por alterar os registros.
     * 
     * @param int $iPaisCodigo
     * @param string $sPaisNome
     */
    public function processaDadosAlterar($iPaisCodigo, $sPaisNome) {
        $this->setCodigoPais($iPaisCodigo);
        $this->setNomePais($sPaisNome);

        if (!$this->isPaisCadastradoByCodigo($this->getCodigoPais())) {
            throw new Exception(estClassEnumMensagensWebbased::webbased005->value);
            return;
        }
        if ($this->isPaisCadastrado($this->getNomePais())) {
            throw new Exception(estClassEnumMensagensWebbased::webbased007->value);
            return;   
        }

        $this->aChave = $this->getArrayCodigoPaisColuna();
        $aDadosPersistidos = $this->getAllDadosByChave();
        try {
            $this->doAlteraRegistro(
                $this->getModeloColuna(),
                $aDadosPersistidos
            );
        }
        catch (Exception $e) {
            throw new Exception(estClassEnumMensagensWebbased::webbased003->value);
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
     * Este método retorna booleano se o Pais existe no BD
     * de acordo com o código repassado.
     * 
     * @param int $iCodigoPais
     * @return boolean
     */
    public function isPaisCadastradoByCodigo($iCodigoPais) {
        return $this->isRegistroCadastrado('webbased','tbpais','paiscodigo',$iCodigoPais);
    }


/************************************************** QUERYS *******************************************************
 *****************************************************************************************************************/   
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


/************************************* GETTERS E SETTERS DOS ATRIBUTOS *******************************************
 *****************************************************************************************************************/  

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
     * @return array
     */
    public function getArrayCodigoPaisColuna() {
        return ["paiscodigo" => $this->getCodigoPais()];
    }

    /**
     * Este método retorna o atributo em forma de array associativo com o nome da coluna no BD.
     * @return array
     */
    public function getArrayNomePaisColuna() {
        return ["paisnome" => $this->getNomePais()];
    }

    /**
     * Este método retorna um array associativo com os atributos do Model no formato nome da coluna no BD => valor Atributo.
     * @return array
     */
    public function getModeloColuna() {
        return [
            'paiscodigo' => $this->getCodigoPais(),
            'paisnome'   => $this->getNomePais()
        ];
    }
}

?>