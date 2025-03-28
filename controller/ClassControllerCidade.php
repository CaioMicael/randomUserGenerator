<?php
namespace controller;

use lib\estClassController;
use lib\enum\estClassEnumAcoes;
use lib\enum\estClassEnumMensagensWebbased;
use controller\ClassControllerEstado;
use controller\ClassControllerPais;
use Exception;
use Throwable;

require_once '../autoload.php';


class ClassControllerCidade extends estClassController {


    /**
     * Este método busca os dados de cidade do model.
     * 
     * @return array
     */
    private function getDadosConsultaCidadeFromModel() {
        return $this->getModel()->getDadosConsultaCidade(25);
    }

    /**
     * Este método retorna os dados de consulta pessoa tratados.
     * 
     * @return array
     */
    public function getDadosConsultaCidadeController() {
        return $this->trataDadosConsultaCidade($this->getDadosConsultaCidadeFromModel());
    }

    /**
     * Este método é responsável por tratar os dados vindo do model.
     * 
     */
    private function trataDadosConsultaCidade($aDados) {
        $oControllerEstado = new ClassControllerEstado();
        $oControllerPais = new ClassControllerPais();
        $aMapaChave = array_merge($this->getMapaChaveColunasCidade(), 
                                  $oControllerEstado->getMapaChaveColunasEstado(), 
                                  $oControllerPais->getMapaChaveColunasPais());
       return $this->trataDadosConsultaChave($aMapaChave, $aDados);
    }

    /**
     * Este método contém um array com o mapeamento entre a chave do banco
     * e a forma que deve aparecer na view.
     * 
     * @return array
     */
    public function getMapaChaveColunasCidade() {
        return [
            "cidadecodigo" => "Código da Cidade",
            "cidadenome"   => "Nome da Cidade",
            "estadocodigo" => "Código do Estado",
            "paiscodigo"   => "Código do País"
        ];
    }

/***************************************************************************************************************************/
/*************************************             MÉTODOS DE FORMULÁRIO                 ***********************************/
/***************************************************************************************************************************/ 


    /**
     * Este método chama a tela de inclusão de cidade da view.
     * 
     * @return view
     */
    public function getTelaIncluirCidade() {
        return $this->getView()->getTelaIncluirCidade();
    }


    /**
     * Este método retorna a tela de alterar cidade da view.
     * @param array $aDados
     * @return view
     */
    public function getTelaAlterarCidade($aDados) {
        try {
            return $this->getView()->getTelaAlterarCidade($aDados['dados']);
        }
        catch (Throwable $e) {
            return json_encode($this->retornaExceptionFrontEnd($e));
        }
    }


    /**
     * Este método chama a tela de consulta de Cidade da view.
     * 
     * @return HTML
     */
    public function getTelaConsultarCidade() {
        return $this->getView()->getConsultaCidadeView(
            [estClassEnumAcoes::INCLUIR, 
            estClassEnumAcoes::ALTERAR, 
            estClassEnumAcoes::EXCLUIR]);
    }


    /**
     * Recebe os dados de inclusão, trata e envia ao model.
     * 
     * @param array $aDados
     */
    public function processaDadosIncluirCidade($aDados) {
        $sCidadeNome   = strip_tags($aDados['dados']['cidade.nome']);
        $iEstadoCodigo = filter_var($aDados['dados']['estado.codigo'], FILTER_SANITIZE_NUMBER_INT);
        $iPaisCodigo   = filter_var($aDados['dados']['pais.codigo'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $this->getModel()->processaDadosIncluir($sCidadeNome, $iEstadoCodigo, $iPaisCodigo);
            return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased006->value));
        }
        catch(Exception $e) {
           return json_encode($this->retornaExceptionFrontEnd($e));
        }  
    }


    /**
     * Este método recebe o dado selecionado para exclusão e
     * chama o Model para realizar a exclusão.
     */
    public function processaDadosExcluirCidade($aDados) {
        $this->getModel()->processaDadosExcluir($aDados["dados"]);
        return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased013->value));
    }


    /**
     * Este método recebe o dado selecionado para alteração e
     * chama o Model para realizar a alteração.
     */
    public function processaDadosAlterarCidade($aDados) {
        try {
            $this->getModel()->processaDadosAlterar(
                $aDados["dados"]["cidade.codigo"],
                $aDados["dados"]["cidade.nome"],
                $aDados["dados"]["estado.codigo"],
                $aDados["dados"]["pais.codigo"]
            );
            return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased014->value));
        }
        catch (Exception $e) {
            return json_encode($this->retornaExceptionFrontEnd($e));
        }
    }

}


?>