<?php
namespace lib;

use lib\enum\estClassEnumTipoRetorno;

require_once '../autoload.php';


/**
 * Classe utilizada como base para os controllers, contém métodos que são utilizados em todos controllers.
 * 
 * @author Caio Micael Krieger
 */
class estClassController {

    protected array $aRespostaFetch;

    /**
     * Este método é um facilitador, ele trata o retorno do Model 
     * modificando as chaves do array para nomes que devem aparecer na view 
     * conforme mapeamento enviado.
     * 
     * @param array $aMapaChave
     * @param array $aDados
     * @return array
     */
    protected function trataDadosConsultaChave($aMapaChave, $aDados) {
        $aDadosTratado = array();
        foreach($aDados as $aDadosArray) {
            $novoRegistro = [];

            foreach($aDadosArray as $chave => $valor) {
                $novaChave = isset($aMapaChave[$chave]) ? $aMapaChave[$chave] : $chave;
                $novoRegistro[$novaChave] = $valor;
            }
            $aDadosTratado[] = $novoRegistro;
        }
        return $aDadosTratado;
    }


    /**
     * Este método alimenta o array que contém os dados a serem retornados
     * para o front end e retorna o array com o tipo "Sucesso".
     * 
     * @param string $sMensagem
     * @return array
     */
    protected function retornaIncluidoSucessoFrontEnd($sMensagem) {
        $this->setRespostaFetchTipoRetorno(estClassEnumTipoRetorno::SUCESSO->value);
        $this->setRespostaFetchConteudoRetorno(estClassMensagem::geraMensagemSucesso($sMensagem));
        return $this->getRespostaFetch();
    }


    /**
     * Este método alimenta o array que contém os dados a serem retornados
     * para o front end e retorna o array.
     * 
     * @param string $sException
     * @return array
     */
    protected function retornaExceptionFrontEnd($sException) {
        $this->setRespostaFetchTipoRetorno(estClassEnumTipoRetorno::EXCEPTION->value);
        $this->setRespostaFetchConteudoRetorno(estClassMensagem::geraMensagemException($sException));
        return $this->getRespostaFetch();
    }


    /**
     * Esta função serve para incluir no array aRespostaFetch
     * o tipo de retorno conforme EnumTipoRetorno, específico
     * para retornar um tipo para o front end.
     * 
     * @param string $sTipoRetorno
     */
    private function setRespostaFetchTipoRetorno($sTipoRetorno) {
        if (!isset($this->aRespostaFetch['tipo'])) {
            $this->aRespostaFetch['tipo'] = array();
        }
        array_push($this->aRespostaFetch['tipo'], $sTipoRetorno);
    }


    /**
     * Esta função serve para incluir no array aRespostaFetch
     * o conteúdo de retorno (geralmente uma mensagem), específico
     * para retornar um conteúdo para o front end.
     * 
     * @param string $sConteudo
     */
    private function setRespostaFetchConteudoRetorno($sConteudo) {
        if (!isset($this->aRespostaFetch['conteudo'])) {
            $this->aRespostaFetch['conteudo'] = array();
        }
        array_push($this->aRespostaFetch['conteudo'], $sConteudo);
    }


    /**
     * Método abstrato que contém um array que retorna a tipagem
     * HTML das colunas. 
     */
    public function getTipagemCamposToHtml() {
        return array();
    }


    protected function getRespostaFetch() {
        return $this->aRespostaFetch;
    }
}


?>