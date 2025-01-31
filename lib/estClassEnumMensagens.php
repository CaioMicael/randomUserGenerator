<?php
namespace lib;

require_once '../autoload.php';

/**
 * Enum dos códigos das mensagens.
 * 
 */
enum estClassEnumMensagens: string {
    case webbased001 = "Selecione pelo menos um registro!";
    case webbased002 = "Não há registros para serem apresentados!";
}

?>