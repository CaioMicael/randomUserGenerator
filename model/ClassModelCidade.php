<?php
namespace model;

use Exception;
use Throwable;
use lib\enum\estClassEnumMensagensWebbased;
use lib\estClassModel;

require_once '../autoload.php';


class ClassModelCidade extends estClassModel {
    private int    $cidadeCodigo;
    private string $cidadeNome;
    private object $Estado;
    private object $Pais;


    public function __construct() {
        parent::__construct();
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
        return 'tbcidade';
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
        $this->setPais($modelPais);
        $this->setEstado($modelEstado);
    }


    /**
     * Esta função insere a cidade no banco de dados conforme dados da API.
     * 
     */
    public function insereCidade($sCidadeNome, $iEstadoCodigo, $iPaisCodigo) {
        if (!$this->isCidadeCadastrada()) {
            if ($this->getEstado()->isEstadoPaisValido($iEstadoCodigo, $iPaisCodigo)) {
                $this->setSql($this->getQueryInsereCidade());
                $this->insertAll([$sCidadeNome,
                                  $iEstadoCodigo,
                                  $iPaisCodigo]);
                $result = $this->getNextRow();
                if (isset($result['cidadecodigo'])) {
                    $this->setCidadeCodigo($result['cidadecodigo']);
                }
            }
            else {
                throw new Exception(estClassEnumMensagensWebbased::webbased012->value);
                return;
            }
        }
        else if ($this->isCidadeCadastrada()) {
            $this->setCidadeCodigo($this->getQueryCidadeCodigo('cidadenome',$this->getCidadeNome()));
            throw new Exception(estClassEnumMensagensWebbased::webbased008->value);
            return;
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
        if (!$this->getEstado()->isEstadoCadastradoByCodigo($iEstadoCodigo)) {
            throw new Exception(estClassEnumMensagensWebbased::webbased004->value);
            return;
        }
        if (!$this->getPais()->isPaisCadastradoByCodigo($iPaisCodigo)) {
            throw new Exception(estClassEnumMensagensWebbased::webbased005->value);
            return;   
        }

        $this->setCidadeNome($sCidadeNome);
        $this->insereCidade($sCidadeNome, $iEstadoCodigo, $iPaisCodigo);
    }


    /**
     * Esta função exclui a cidade do banco de dados conforme parâmetro.
     * @param int $iCidadeCodigo
     */
    public function processaDadosExcluir($iCidadeCodigo) {
        $this->setCidadeCodigo($iCidadeCodigo);
        if ($this->isCidadeCadastradaChave($this->getCidadeCodigo())) {
            $this->setSql($this->getQueryDeleteCidade());
            try {
                $this->openParams(array($this->getCidadeCodigo()));
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
     * @param int $iCidadeCodigo
     * @param string $sCidadeNome
     * @param int $iEstadoCodigo
     * @param int $iPaisCodigo
     */
    public function processaDadosAlterar($iCidadeCodigo, $sCidadeNome, $iEstadoCodigo, $iPaisCodigo) {
        $this->setCidadeCodigo($iCidadeCodigo);
        $this->setCidadeNome($sCidadeNome);
        $this->getEstado()->setEstadoCodigo($iEstadoCodigo);
        $this->getPais()->setCodigoPais($iPaisCodigo);

        if (!$this->isCidadeCadastradaChave($iCidadeCodigo)) {
            throw new Exception(estClassEnumMensagensWebbased::webbased015->value);
            return;
        }
        if (!$this->getEstado()->isEstadoCadastradoByCodigo($iEstadoCodigo)) {
            throw new Exception(estClassEnumMensagensWebbased::webbased004->value);
            return;
        }
        if (!$this->getPais()->isPaisCadastradoByCodigo($iPaisCodigo)) {
            throw new Exception(estClassEnumMensagensWebbased::webbased005->value);
            return;   
        }
        if (!$this->getEstado()->isEstadoPaisValido($this->getEstado()->getEstadoCodigo(), $this->getPais()->getCodigoPais())) {
            throw new Exception(estClassEnumMensagensWebbased::webbased012->value);
            return;
        }


        $aDadosPersistidos = $this->getAllDadosCidade($iCidadeCodigo);
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
     * Este método verifica se a cidade está cadastrada pelo código repassado
     * no parâmetro.
     * @param int $iChave - Código da Cidade
     */
    private function isCidadeCadastradaChave($iChave) {
        return $this->isRegistroCadastrado('webbased','tbcidade','cidadecodigo',$iChave);
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


    /**
     * Este método retorna um array associativo dos dados de Cidade.
     * 
     * @param int $iCidadeCodigo
     * @return array
     */
    private function getAllDadosCidade($iCidadeCodigo) {
        $this->setCidadeCodigo($iCidadeCodigo);
        $this->setSql($this->getQueryAllDadosCidade());
        $this->openParams(array($this->getCidadeCodigo()));
        return $this->getNextRow();
    }
    
    
    /**************************************************************************************************************************************************************
     *************************************                                        QUERYs                                        ***********************************
     **************************************************************************************************************************************************************/
    

     /**
      * Este método retorna o SQL de consulta de dados da cidade conforme parametro repassado.
      */
    private function getQueryAllDadosCidade() {
        return "SELECT * FROM webbased.tbcidade WHERE cidadecodigo = $1";
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


    /**
     * Este método retorna o SQL de delete de cidade.
     * 
     * @return SQL
     */
    private function getQueryDeleteCidade() {
        return "DELETE FROM webbased.tbcidade WHERE cidadecodigo = $1";
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

    /**
     * Retorna o ModelEstado
     * @return ClassModelEstado
     */
    public function getEstado() {
        if (! isset($this->Estado)) {
            $this->setEstado(new ClassModelEstado());
        }
        return $this->Estado;
    }

    /**
     * Seta o ModelEstado
     * @param ClassModelEstado $Estado
     */
    public function setEstado(ClassModelEstado $Estado) {
        $this->Estado = $Estado;
    }

    /**
     * Retorna o ModelPais
     * @return ClassModelPais
     */
    public function getPais() {
        if (! isset($this->Pais)) {
            $this->setPais(new ClassModelPais());
        }
        return $this->Pais;
    }

    /**
     * Seta o ModelPais
     * @param ClassModelPais $Pais
     */
    public function setPais(ClassModelPais $Pais) {
        $this->Pais = $Pais;
    }

    /**
     * Este método retorna o atributo cidadeCodigo em forma de array associativo com o nome da coluna no BD.
     */
    public function getArrayCidadeCodigoColuna() {
        return ['cidadecodigo' => $this->getCidadeCodigo()];
    }
    
    /**
     * Este método retorna o atributo cidadeNome em forma de array associativo com o nome da coluna no BD.
     */
    public function getArrayCidadeNomeColuna() {
        return ['cidadenome' => $this->getCidadeNome()];
    }

    /**
     * Este método retorna um array associativo com os atributos do Model no formato nome da coluna no BD => valor Atributo.
     */
    public function getModeloColuna() {
        return [
            'cidadecodigo' => $this->getCidadeCodigo(),
            'cidadenome'   => $this->getCidadeNome(),
            'estadocodigo' => $this->getEstado()->getEstadoCodigo(),
            'paiscodigo'   => $this->getPais()->getCodigoPais()
        ];
    }
}


?>