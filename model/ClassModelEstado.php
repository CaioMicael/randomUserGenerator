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
        $this->modelPais->setNomePais($nomePais);
    }


    public function insereEstado() {

    }


    /**
     * Esta função verifica se o Estado já está cadastrado no banco de dados.
     * 
     * @return boolean
     */
    public function isEstadoCadastrado() {
        $this->setSql(
            "SELECT EXISTS (
                            SELECT *
                              FROM webbased.tbestado
                             WHERE estadonome = '$this->estadoNome');"
        );
        $result = $this->openFetchAll();
        if ($result[0]['exists'] == 't') {
            return true;
        }
        else {
            return false;
        }
    }

    
    public function getEstadoCodigo() {
        return $this->estadoCodigo;
    }

    public function getEstadoNome() {
        $this->estadoNome;
    }
    
    public function setEstadoNome($estadoNome) {
        $this->estadoNome = $estadoNome;
    }


}

$teste = new ClassModelEstado;
$teste->setAttributeModel('estadoTeste','pais');
echo $teste->isEstadoCadastrado();

?>