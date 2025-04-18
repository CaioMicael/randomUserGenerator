<?php
namespace model;

use lib\estClassQuery;
use lib\enum\estClassEnumMensagensWebbased;
use Exception;

require_once '../autoload.php';

/**
 * Classe utilizada para tratar dados e consultar dados de endereços de pessoas.
 * @package model
 * @author Caio Micael Krieger
 * @since 08/01/2025
 */
class ClassModelPessoaEndereco extends estClassQuery {
    private int    $pesEnderecoCodigo;
    private string $rua;
    private int    $numeroEndereco;
    private string $latitude;
    private string $longitude;

    /** @var ClassModelCidade */
    private object $Cidade;

    /** @var ClassModelPessoa */
    private object $Pessoa;


    /**
     * Este método define os atributos do model.
     * 
     * @param string $rua
     * @param int    $numero
     * @param string $latitude
     * @param string $longitude
     * @param object $modelCidade
     * @param object $modelPessoa
     */
    public function setAttributeModel($rua, $numero, $latitude, $longitude) {
        $this->setRua($rua);
        $this->setNumeroEndereco($numero);
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }


    /**
     * Este método insere o endereço da pessoa no banco de dados.
     * 
     */
    public function inserePessoaEndereco() {
        if (!$this->isEnderecoCadastrado()) {
            $this->setSql($this->getQueryInsertPessoaEndereco());
            $this->insertAll([$this->getCidade()->getCidadeCodigo(),
                              $this->getRua(),
                              $this->getNumeroEndereco(),
                              $this->getLatitude(),
                              $this->getLongitude(),
                              $this->getPessoa()->getPescodigo()]);
            $result = $this->getNextRow();
            if (isset($result['pesenderecocodigo'])) {
                $this->setPesEnderecoCodigo($result['pesenderecocodigo']);
            }
        }
        else {
            throw new Exception(estClassEnumMensagensWebbased::webbased011->value);
            return;
        }

    }


    /**
     * Este método verifica se o endereço já está cadastrado pela latitude e longitude.
     * 
     * @return boolean
     */
    private function isEnderecoCadastrado() {
        $aDados = array (
            'pesenderecolatitude'  => $this->getLatitude(),
            'pesenderecolongitude' => $this->getLongitude()
        );
        return $this->isRegistroCadastradoSemPK('webbased','tbpessoaendereco',$aDados);
    }


    /**
     * Este método retorna os dados da consulta de pessoa endereço.
     * 
     * @param int $iLimit
     * @return array
     */
    public function getDadosConsultaEndereco($iLimit) {
        $this->setSql($this->getQueryConsultaEndereco($iLimit));
        return $this->openFetchAll();
    }


    /*************************************************************************************************************************************************************/
    /************************************                                        QUERYs                                        ***********************************/
    /*************************************************************************************************************************************************************/


    /**
     * Este método retorna a query de inserção de endereço de pessoa no banco.
     * 
     * @return SQL
     */
    public function getQueryInsertPessoaEndereco() {
        return "INSERT INTO webbased.tbpessoaendereco
                VALUES (nextval('webbased.tbpessoaendereco_pesenderecocodigo_seq'),$1,$2,$3,$4,$5,$6) RETURNING pesenderecocodigo;";
    }


    /**
     * Este método retorna o SQL da consulta de endereços.
     * 
     * @param int $iLimit
     * @return SQL
     */
    private function getQueryConsultaEndereco($iLimit) {
        return "   SELECT tbpessoa.pescodigo,
	                      pesnome,
	                      paisnome,
	                      estadonome,
	                      cidadenome,
	                      pesenderecorua,
	   	                  pesenderonumero,
	   	                  pesenderecolatitude,
	                      pesenderecolongitude
                     FROM webbased.tbpessoaendereco 
                LEFT JOIN webbased.tbpessoa
                       ON tbpessoa.pescodigo = tbpessoaendereco.pescodigo
                LEFT JOIN webbased.tbcidade 
                       ON tbcidade.cidadecodigo = tbpessoaendereco.cidadecodigo
                LEFT JOIN webbased.tbestado
                       ON tbestado.estadocodigo = tbcidade.estadocodigo
                LEFT JOIN webbased.tbpais 
                       ON tbpais.paiscodigo = tbcidade.cidadecodigo
                 ORDER BY tbpessoa.pescodigo
                    LIMIT $iLimit";
    }


    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 

    public function getPesEnderecoCodigo() {
        return $this->pesEnderecoCodigo;
    }

    public function getRua() {
        return $this->rua;
    }

    public function getNumeroEndereco() {
        return $this->numeroEndereco;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Este método retorna o modelo de cidade.
     * @return ClassModelCidade
     */
    public function getCidade(): ClassModelCidade {
        if (! isset($this->Cidade)) {
            $this->setCidade(new ClassModelCidade());
        }
        return $this->Cidade;
    }

    /**
     * Este método retorna o modelo de pessoa.
     * @return ClassModelPessoa
     */
    public function getPessoa(): ClassModelPessoa {
        if (! isset($this->Pessoa)) {
            $this->setPessoa(new ClassModelPessoa());
        }
        return $this->Pessoa;
    }

    public function setPesEnderecoCodigo($enderecoCodigo) {
        $this->pesEnderecoCodigo = $enderecoCodigo;
    }

    public function setRua($rua) {
        $this->rua = $rua;
    }

    public function setNumeroEndereco($numeroEndereco) {
        $this->numeroEndereco = $numeroEndereco;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    /**
     * Este método define o modelo de cidade.
     * @param ClassModelCidade $modelCidade
     */
    private function setCidade(ClassModelCidade $modelCidade) {
        $this->Cidade = $modelCidade;
    }

    /**
     * Este método define o modelo de pessoa.
     * @param ClassModelPessoa $modelPessoa
     */
    private function setPessoa(ClassModelPessoa $modelPessoa) {
        $this->Pessoa = $modelPessoa;
    }
    



}

?>