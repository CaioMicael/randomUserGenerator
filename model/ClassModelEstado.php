<?php
namespace model;

use lib\estClassQuery;

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
            $this->setSql(
                "INSERT INTO webbased.tbestado 
                 VALUES (nextval('webbased.tbestado_estadocodigo_seq'),$1,$2) RETURNING estadocodigo;"
            );
            $aDados = array();
            array_push($aDados, $this->getCodigoPais());
            array_push($aDados, $this->getEstadoNome());
            $this->insertAll($aDados);
            $result = $this->getNextRow();
            if (isset($result['estadocodigo'])) {
                $this->setEstadoCodigo($result['estadocodigo']);
            }
        }
        else if ($this->isEstadoCadastrado()) {
            echo 'O Estado ' . $this->getEstadoNome() . ' já está cadastrado!';
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