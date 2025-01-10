<?php
namespace model;

use lib\estClassQuery;

require_once '../autoload.php';


class ClassModelCidade extends estClassQuery {
    private int    $cidadeCodigo;
    private string $cidadeNome;
    private int    $estadoCodigo;
    private int    $paisCodigo;


    public function setAttributeModelCidade($cidadeNome, $estadoCodigo, $paisCodigo) {
        $this->setCidadeNome($cidadeNome);
        $this->setEstadoCodigo($estadoCodigo);
        $this->setPaisCodigo($paisCodigo);
    }


    public function insereCidade() {

    }


    public function setCodigoCidadeByNome() {
        
    }


    public function getCidadeCodigo() {
        return $this->cidadeCodigo;
    }

    public function getCidadeNome() {
        return $this->cidadeNome;
    }

    public function getEstadoCodigo() {
        return $this->estadoCodigo;
    }

    public function getPaisCodigo() {
        return $this->paisCodigo;
    }

    public function setCidadeCodigo($cidadeCodigo) {
        $this->cidadeCodigo = $cidadeCodigo;
    }

    public function setCidadeNome($cidadeNome) {
        $this->cidadeNome = $cidadeNome;
    }

    public function setEstadoCodigo($estadoCodigo) {
        $this->estadoCodigo = $estadoCodigo;
    }

    public function setPaisCodigo($paisCodigo) {
        $this->paisCodigo = $paisCodigo;
    }
}


?>