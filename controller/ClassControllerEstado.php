<?php
namespace controller;

use lib\enum\estClassEnumAcoes;
use lib\enum\estClassEnumMensagensWebbased;
use lib\estClassController;
use model\ClassModelEstado;
use view\ClassViewManutencaoEstado;
use Exception;
use Throwable;

require_once '../autoload.php';

/**
 * Classe Controller do Estado.
 * @package controller
 * @author Caio Micael Krieger
 * @since 17/01/2025
 */
class ClassControllerEstado extends estClassController {


    /**
     * Este método retorna os dados de Estado do Model.
     * 
     * @return array
     */
    private function getDadosConsultaEstadoFromModel() {
        return $this->getModel()->getDadosConsultaEstado(15);
    }

    /**
     * Este método retorna um array com os dados 
     * do Estado tratados, prontos pra view.
     * 
     * @return array
     */
    public function getDadosConsultaEstadoController() {
        return $this->trataDadosConsultaEstado($this->getDadosConsultaEstadoFromModel());
    }

    /**
     * Esta função realiza o mapeamento entre as chaves do banco e as que devem aparecer na viewEstado.
     * 
     * @param  array $aDados
     * @return array
     */
    private function trataDadosConsultaEstado($aDados) {
        $controllerPais = new ClassControllerPais();
        $aMapaChave = array_merge($this->getMapaChaveColunasEstado(),
                                  $controllerPais->getMapaChaveColunasPais());
        return $this->trataDadosConsultaChave($aMapaChave, $aDados);
    }

    
    /**
     * Este método contém um array com o mapeamento entre a chave do banco
     * e a forma que deve aparecer na view.
     * 
     * @return array
     */
    public function getMapaChaveColunasEstado() {
        return [
            "estadocodigo" => "Código do Estado",
            "paiscodigo"   => "Código do País",
            "estadonome"   => "Nome do Estado"
        ];
    } 
    
/***************************************** Métodos de formulário *************************************************
 *****************************************************************************************************************/
    /**
     * Este método retorna a view de Estado com o botão
     * de selecionar registro.
     * 
     * @return HTML
     */
    public function processaDadosSelecionarEstado() {
        return $this->getView()->getConsultaEstadoView(
            [estClassEnumAcoes::SELECIONAR]
        );
    }


    /**
     * Este método chama a tela de inclusão de cidade da view.
     * 
     * @return view
     */
    public function getTelaIncluirEstado() {
        return $this->getView()->getTelaIncluirEstado();
    }


    /**
     * Este método retorna a tela de alterar cidade da view.
     * @param array $aDados
     * @return view
     */
    public function getTelaAlterarEstado($aDados) {
        try {
            return $this->getView()->getTelaAlterarEstado($aDados['dados']);
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
    public function getTelaConsultarEstado() {
        return $this->getView()->getConsultaEstadoView(
            [estClassEnumAcoes::INCLUIR, 
            estClassEnumAcoes::ALTERAR, 
            estClassEnumAcoes::EXCLUIR]);
    }


    /**
     * Recebe os dados de inclusão, trata e envia ao model.
     * 
     * @param array $aDados
     */
    public function processaDadosIncluirEstado($aDados) {
        $sEstadoNome = strip_tags($aDados['dados']['estado.nome']);
        $iPaisCodigo = filter_var($aDados['dados']['pais.codigo'], FILTER_SANITIZE_NUMBER_INT);
        $sPaisNome   = filter_var($aDados['dados']['pais.nome'], FILTER_SANITIZE_NUMBER_INT);

        try {
            $this->getModel()->processaDadosIncluir($sEstadoNome, $iPaisCodigo, $sPaisNome);
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
    public function processaDadosExcluirEstado($aDados) {
        $this->getModel()->processaDadosExcluir($aDados["dados"]);
        return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased013->value));
    }


    /**
     * Este método recebe o dado selecionado para alteração e
     * chama o Model para realizar a alteração.
     */
    public function processaDadosAlterarEstado($aDados) {
        try {
            $this->getModel()->processaDadosAlterar(
                $aDados["dados"]["estado.codigo"],
                $aDados["dados"]["estado.nome"],
                $aDados["dados"]["pais.codigo"],
                $aDados["dados"]["pais.nome"]
            );
            return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased014->value));
        }
        catch (Exception $e) {
            return json_encode($this->retornaExceptionFrontEnd($e));
        }
    }
    
}

?>