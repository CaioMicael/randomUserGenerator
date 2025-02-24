<?php
namespace lib;

use lib\estClassMensagem;
use lib\enum\estClassEnumMensagensWebbased;
use ErrorException;

require_once '../autoload.php';

/**
 * Classe criada para retornar ao front end erros de warnings do PHP.
 * 
 * @package webbased
 * @author Caio Micael Krieger
 * @since 23/02/2025
 */
class estClassErrorHandler {
    public function __construct() {
        set_error_handler([$this, 'handleError']);
    }

    public function handleError($severity, $message, $file, $line) {
        echo estClassMensagem::geraMensagemException(new ErrorException($message, 0, $severity, $file, $line));
    }
}


?>