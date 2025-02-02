<?php
namespace controller;

use lib\estClassController;
use lib\estClassEnumAcoes;
use model\ClassModelCidade;
use controller\ClassControllerEstado;
use controller\ClassControllerPais;
use Exception;
use lib\estClassMensagem;
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


/***************************************************************************************************************************/
/*************************************             MÉTODOS DE FORMULÁRIO                 ***********************************/
/***************************************************************************************************************************/ 


    /**
     * Este método chama a tela de inclusão de cidade da view.
     * 
     * @return HTML
     */
    public function getTelaIncluirCidade() {
        $this->viewCidade = new ClassViewManutencaoCidade;
        return $this->viewCidade->getTelaIncluirCidade();
    }


    /**
     * Este método chama a tela de consulta de Cidade da view.
     * 
     * @return HTML
     */
    public function getTelaConsultarCidade() {
        $this->viewCidade = new ClassViewManutencaoCidade;
        return $this->viewCidade->getConsultaCidadeView(
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
            $this->modelCidade->processaDadosIncluir($sCidadeNome, $iEstadoCodigo, $iPaisCodigo);
        }
        catch(Exception $e) {
           return estClassMensagem::geraMensagemException($e); 
        }  
    }

}


?>