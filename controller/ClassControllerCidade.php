<?php
namespace controller;

use lib\estClassController;
use model\ClassModelCidade;
use controller\ClassControllerEstado;
use controller\ClassControllerPais;
use view\ClassViewManutencaoCidade;

require_once '../autoload.php';


class ClassControllerCidade extends estClassController {
    private object $viewCidade;
    private object $modelCidade;
    private object $controllerEstado;
    private object $controllerPais;


    public function __construct() {
        $this->modelCidade      = new ClassModelCidade;
        $this->controllerEstado = new ClassControllerEstado;
        $this->controllerPais   = new ClassControllerPais;
    }


    /**
     * Este método busca os dados de cidade do model.
     * 
     * @return array
     */
    private function getDadosConsultaCidadeFromModel() {
        return $this->modelCidade->getDadosConsultaCidade(25);
    }


    /**
     * Este método é responsável por tratar os dados vindo do model.
     * 
     */
    private function trataDadosConsultaCidade($aDados) {
        $aMapaChave = array_merge($this->getMapaChaveColunasCidade(), 
                                  $this->controllerEstado->getMapaChaveColunasEstado(), 
                                  $this->controllerPais->getMapaChaveColunasPais());
       return $this->trataDadosConsultaChave($aMapaChave, $aDados);
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


    /**
     * Este método contém um array com o mapeamento das colunas
     * que devem aparecer na view com suas devidas tipagens.
     * 
     * @return array
     */
    public function getTipagemColunasCidade() {
        return [
            "Código da Cidade" => "int",
            "Nome da Cidade"   => "string",
            "Código do Estado" => "int",
            "Código do País"   => "int"
        ];
    }


    /**
     * Este método retorna um array com as tipagens
     * do nome da coluna e o type HTML
     * 
     * @return array
     */
    public function getTipagemCamposCidadeToHtml() {
        return [
            "Código da Cidade" => ["name" => "cidade.codigo","type"   => "number", "disabled" => "disabled"],
            "Nome da Cidade"   => ["name" => "cidade.nome"  ,"type"   => "text"  , "disabled" => ""],
            "Código do Estado" => ["name" => "estado.codigo","type"   => "number", "disabled" => ""],
            "Código do País"   => ["name" => "pais.codigo"  ,"type"   => "number", "disabled" => ""]            
        ];
    }


    /**
     * Este método chama a tela de inclusão de cidade da view.
     * 
     * @return HTML
     */
    public function getTelaInclusaoCidadeFromView() {
        $this->viewCidade = new ClassViewManutencaoCidade;
        return $this->viewCidade->getTelaInclusaoCidade();
    }

}


?>