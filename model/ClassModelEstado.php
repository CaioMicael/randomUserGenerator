<?php
namespace model;

use lib\estClassQuery;
use lib\enum\estClassEnumMensagensWebbased;
use Exception;

require_once '../autoload.php';

class ClassModelEstado extends estClassQuery {
    private int    $estadoCodigo;
    private string $estadoNome;
    private int    $codigoPais;
    
    
    public function __construct() {
        parent::__construct();
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
     * @deprecated
     * Esta função é utilizada para setar o código do Estado no modelo, procurando o mesmo pelo nome no banco de dados.
     * Se o Estado ainda não estiver no banco, ele simplesmente não seta o código no modelo pois ainda não tem um código.
     * 
     * @param string $nomeEstado
     */
    public function setCodigoEstadoByNome($nomeEstado) {
        if ($this->isEstadoCadastrado($nomeEstado)) {
            $this->setSql(
                "SELECT estadocodigo
                   FROM webbased.tbestado
                  WHERE estadonome = '$nomeEstado';"
            );
            $this->Open();
            $result = $this->getNextRow();
            $this->setEstadoCodigo($result['estadocodigo']);
        }
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


    /*************************************************************************************************************************************************************/
    /************************************                                        QUERYs                                        ***********************************/
    /*************************************************************************************************************************************************************/

    
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

    
    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 

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


}

?>