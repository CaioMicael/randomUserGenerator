<?php
namespace lib\estClassModelBoProcess;

use lib\enum\estClassEnumMensagensLib;
use lib\estClassMensagem;

require_once '../autoload.php';

/**
 * Classe base para os processos de negócio do Model.
 * @package lib
 * @author Caio Micael Krieger
 * @since 14/04/2025
 */
class estClassModelBoProcess {

    protected $Model;

    /**
     * Método executado antes de processar a inclusão de dados.
     */
    protected function beforeProcessaDadosIncluir() {}

    /**
     * Método executado para processar a inclusão de dados do modelo.
     */
    protected function processaDadosIncluir() {

    }

    /**
     * Método executado após processar a inclusão de dados.
     */
    protected function afterProcessaDadosIncluir() {}


    /**
     * Método executado antes de processar a alteração de dados.
     */
    protected function beforeProcessaDadosAlterar() {}

    /**
     * Método executado para processar a alteração de dados.
     */
    protected function processaDadosAlterar() {

    }
    
    /**
     * Método executado após processar a alteração de dados do modelo.
     */
    protected function afterProcessaDadosAlterar(){}
    
    
    /**
     * Método executado antes de processar a exclusão de dados.
     */
    protected function beforeProcessaDadosExcluir(){}

    /**
     * Método executado para processar a exclusão de dados do modelo.
     */
    protected function processaDadosExcluir() {
        $this->beforeProcessaDadosExcluir();

        if (isset($this->getModel()->getChave())) {
            $this->getModel()->doExcluirRegistro();
            $this->afterProcessaDadosExcluir();
            return;
        }
        
        return estClassMensagem::geraMensagemAlertaTela(estClassEnumMensagensLib::lib001);
    }
    
    /**
     * Método executado após processar a exclusão de dados.
     */
    protected function afterProcessaDadosExcluir(){}
    
    
    /**
     * Método executado antes de processar a consulta de dados.
     */
    protected function beforeProcessaDadosConsultar(){}

    /**
     * Método executado para processar a consulta de dados.
     */
    protected function processaDadosConsultar() {

    }
    
    /**
     * Método executado após processar a consulta de dados.
     */
    protected function afterProcessaDadosConsultar(){}

    /**
     * Retorna o Modelo associado a este processo de negócio.
     * @return Model
     */
    protected function getModel() {
        if (! isset($this->Model)) {
            $this->getInstanceModel();
        }
        return $this->Model;
    }

    /**
     * Retorna uma nova instância do modelo associado a este processo de negócio.
     * @return Model
     */
    protected function getInstanceModel() {
        $ModelClassName = get_class($this);
        // Extrair somente o nome da classe sem o namespace
        $parts = explode('\\', $ModelClassName);
        $simpleClassName = end($parts);
        $modelClassName = str_replace('BoProcess', '', $simpleClassName);
        // Adicionar o namespace correto para models
        $fullyQualifiedModelName = 'model\\' . $modelClassName;
        
        return new $fullyQualifiedModelName();
    }
}