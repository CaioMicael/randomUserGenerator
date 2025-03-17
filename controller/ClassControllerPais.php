<?php
namespace controller;

use lib\estClassController;
use lib\enum\estClassEnumAcoes;
use lib\enum\estClassEnumMensagensWebbased;
use model\ClassModelPais;
use view\ClassViewManutencaoPais;
use Exception;
use Throwable;

require_once '../autoload.php';


class ClassControllerPais extends estClassController {
    private object $modelPais;
    private object $viewPais;


    public function __construct() {
        $this->modelPais = new ClassModelPais;
    }


    /**
     * Este método retorna os dados de Estado do Model.
     * 
     * @return array
     */
    private function getDadosConsultaPaisFromModel() {
        return $this->modelPais->getDadosConsultaPais(15);
    }


    /**
     * Este método retorna um array com os dados 
     * do Estado tratados, prontos pra view.
     * 
     * @return array
     */
    public function getDadosConsultaPaisController() {
        return $this->trataDadosConsultaChave($this->getMapaChaveColunasPais(),$this->getDadosConsultaPaisFromModel());
    }
    

    /**
     * Este método contém um array com o mapeamento entre a chave do banco
     * e a forma que deve aparecer na view.
     * 
     * @return array
     */
    public function getMapaChaveColunasPais() {
        return [
            "paiscodigo" => "Código do País",
            "paisnome"   => "Nome do País"
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
            "Código do País"   => ["name" => "pais.codigo"  ,"type"   => "number", "required" => "required", "value" => "", "disabled" =>         "disabled", "lupa" => "Pais"],         
            "Nome do País"     => ["name" => "pais.nome"    ,"type"   => "text"  , "required" => "required", "value" => "", "disabled" =>         "", "lupa" => false]        
        ];
    }

/***************************************** Métodos de formulário *************************************************
 *****************************************************************************************************************/
    /**
     * Este método retorna a view de País com o botão
     * de selecionar registro.
     * 
     * @return HTML
     */
    public function processaDadosSelecionarPais() {
        $this->viewPais = new ClassViewManutencaoPais();
        return $this->viewPais->getConsultaPaisView(
            [estClassEnumAcoes::SELECIONAR]
        );
    }


        /**
     * Este método chama a tela de inclusão de País da view.
     * 
     * @return view
     */
    public function getTelaIncluirPais() {
        $this->viewPais = new ClassViewManutencaoPais;
        return $this->viewPais->getTelaIncluirPais($this->getTipagemCamposToHtml());
    }


    /**
     * Este método retorna a tela de alterar País da view.
     * @param array $aDados
     * @return view
     */
    public function getTelaAlterarPais($aDados) {
        try {
            $this->viewPais = new ClassViewManutencaoPais;
            return $this->viewPais->getTelaAlterarPais($this->getTipagemCamposToHtml(), $aDados['dados']);
        }
        catch (Throwable $e) {
            return json_encode($this->retornaExceptionFrontEnd($e));
        }
    }


    /**
     * Recebe os dados de inclusão, trata e envia ao model.
     * 
     * @param array $aDados
     */
    public function processaDadosIncluirPais($aDados) {
        $sPaisNome   = filter_var($aDados['dados']['pais.nome'], FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $this->modelPais->processaDadosIncluir($sPaisNome);
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
    public function processaDadosExcluirPais($aDados) {
        $this->modelPais->processaDadosExcluir($aDados["dados"]);
        return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased013->value));
    }


    /**
     * Este método recebe o dado selecionado para alteração e
     * chama o Model para realizar a alteração.
     */
    public function processaDadosAlterarPais($aDados) {
        try {
            $this->modelPais->processaDadosAlterar(
                $aDados["dados"]["pais.codigo"],
                $aDados["dados"]["pais.nome"]
            );
            return json_encode($this->retornaIncluidoSucessoFrontEnd(estClassEnumMensagensWebbased::webbased014->value));
        }
        catch (Exception $e) {
            return json_encode($this->retornaExceptionFrontEnd($e));
        }
    }


    /**
     * Este método retorna a view de País com
     * os botões padrão de tela de consultar.
     * 
     * @return HTML
     */
    public function getTelaConsultarPais() {
        $this->viewPais = new ClassViewManutencaoPais();
        return $this->viewPais->getConsultaPaisView(
            [estClassEnumAcoes::INCLUIR, 
            estClassEnumAcoes::ALTERAR, 
            estClassEnumAcoes::EXCLUIR]
        );
    }


}


?>