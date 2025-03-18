<?php
namespace controller;

use lib\enum\estClassEnumAcoes;
use lib\enum\estClassEnumMensagensWebbased;
use Exception;
use lib\estClassController;
use model\ClassModelEstado;
use view\ClassViewManutencaoEstado;
use Throwable;

require_once '../autoload.php';


class ClassControllerEstado extends estClassController {
    private object $modelEstado;
    private object $controllerPais;
    private object $viewEstado;


    public function __construct() {
        $this->modelEstado    = new ClassModelEstado;
        $this->controllerPais = new ClassControllerPais;
    }


    /**
     * Este método retorna os dados de Estado do Model.
     * 
     * @return array
     */
    private function getDadosConsultaEstadoFromModel() {
        return $this->modelEstado->getDadosConsultaEstado(15);
    }


    /**
     * Esta função realiza o mapeamento entre as chaves do banco e as que devem aparecer na viewEstado.
     * 
     * @param  array $aDados
     * @return array
     */
    private function trataDadosConsultaEstado($aDados) {
        $aMapaChave = array_merge($this->getMapaChaveColunasEstado(),
                                  $this->controllerPais->getMapaChaveColunasPais());
        return $this->trataDadosConsultaChave($aMapaChave, $aDados);
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
    
    
    /**
     * Este método retorna um array com as tipagens
     * do nome da coluna e o type HTML e atributos.
     * 
     * @return array
     */
    public function getTipagemCamposToHtml() {
        return [
            "Código do Estado" => ["name" => "estado.codigo","type"   => "number", "required" => "required", "value" => "", "disabled" => "disabled", "lupa" => false],
            "Nome do Estado"   => ["name" => "estado.nome"  ,"type"   => "text"  , "required" => "required", "value" => "", "disabled" =>         "", "lupa" => false],
            "Código do País"   => ["name" => "pais.codigo"  ,"type"   => "number", "required" => "required", "value" => "", "disabled" =>         "", "lupa" => "Pais"],         
            "Nome do País"     => ["name" => "pais.nome"    ,"type"   => "text"  , "required" => "required", "value" => "", "disabled" =>         "", "lupa" => false]        
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
        $this->viewEstado = new ClassViewManutencaoEstado();
        return $this->viewEstado->getConsultaEstadoView(
            [estClassEnumAcoes::SELECIONAR]
        );
    }


    /**
     * Este método chama a tela de inclusão de cidade da view.
     * 
     * @return view
     */
    public function getTelaIncluirEstado() {
        $this->viewEstado = new ClassViewManutencaoEstado;
        return $this->viewEstado->getTelaIncluirEstado();
    }


    /**
     * Este método retorna a tela de alterar cidade da view.
     * @param array $aDados
     * @return view
     */
    public function getTelaAlterarEstado($aDados) {
        try {
            $this->viewEstado = new ClassViewManutencaoEstado;
            return $this->viewEstado->getTelaAlterarEstado($this->getTipagemCamposToHtml(), $aDados['dados']);
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
        $this->viewEstado = new ClassViewManutencaoEstado;
        return $this->viewEstado->getConsultaEstadoView(
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
            $this->modelEstado->processaDadosIncluir($sEstadoNome, $iPaisCodigo, $sPaisNome);
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
        $this->modelEstado->processaDadosExcluir($aDados["dados"]);
        return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased013->value));
    }


    /**
     * Este método recebe o dado selecionado para alteração e
     * chama o Model para realizar a alteração.
     */
    public function processaDadosAlterarEstado($aDados) {
        try {
            $this->modelEstado->processaDadosAlterar(
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