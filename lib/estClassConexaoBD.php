<?php

/**
 * Classe utilizada para realizar a conexão
 * com o banco de dados.
 * 
 * @author Caio Micael Krieger
 */
class estClassConexaoBD {
    private $host;
    private $porta;
    private $user;
    private $password;
    private $database;
    private $internalConnection;
    /**
     * Este atributo contém as informações de conexão ao banco de dados.
     * @var array $aConnectionString
     */
    private $aConnectionString;

    public function __construct()   {
        $this->setConnectionString();
        $this->setPorta($this->aConnectionString['porta']);
        $this->setHost($this->aConnectionString['host']);
        $this->setUser($this->aConnectionString['user']);
        $this->setPassword($this->aConnectionString['password']);
        $this->setDatabase($this->aConnectionString['database']);
    }

    /**
     * Este método realiza a leitura do arquivo .env de conexão com 
     * o banco de dados e envia para o método construtor.
     * 
     */
    private function setConnectionString() {
        $fileEnv = __DIR__ .'\.env\db.env';

        if (file_exists($fileEnv)) {
            $this->aConnectionString = [];
            $connectionString  = explode(',',file_get_contents($fileEnv));
            foreach($connectionString as $con) {
                list($key,$value) = explode('=' , trim($con));
                $this->aConnectionString[trim($key)] = trim($value);
            }
        }
        else {
            echo 'Não foi possível conectar ao banco de dados!';
        }
    }


    /**
     * Este método realiza a busca dos atributos para conexão ao banco de dados.
     * 
     * @return string
     */
    private function getConnectionString() {
        return "host= "      . $this->getHost() . 
               " port= "     . $this->getPorta() . 
               " user= "     . $this->getUser() . 
               " password= " . $this->getPassword() .
               " dbname= "   . $this->getDatabase();
    }


    /**
     * Este método realiza a conexão com o banco de dados.
     * 
     * @return boolean
     */
    public function conectaDB() {
        try {
            $this -> internalConnection = pg_connect($this->getConnectionString());
            if ($this->internalConnection) {
                return true;
            }
        } catch (\Throwable $e) {
            return false;
        }

    }

    public function getHost() {
        return $this->host;
    }

    public function getPorta() {
        return $this->porta;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getInternalConnection() {
        return $this->internalConnection;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setPorta($porta) {
        $this->porta = $porta;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setPassword($pass) {
        $this->password = $pass;
    }

    public function setDatabase($database) {
        $this->database = $database;
    }

}

?>