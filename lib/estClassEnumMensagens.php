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
    case webbased003 = "Ocorreu uma exceção interna no sistema!";
    case webbased004 = "O Estado informado não está cadastrado!";
    case webbased005 = "O País informado não está cadastrado!";
}

?>