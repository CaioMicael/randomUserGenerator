<?php
namespace controller;

use lib\estClassController;
use lib\enum\estClassEnumAcoes;
use model\ClassModelPais;
use view\ClassViewManutencaoPais;

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
    public function getDadosTratadoConsultaPaisController() {
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


/***************************************************************************************************************************/
/*************************************             MÉTODOS DE FORMULÁRIO                 ***********************************/
/***************************************************************************************************************************/


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