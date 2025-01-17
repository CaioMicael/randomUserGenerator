<?php
namespace model;

use lib\estClassQuery;

require_once '../autoload.php';

/**
 * Classe utilizada para tratar dados e consultar dados de pessoas.
 * 
 * @author Caio Micael Krieger
 */
class ClassModelPessoa extends estClassQuery {
    private int    $pescodigo;
    private string $seed;
    private string $genero;
    private string $nomePessoa;
    private string $emailPessoa;
    private string $telefonePessoa;
    private string $celularPessoa;


    /**
     * Este método seta os atributos do model.
     * 
     * @param int    $pescodigo
     * @param string $seed
     * @param string $genero
     * @param string $nomePessoa
     * @param string $emailPessoa
     * @param string $telefonePessoa
     * @param string $celularPessoa
     */
    public function setAttributeModel($seed, $genero, $nomePessoa, $emailPessoa, $telefonePessoa, $celularPessoa) {
        $this->setSeed($seed);
        $this->setGenero($genero);
        $this->setnomePessoa($nomePessoa);
        $this->setEmailPessoa($emailPessoa);
        $this->setTelefonePessoa($telefonePessoa);
        $this->setCelularPessoa($celularPessoa);
    }


    /**
     * Esta função realiza a inserção de pessoa no banco de dados.
     * 
     */
    public function inserePessoa() {
        if (!$this->isPessoaJaCadastrada($this->seed)) {
            $this->setSql($this->getQueryInserePessoa());
            $this->insertAll([
                $this->getSeed(),
                $this->getGenero(),
                $this->getNomePessoa(),
                $this->getEmailPessoa(),
                $this->getTelefonePessoa(),
                $this->getCelularPessoa()
            ]);
            $result = $this->getNextRow();
            if (isset($result['pescodigo'])) {
                $this->setPescodigo($result['pescodigo']);
            }
        }
        else {
            echo 'A Pessoa '. $this->nomePessoa . ' já está cadastrada.';
        }
    }


    /**
     * Esta função verifica pelo seed se a pessoa já está inserida no banco de dados.
     * 
     * @param string $seed
     * @return boolean
     */
    public function isPessoaJaCadastrada($seed) {
        $this->isRegistroCadastrado('webbased','tbpessoa','seed',$seed);
    }


    /**
     * Este método busca a pessoa pelo seed e retorna os dados da pessoa.
     * 
     * @param string $seed
     * @return array 
     */
    public function getPessoaBySeed($seed) {
        $this->setSql(
            "SELECT *
               FROM webbased.tbpessoa
              WHERE seed = '$seed';"
        );
        $result = $this->openFetchAll();
        return $result;
    }
    

    /**
     * Este método retorna um array associativo dos dados de pessoas.
     * 
     * @param int $iLimit
     * @return array
     */
    public function getDadosConsultaPessoa($iLimit) {
        $this->setSql($this->getQueryConsultaPessoa($iLimit));
        return $this->openFetchAll();
    }


    /*************************************************************************************************************************************************************/
    /************************************                                        QUERYs                                        ***********************************/
    /*************************************************************************************************************************************************************/

    
    /**
     * Este método retorna o SQL de insert de pessoa.
     * 
     * @return SQL
     */
    private function getQueryInserePessoa() {
        return "INSERT INTO webbased.tbpessoa
                VALUES (nextval('webbased.tbpessoa_pescodigo_seq'),$1,$2,$3,$4,$5,$6) RETURNING pescodigo";
    }


    /**
     * Este método retorna o SQL pegando todos os dados de pessoa por um limit.
     * 
     * @param int $iLimit
     * @return SQL
     */
    private function getQueryConsultaPessoa($iLimit) {
        return "SELECT *
                  FROM webbased.tbpessoa
                 LIMIT $iLimit;";
    }


    /**************************************************************************************************************************************************************/
    /*************************************                           GETTERS E SETTERS DOS ATRIBUTOS                            ***********************************/
    /**************************************************************************************************************************************************************/ 
    
    public function getPescodigo() {
        return $this->pescodigo;
    }

    public function getSeed() {
        return $this->seed;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getNomePessoa() {
        return $this->nomePessoa;
    }

    public function getEmailPessoa() {
        return $this->emailPessoa;
    }

    public function getTelefonePessoa() {
        return $this->telefonePessoa;
    }

    public function getCelularPessoa() {
        return $this->celularPessoa;
    }

    public function setPescodigo($pescodigo) {
        $this->pescodigo = $pescodigo;
    }

    public function setSeed($seed) {
        $this->seed = $seed;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function setnomePessoa($nome) {
        $this->nomePessoa = $nome;
    }

    public function setEmailPessoa($email) {
        $this->emailPessoa = $email;
    }    

    public function setTelefonePessoa($telefone) {
        $this->telefonePessoa = $telefone;
    }    

    public function setCelularPessoa($celular) {
        $this->celularPessoa = $celular;
    }    

}

?>