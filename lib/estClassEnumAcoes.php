<?php
namespace lib;

require_once '../autoload.php';

/**
 * Enum dos códigos das ações.
 * As ações são utilizadas em parâmetros de requisições
 * para chamar telas específicas dos controllers.
 * Bem como nas views para definir quais botões devem aparecer.
 * 
 */
enum estClassEnumAcoes: int {
    case INCLUIR = 1;
    case ALTERAR = 2;
    case EXCLUIR = 3;
}

?>