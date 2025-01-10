<?php
namespace lib;

require_once '../autoload.php';

class estClassSession {

    private static $instance;
    
    private $sessionID;

    private function __construct() {
        session_start();
        if(($this->getSessionStarted()) & (session_status() == PHP_SESSION_ACTIVE)) {
           $this->sessionID = $_COOKIE['PHPSESSID']; 
        }
    }

    static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new estClassSession(); 
        }
        return self::$instance;
    }
    
    public static function getSessionStarted() {
        return isset($_COOKIE['PHPSESSID']);
    }    
    
    public function finalizeSession() {
        session_unset();
        session_write_close();
    }
            
    
    public function setValue($nome, $valor) {
        $_SESSION[$nome] = $valor;
    }
    

    public function getValue($nome) {
        if(isset($_SESSION[$nome])) {
            return $_SESSION[$nome];
        }
    }
    
    function getSessionID() {
        return $this->sessionID;
    }
    

    public function addObject($nome, $oObject) {
        if(!$this->getValue($nome)) {
            $this->setValue($nome, serialize($oObject));
        }
    }
    

    public function getObject($nome) {
        return unserialize($this->getValue($nome));
    }
    
}