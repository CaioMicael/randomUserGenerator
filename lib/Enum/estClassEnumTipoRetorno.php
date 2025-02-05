<?php
namespace lib\enum;
require_once '../autoload.php';


/**
 * Enum dos tipos de retornos que devem ser feitos
 * ao front end, em casos de exceções, sucessos, etc.
 * 
 * @author Caio Micael Krieger
 * @since 04/02/2025
 */
enum estClassEnumTipoRetorno: string {
    case EXCEPTION = "exception";
    case ALERTA    = "alerta";
}

?>