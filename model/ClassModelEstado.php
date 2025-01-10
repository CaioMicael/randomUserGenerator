<?php
namespace model;

use lib\estClassQuery;
use model\ClassModelPais;

require_once 'autoload.php';

class ClassModelEstado extends estClassQuery {
    private int $estadoCodigo;
    private object $modelPais;
    private string $estadoNome;
    
    
    public function __construct() {
        $this->modelPais = new ClassModelPais;
    }



}


?>