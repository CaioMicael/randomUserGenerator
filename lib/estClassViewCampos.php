<?php
namespace lib;


/**
 * Classe que contém os campos de uma view, podendo ser utilizada em qualquer view e de forma dinâmica, criando os campos
 * desejados de forma mais abstraída e fácil.
 * 
 * @package lib
 * @author Caio Micael Krieger
 * @since 18/03/2025
 */
class estClassViewCampos {
    /**
     * Nome que deve aparecer na label do campo.
     */
    protected string $sNomeLabel;

    /**
     * Tipo do campo em HTML.
     */
    protected string $sTipagem;

    /**
     * Nome do campo em HTML.
     */
    protected string $sNameCampo;

    /**
     * Indica se o campo deve ser desabilitado.
     */
    protected string $sDisabled;

    /**
     * Indica se o campo é obrigatório.
     */
    protected string $sRequired;

    /**
     * Indica se o campo deve ter uma lupa que abre outra view.
     */
    protected mixed $xLupa;

    /**
     * Name do input da lupa.
     */
    protected string $sNameInputLupa;

    public function __construct() {
        $this->setNomeLabel('');
        $this->setTipagem('');
        $this->setNameCampo('');
        $this->setDisabled('');
        $this->setRequired('');
        $this->setLupa('');
        $this->setNameInputLupa('');
    }

    /**
     * Função que adiciona os campos na view.
     */
    protected function addCampo():estClassViewCampos {
        return new estClassViewCampos();
    }

    /**
     * Retorna os campos da tela de inclusão.
     * @return array - array com os campos
     */
    protected function getCamposInclusao(){}

    /**
     * Retorna os campos da tela de alteração.
     * @return array - array com os campos
     */
    protected function getCamposAlteracao(){}

    /**
     * Retorna o nome da label
     * @return string
     */
    protected function getNomeLabel() {
        return $this->sNomeLabel;
    }

    /**
     * Define o nome da label
     * @param string $sNomeLabel
     * @return self
     */
    protected function setNomeLabel(string $sNomeLabel): self {
        $this->sNomeLabel = $sNomeLabel;
        return $this;
    }

    /**
     * Retorna o tipo do campo HTML
     * @return string
     */
    protected function getTipagem(): string {
        return $this->sTipagem;
    }

    /**
     * Define o tipo do campo HTML
     * @param string $sTipagem
     * @return self
     */
    protected function setTipagem(string $sTipagem): self {
        $this->sTipagem = $sTipagem;
        return $this;
    }

    /**
     * Retorna o name do campo HTML
     * @return string
     */
    protected function getNameCampo(): string {
        return $this->sNameCampo;
    }

    /**
     * Define o name do campo HTML
     * @param string $sNameCampo
     * @return self
     */
    protected function setNameCampo(string $sNameCampo): self {
        $this->sNameCampo = $sNameCampo;
        return $this;
    }

    /**
     * Verifica se o campo está desabilitado
     * @return string
     */
    protected function getDisabled(): string {
        return $this->sDisabled;
    }

    /**
     * Define se o campo deve ser desabilitado
     * @param string $sDisabled - passar 'disabled' para desabilitar.
     * @return self
     */
    protected function setDisabled(string $sDisabled): self {
        $this->sDisabled = $sDisabled;
        return $this;
    }

    /**
     * Verifica se o campo é obrigatório
     * @return string
     */
    protected function getRequired(): string {
        return $this->sRequired;
    }

    /**
     * Define se o campo é obrigatório
     * @param string $sRequired - passar 'required' para tornar o campo obrigatório.
     * @return self
     */
    protected function setRequired(string $sRequired): self {
        $this->sRequired = $sRequired;
        return $this;
    }

    /**
     * Retorna se o campo deve ter uma lupa
     * @return mixed
     */
    protected function getLupa(): mixed {
        return $this->xLupa;
    }

    /**
     * Define se o campo deve ter uma lupa
     * @param mixed $xLupa
     * @return self
     */
    protected function setLupa(mixed $xLupa): self {
        $this->xLupa = $xLupa;
        return $this;
    }

    /**
     * Retorna o nome do input da lupa
     * @return string
     */
    protected function getNameInputLupa(): string {
        return $this->sNameInputLupa;
    }

    /**
     * Define o nome do input da lupa
     * @param string $sNameInputLupa
     * @return self
     */
    protected function setNameInputLupa(string $sNameInputLupa): self {
        $this->sNameInputLupa = $sNameInputLupa;
        return $this;
    }
}