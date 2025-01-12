<?php
namespace model;

use lib\estClassQuery;

require_once '../autoload.php';

class ClassModelPessoaEndereco extends estClassQuery {
    private int    $pesenderecocodigo;
    private string $rua;
    private int    $numero;
    private string $latitude;
    private string $longitude;
    private object $modelCidade;
    private object $modelPessoa;


    public function setAttributeModel() {
        
    }

}

?>