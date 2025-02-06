<?php
namespace lib\enum;

require_once '../autoload.php';

/**
 * Enum dos códigos das mensagens do package webbased.
 * 
 * @package webbased
 * @author Caio Micael Krieger
 * @since 06/02/2025
 */
enum estClassEnumMensagensWebbased: string {
    case webbased001 = "Selecione pelo menos um registro!";
    case webbased002 = "Não há registros para serem apresentados!";
    case webbased003 = "Ocorreu uma exceção interna no sistema!";
    case webbased004 = "O Estado informado não está cadastrado!";
    case webbased005 = "O País informado não está cadastrado!";
    case webbased006 = "Registro incluído com sucesso!";
    case webbased007 = "País já cadastrado!";
    case webbased008 = "Cidade já cadastrada!";
    case webbased009 = "Estado já cadastrado!";
    case webbased010 = "Pessoa já cadastrada!";
    case webbased011 = "Endereço de pessoa já cadastrado!";
}

?>