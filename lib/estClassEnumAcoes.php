<?php
namespace lib;

require_once '../autoload.php';

/**
 * Enum dos códigos das ações.
 * 
 */
enum estClassEnumAcoes: int {
    case INCLUIR = 1;
    case ALTERAR = 2;
    case EXCLUIR = 3;
}

?>