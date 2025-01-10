<?php
namespace model;

use lib\estClassQuery;
use model\ClassModelPais;

require_once '../autoload.php';

class ClassModelEstado extends estClassQuery {
    private int $estadoCodigo;
    private object $modelPais;
    private string $estadoNome;
    
    
    public function __construct() {
        parent::__construct();
        $this->modelPais = new ClassModelPais;
    }


    /**
     * Esta função seta os atributos do model.
     * 
     * @param string $estadoNome
     * @param string $nomePais
     */
    public function setAttributeModel($estadoNome, $nomePais) {
        $this->setEstadoNome($estadoNome);
        $this->modelPais->setAttributeModel($nomePais);
    }


    public function insereEstado() {
        if (!$this->isEstadoCadastrado()) {
            $this->setSql(
                "INSERT INTO webbased.tbestado 
                 VALUES (nextval('webbased.tbestado_estadocodigo_seq'),$1,$2);"
            );
            $aDados = array();
            array_push($aDados, $this->modelPais->getCodigoPais());
            array_push($aDados, $this->getEstadoNome());
            $this->insertAll($aDados);
        }
    }


    /**
     * Esta função verifica se o Estado já está cadastrado no banco de dados.
     * 
     * @return boolean
     */
    public function isEstadoCadastrado() {
        return $this->isRegistroCadastrado('webbased','tbestado','estadonome',$this->getEstadoNome(),true);
    }

    
    public function getEstadoCodigo() {
        return $this->estadoCodigo;
    }

    public function getEstadoNome() {
        return $this->estadoNome;
    }
    
    public function setEstadoNome($estadoNome) {
        $this->estadoNome = $estadoNome;
    }


}

?>