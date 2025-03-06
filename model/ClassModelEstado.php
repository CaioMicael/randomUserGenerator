<?php
namespace model;

use lib\estClassModel;
use lib\enum\estClassEnumMensagensWebbased;
use Exception;

require_once '../autoload.php';

class ClassModelEstado extends estClassModel {
    private int    $estadoCodigo;
    private string $estadoNome;
    private int    $codigoPais;
    private object $modelPais;
    
    
    public function __construct() {
        parent::__construct();
        $this->modelPais = new ClassModelPais;
        $this->setSchema('webbased');
        $this->setTable('tbestado');
        $this->setChave(['estadocodigo' => '']);
    }


    /**
     * Esta função seta os atributos do model.
     * 
     * @param string $estadoNome
     * @param int    $codigoPais
     */
    public function setAttributeModel($estadoNome, $codigoPais) {
        $this->setEstadoNome($estadoNome);
        $this->setCodigoPais($codigoPais);
    }


    /**
     * Esta função insere o Estado no banco de dados.
     * 
     */
    public function insereEstado() {
        if (!$this->isEstadoCadastrado()) {
            $this->setSql($this->getQueryInsereEstado());
            $this->insertAll([$this->getCodigoPais(),$this->getEstadoNome()]);
            $result = $this->getNextRow();
            if (isset($result['estadocodigo'])) {
                $this->setEstadoCodigo($result['estadocodigo']);
            }
        }
        else if ($this->isEstadoCadastrado()) {
            $this->setEstadoCodigo($this->getQueryCodigoEstado('estadonome',$this->getEstadoNome()));
            throw new Exception(estClassEnumMensagensWebbased::webbased009->value);
            return;
        }
    }


    /**
     * Esta função insere Estado no banco de dados conforme parâmetros repassados e retorna para o front end.
     * 
     * @param string $sCidadeNome
     * @param int    $iEstadoCodigo
     * @param int    $iPaisCodigo
     */
    public function processaDadosIncluir($sEstadoNome, $iPaisCodigo, $sPaisNome) {
        $this->setEstadoNome($sEstadoNome);
        $this->setCodigoPais($iPaisCodigo);
        if ($this->isEstadoCadastrado()) {
            throw new Exception(estClassEnumMensagensWebbased::webbased009->value);
            return;
        }
        if (!$this->modelPais->isPaisCadastradoByCodigo($iPaisCodigo)) {
            throw new Exception(estClassEnumMensagensWebbased::webbased005->value);
            return;   
        }

        $this->insereEstado();
    }


    /**
     * Esta função exclui o Estado do banco de dados conforme parâmetro.
     * @param int $iCidadeCodigo
     */
    public function processaDadosExcluir($iEstadoCodigo) {
        $this->setEstadoCodigo($iEstadoCodigo);
        if ($this->isEstadoCadastradoByCodigo($this->getEstadoCodigo())) {
            $this->setSql($this->getQueryDeleteEstado());
            try {
                $this->openParams(array($this->getEstadoCodigo()));
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
     * @param int $iEstadoCodigo
     * @param string $sEstadoNome
     * @param int $iPaisCodigo
     * @param int $sPaisNome
     */
    public function processaDadosAlterar($iEstadoCodigo, $sEstadoNome, $iPaisCodigo, $sPaisNome) {
        $this->setEstadoCodigo($iEstadoCodigo);
        $this->setEstadoNome($sEstadoNome);
        $this->modelPais->setCodigoPais($iPaisCodigo);
        $this->modelPais->setNomePais($sPaisNome);

        if (!$this->isEstadoCadastradoByCodigo($this->getEstadoCodigo())) {
            throw new Exception(estClassEnumMensagensWebbased::webbased015->value);
            return;
        }
        if (!$this->modelPais->isPaisCadastradoByCodigo($this->modelPais->getCodigoPais())) {
            throw new Exception(estClassEnumMensagensWebbased::webbased005->value);
            return;   
        }
        if (!$this->isEstadoPaisValido($this->getEstadoCodigo(), $this->modelPais->getCodigoPais())) {
            throw new Exception(estClassEnumMensagensWebbased::webbased012->value);
            return;
        }

        $this->aChave = $this->getArrayEstadoCodigoColuna();
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
     * Esta função verifica se o Estado já está cadastrado no banco de dados.
     * 
     * @return boolean
     */
    public function isEstadoCadastrado() {
        return $this->isRegistroCadastrado('webbased','tbestado','estadonome',$this->getEstadoNome());
    }


    /**
     * Esta função valida se o Estado está relacionado ao país repassado, assim 
     * evitando erro de FK.
     * 
     * @param int $iCodigoEstado - Código do Estado
     * @param int $iCodigoPais - Código do país
     * @return boolean
     */
    public function isEstadoPaisValido($iCodigoEstado, $iCodigoPais) {
        $aDados = [
            'estadocodigo' => $iCodigoEstado,
            'paiscodigo'   => $iCodigoPais
        ];
        return $this->isRegistroCadastradoSemPK('webbased','tbestado',$aDados);
    }


    /**
     * Este método retorna um array associativo com os dados do Estado.
     * 
     * @param  int  $iLimit
     * @return array
     */
    public function getDadosConsultaEstado($iLimit) {
        $this->setSql($this->getQueryConsultaEstado($iLimit));
        return $this->openFetchAll();
    }


    /**
     * Este método retorna booleano se o Estado está cadastrado
     * conforme código repassado.
     * 
     * @param int $iCodigo
     * @return boolean
     */
    public function isEstadoCadastradoByCodigo($iCodigo) {
        return $this->isRegistroCadastrado('webbased','tbestado','estadocodigo',$iCodigo);
    }

/************************************************** QUERYS *******************************************************
 *****************************************************************************************************************/    
    /**
     * Este método retorna o SQL de consulta de Estado.
     * 
     * @param  int $iLimit
     * @return SQL
     */
    private function getQueryConsultaEstado($iLimit) {
        return "SELECT tbestado.estadocodigo,
                       tbestado.estadonome,
                       tbpais.paiscodigo,   
                       tbpais.paisnome
                  FROM webbased.tbestado
             LEFT JOIN webbased.tbpais
                    ON tbpais.paiscodigo = tbestado.paiscodigo
              ORDER BY estadocodigo
                 LIMIT $iLimit";
    }


    /**
     * Esta função retorna o código do Estado, podendo filtrar qualquer parâmetro.
     * @param string $column
     * @param mixed  $filter
     * 
     * @return int
     */
    public function getQueryCodigoEstado($column, $filter) {
        $this->setSql(
            "SELECT estadocodigo
               FROM webbased.tbestado
              WHERE $column = $1"
        );
        $this->openParams([$filter]);
        $result = $this->getNextRow();
        return $result['estadocodigo'];
    }


    /**
     * Este método retorna SQL de inserção no banco do Estado, utiliza query params.
     * 
     * @return SQL
     */
    private function getQueryInsereEstado() {
        return "INSERT INTO webbased.tbestado 
                VALUES (nextval('webbased.tbestado_estadocodigo_seq'),$1,$2) RETURNING estadocodigo;";
    }


    /**
     * Este método retorna o SQL de delete de Estado.
     * 
     * @return SQL
     */
    private function getQueryDeleteEstado() {
        return "DELETE FROM webbased.tbcidade WHERE estadocodigo = $1";
    }

    
/************************************* GETTERS E SETTERS DOS ATRIBUTOS *******************************************
 *****************************************************************************************************************/  

    public function getEstadoCodigo() {
        return $this->estadoCodigo;
    }

    public function getEstadoNome() {
        return $this->estadoNome;
    }

    public function getCodigoPais() {
        return $this->codigoPais;
    }

    public function setEstadoCodigo($estadoCodigo) {
        $this->estadoCodigo = $estadoCodigo;
    }
    
    public function setEstadoNome($estadoNome) {
        $this->estadoNome = $estadoNome;
    }

    public function setCodigoPais($codigoPais) {
        $this->codigoPais = $codigoPais;
    }

    /**
     * Este método retorna o atributo em forma de array associativo com o nome da coluna no BD.
     */
    public function getArrayEstadoCodigoColuna() {
        return ['estadocodigo' => $this->getEstadoCodigo()];
    }

    /**
     * Este método retorna o atributo em forma de array associativo com o nome da coluna no BD.
     */
    public function getArrayEstadoNomeColuna() {
        return ['estadonome' => $this->getEstadoNome()];
    }


    /**
     * Este método retorna um array associativo com os atributos do Model no formato nome da coluna no BD => valor Atributo.
     * @return array
     */
    public function getModeloColuna() {
        return [
            'estadocodigo' => $this->getEstadoCodigo(),
            'estadonome'   => $this->getEstadoNome(),
            'paiscodigo'   => $this->modelPais->getCodigoPais()
        ];
    }


}

?>