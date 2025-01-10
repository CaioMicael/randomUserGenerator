<?php
namespace model;
require_once 'ClassModelEstado.php';

$teste = new ClassModelEstado;
$teste->setAttributeModel('estadoTeste','pais');
echo $teste->isEstadoCadastrado();

?>